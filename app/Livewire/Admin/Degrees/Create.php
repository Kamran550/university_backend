<?php

namespace App\Livewire\Admin\Degrees;

use App\Models\Degree;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{
    public string $name = '';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:degrees,name'],
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Dərəcə adı mütləqdir.',
            'name.unique' => 'Bu dərəcə adı artıq mövcuddur.',
            'name.max' => 'Dərəcə adı maksimum 255 simvol ola bilər.',
        ];
    }

    public function save()
    {
        $this->validate();

        Degree::create([
            'name' => $this->name,
        ]);

        // Reset form
        $this->reset('name');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('degree-created');
        $this->dispatch('close-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset('name');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.degrees.create');
    }
}
