<?php

namespace App\Livewire\Admin\Degrees;

use App\Models\Degree;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $name_en = '';
    public string $name_tr = '';
    public string $description = '';
    public int $duration = 0;

    protected function rules()
    {
        return [
            'name_en' => ['required', 'string', 'max:255', 'unique:degrees,name'],
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

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // Create degree with EN name in degrees table
            $degree = Degree::create([
                'name' => $this->name_en,
                'description' => $this->description,
                'duration' => $this->duration,
            ]);

            // Create EN translation
            $degree->translations()->create([
                'language' => 'en',
                'name' => $this->name_en,
            ]);

            // Create TR translation
            $degree->translations()->create([
                'language' => 'tr',
                'name' => $this->name_tr,
            ]);
        });

        Log::info('Creating degree', [
            'name_en' => $this->name_en,
            'name_tr' => $this->name_tr,
            'description' => $this->description,
            'duration' => $this->duration
        ]);

        // Reset form
        $this->reset('name_en', 'name_tr', 'description', 'duration');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('degree-created');
        $this->dispatch('close-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset('name_en', 'name_tr', 'description', 'duration');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.degrees.create');
    }
}
