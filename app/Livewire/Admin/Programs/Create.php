<?php

namespace App\Livewire\Admin\Programs;

use App\Models\Program;
use App\Models\Degree;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $name_en = '';
    public string $name_tr = '';
    public ?int $degree_id = null;
    public ?int $faculty_id = null;
    public ?int $price_per_year = null;
    public bool $study_language_en = true;
    public bool $study_language_tr = false;

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

    public function save()
    {
        $this->validate();

        // Unique constraint yoxla (name_en-ə görə)
        // $exists = Program::where('degree_id', $this->degree_id)
        //     ->where('faculty_id', $this->faculty_id)
        //     ->where('name', $this->name_en)
        //     ->exists();

        // if ($exists) {
        //     $this->addError('name_en', 'Bu dərəcə və fakültə üçün bu proqram adı (EN) artıq mövcuddur.');
        //     return;
        // }

        DB::transaction(function () {
            // Create program with EN name in programs table
            $program = Program::create([
                'name' => $this->name_en,
                'degree_id' => $this->degree_id,
                'faculty_id' => $this->faculty_id,
                'price_per_year' => $this->price_per_year,
            ]);

            // Create EN translation
            $program->translations()->create([
                'language' => 'en',
                'name' => $this->name_en,
            ]);

            // Create TR translation
            $program->translations()->create([
                'language' => 'tr',
                'name' => $this->name_tr,
            ]);

            // Create study language records
            $program->studyLanguages()->create([
                'language' => 'en',
                'is_available' => $this->study_language_en,
            ]);

            $program->studyLanguages()->create([
                'language' => 'tr',
                'is_available' => $this->study_language_tr,
            ]);
        });

        Log::info('Creating program', [
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
        $this->study_language_en = true; // Default value
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('program-created');
        $this->dispatch('close-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset([
            'name_en', 
            'name_tr', 
            'degree_id', 
            'faculty_id', 
            'price_per_year',
            'study_language_en',
            'study_language_tr',
        ]);
        $this->study_language_en = true; // Default value
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.programs.create', [
            'degrees' => Degree::orderBy('name')->get(),
            'faculties' => Faculty::orderBy('name')->get(),
        ]);
    }
}
