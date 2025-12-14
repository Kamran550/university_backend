<?php

namespace App\Livewire\Admin\Degrees;

use App\Models\Degree;
use App\Models\DegreeTranslation;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public ?Degree $degree = null;
    public string $name_en = '';
    public string $name_tr = '';
    public string $description = '';
    public int $duration = 0;

    public function mount(?Degree $degree = null)
    {
        $this->degree = $degree;
        if ($degree) {
            $this->degree->load('translations');
            $this->loadDegreeData($this->degree);
        }
    }

    #[On('edit-degree')]
    public function loadDegree($degreeId)
    {
        $this->degree = Degree::with('translations')->findOrFail($degreeId);
        $this->loadDegreeData($this->degree);
        $this->resetValidation();
    }

    protected function loadDegreeData(Degree $degree)
    {
        $this->description = $degree->description ?? '';
        $this->duration = $degree->duration ?? 0;

        // Load translations (case-insensitive)
        $enTranslation = $degree->translations->filter(function ($translation) {
            return strtolower($translation->language) === 'en';
        })->first();
        $trTranslation = $degree->translations->filter(function ($translation) {
            return strtolower($translation->language) === 'tr';
        })->first();

        $this->name_en = $enTranslation?->name ?? $degree->name ?? '';
        $this->name_tr = $trTranslation?->name ?? '';
    }

    protected function rules()
    {
        return [
            'name_en' => ['required', 'string', 'max:255', 'unique:degrees,name,' . ($this->degree?->id ?? 0)],
            'name_tr' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
        ];
    }

    protected function messages()
    {
        return [
            'name_en.required' => 'Dərəcə adı (EN) mütləqdir.',
            'name_en.unique' => 'Bu dərəcə adı (EN) artıq mövcuddur.',
            'name_en.max' => 'Dərəcə adı (EN) maksimum 255 simvol ola bilər.',
            'name_tr.required' => 'Dərəcə adı (TR) mütləqdir.',
            'name_tr.max' => 'Dərəcə adı (TR) maksimum 255 simvol ola bilər.',
            'description.required' => 'Dərəcə təsviri mütləqdir.',
            'description.max' => 'Dərəcə təsviri maksimum 255 simvol ola bilər.',
            'duration.required' => 'Dərəcə müddəti mütləqdir.',
            'duration.integer' => 'Dərəcə müddəti integer olmalıdır.',
            'duration.min' => 'Dərəcə müddəti 1 ilə başlaymalıdır.',
        ];
    }

    public function update()
    {
        if (!$this->degree) {
            return;
        }

        $this->validate();

        DB::transaction(function () {
            // Update degrees table with EN name
            $this->degree->update([
                'name' => $this->name_en,
                'description' => $this->description,
                'duration' => $this->duration,
            ]);

            // Update or create EN translation (case-insensitive search)
            $enTranslation = $this->degree->translations()
                ->whereRaw('LOWER(language) = ?', ['en'])
                ->first();
            if ($enTranslation) {
                $enTranslation->update(['name' => $this->name_en]);
            } else {
                $this->degree->translations()->create([
                    'language' => 'en',
                    'name' => $this->name_en,
                ]);
            }

            // Update or create TR translation (case-insensitive search)
            $trTranslation = $this->degree->translations()
                ->whereRaw('LOWER(language) = ?', ['tr'])
                ->first();
            if ($trTranslation) {
                $trTranslation->update(['name' => $this->name_tr]);
            } else {
                $this->degree->translations()->create([
                    'language' => 'tr',
                    'name' => $this->name_tr,
                ]);
            }
        });

        Log::info('Updating degree', [
            'name_en' => $this->name_en,
            'name_tr' => $this->name_tr,
            'description' => $this->description
        ]);

        // Reset form
        $this->reset('name_en', 'name_tr', 'description', 'duration');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('degree-updated');
        $this->dispatch('close-edit-modal');
    }

    #[On('reset-edit-form')]
    public function resetForm()
    {
        if ($this->degree) {
            $this->loadDegreeData($this->degree);
        }
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.degrees.edit');
    }
}
