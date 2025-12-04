<?php

namespace App\Livewire\Admin\Degrees;

use App\Models\Degree;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public ?Degree $degree = null;
    public string $name = '';

    public function mount(?Degree $degree = null)
    {
        $this->degree = $degree;
        $this->name = $degree->name ?? '';
        // if ($degree) {
        //     $this->degree = $degree;
        //     $this->name = $degree->name ?? '';
        // } else {
        //     $this->name = '';
        // }
    }

    #[On('edit-degree')]
    public function loadDegree($degreeId)
    {
        $this->degree = Degree::findOrFail($degreeId);
        $this->name = $this->degree->name;
        $this->resetValidation();
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:degrees,name,' . ($this->degree?->id ?? 0)],
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

    public function update()
    {
        if (!$this->degree) {
            return;
        }

        $this->validate();

        $this->degree->update([
            'name' => $this->name,
        ]);

        // Reset form
        $this->reset('name');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('degree-updated');
        $this->dispatch('close-edit-modal');
    }

    #[On('reset-edit-form')]
    public function resetForm()
    {
        if ($this->degree) {
            $this->name = $this->degree->name;
        }
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.degrees.edit');
    }
}
