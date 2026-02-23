<?php

namespace App\Livewire\Admin\Programs;

use App\Models\Program;
use App\Models\Degree;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public ?Program $program = null;
    public string $name_en = '';
    public string $name_tr = '';
    public ?int $degree_id = null;
    public ?int $faculty_id = null;
    public ?int $price_per_year = null;
    public bool $study_language_en = true;
    public bool $study_language_tr = false;

    public function mount(?Program $program = null)
    {
        $this->program = $program;
        if ($program) {
            $this->program->load(['translations', 'studyLanguages']);
            $this->loadProgramData($this->program);
        }
    }

    #[On('edit-program')]
    public function loadProgram($programId)
    {
        $this->program = Program::with(['translations', 'studyLanguages'])->findOrFail($programId);
        $this->loadProgramData($this->program);
        $this->resetValidation();
    }

    protected function loadProgramData(Program $program)
    {
        $this->degree_id = $program->degree_id;
        $this->faculty_id = $program->faculty_id;
        $this->price_per_year = $program->price_per_year;

        // Load translations (case-insensitive)
        $enTranslation = $program->translations->filter(function ($translation) {
            return strtolower($translation->language) === 'en';
        })->first();
        $trTranslation = $program->translations->filter(function ($translation) {
            return strtolower($translation->language) === 'tr';
        })->first();
        
        $this->name_en = $enTranslation?->name ?? $program->name ?? '';
        $this->name_tr = $trTranslation?->name ?? '';

        // Load study languages
        $enStudyLang = $program->studyLanguages->filter(function ($lang) {
            return strtolower($lang->language) === 'en';
        })->first();
        $trStudyLang = $program->studyLanguages->filter(function ($lang) {
            return strtolower($lang->language) === 'tr';
        })->first();

        $this->study_language_en = $enStudyLang?->is_available ?? true;
        $this->study_language_tr = $trStudyLang?->is_available ?? false;

    }

    public function updatedDegreeId()
    {
        // Degree seçiləndə faculty_id-ni reset et
        $this->faculty_id = null;
    }

    protected function rules()
    {
        return [
            'name_en' => ['required', 'string', 'max:255'],
            'name_tr' => ['required', 'string', 'max:255'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'price_per_year' => ['required', 'integer', 'min:0'],
            'study_language_en' => ['boolean'],
            'study_language_tr' => ['boolean'],
        ];
    }

    protected function messages()
    {
        return [
            'name_en.required' => 'Proqram adı (EN) mütləqdir.',
            'name_en.max' => 'Proqram adı (EN) maksimum 255 simvol ola bilər.',
            'name_tr.required' => 'Proqram adı (TR) mütləqdir.',
            'name_tr.max' => 'Proqram adı (TR) maksimum 255 simvol ola bilər.',
            'degree_id.required' => 'Dərəcə seçilməlidir.',
            'degree_id.exists' => 'Seçilmiş dərəcə mövcud deyil.',
            'faculty_id.required' => 'Fakültə seçilməlidir.',
            'faculty_id.exists' => 'Seçilmiş fakültə mövcud deyil.',
            'price_per_year.required' => 'İllik qiymət mütləqdir.',
            'price_per_year.integer' => 'İllik qiymət rəqəm olmalıdır.',
            'price_per_year.min' => 'İllik qiymət 0-dan kiçik ola bilməz.',
        ];
    }

    public function update()
    {
        if (!$this->program) {
            return;
        }

        $this->validate();

        // Unique constraint yoxla (current program-ni istisna et, name_en-ə görə)
        // $exists = Program::where('degree_id', $this->degree_id)
        //     ->where('faculty_id', $this->faculty_id)
        //     ->where('name', $this->name_en)
        //     ->where('id', '!=', $this->program->id)
        //     ->exists();

        // if ($exists) {
        //     $this->addError('name_en', 'Bu dərəcə və fakültə üçün bu proqram adı (EN) artıq mövcuddur.');
        //     return;
        // }

        DB::transaction(function () {
            // Update programs table with EN name
            $this->program->update([
                'name' => $this->name_en,
                'degree_id' => $this->degree_id,
                'faculty_id' => $this->faculty_id,
                'price_per_year' => $this->price_per_year,
            ]);

            // Update or create EN translation (case-insensitive search)
            $enTranslation = $this->program->translations()
                ->whereRaw('LOWER(language) = ?', ['en'])
                ->first();
            if ($enTranslation) {
                $enTranslation->update(['name' => $this->name_en]);
            } else {
                $this->program->translations()->create([
                    'language' => 'en',
                    'name' => $this->name_en,
                ]);
            }

            // Update or create TR translation (case-insensitive search)
            $trTranslation = $this->program->translations()
                ->whereRaw('LOWER(language) = ?', ['tr'])
                ->first();
            if ($trTranslation) {
                $trTranslation->update(['name' => $this->name_tr]);
            } else {
                $this->program->translations()->create([
                    'language' => 'tr',
                    'name' => $this->name_tr,
                ]);
            }

            // Update or create EN study language
            $enStudyLang = $this->program->studyLanguages()
                ->whereRaw('LOWER(language) = ?', ['en'])
                ->first();
            if ($enStudyLang) {
                $enStudyLang->update(['is_available' => $this->study_language_en]);
            } else {
                $this->program->studyLanguages()->create([
                    'language' => 'en',
                    'is_available' => $this->study_language_en,
                ]);
            }

            // Update or create TR study language
            $trStudyLang = $this->program->studyLanguages()
                ->whereRaw('LOWER(language) = ?', ['tr'])
                ->first();
            if ($trStudyLang) {
                $trStudyLang->update(['is_available' => $this->study_language_tr]);
            } else {
                $this->program->studyLanguages()->create([
                    'language' => 'tr',
                    'is_available' => $this->study_language_tr,
                ]);
            }
        });

        Log::info('Updating program', [
            'name_en' => $this->name_en,
            'name_tr' => $this->name_tr,
            'degree_id' => $this->degree_id,
            'faculty_id' => $this->faculty_id,
            'price_per_year' => $this->price_per_year,
            'study_language_en' => $this->study_language_en,
            'study_language_tr' => $this->study_language_tr,
        ]);

        // Reset form
        $this->reset([
            'name_en', 
            'name_tr', 
            'degree_id', 
            'faculty_id', 
            'price_per_year',
            'study_language_en',
            'study_language_tr',
        ]);
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('program-updated');
        $this->dispatch('close-edit-modal');
    }

    #[On('reset-edit-form')]
    public function resetForm()
    {
        if ($this->program) {
            $this->loadProgramData($this->program);
        }
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.programs.edit', [
            'degrees' => Degree::orderBy('name')->get(),
            'faculties' => Faculty::orderBy('name')->get(),
        ]);
    }
}
