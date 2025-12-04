<?php

namespace App\Livewire\Admin\Programs;

use App\Models\Program;
use App\Models\Degree;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public ?Program $program = null;
    public string $name = '';
    public ?int $degree_id = null;
    public ?int $faculty_id = null;
    public ?int $price_per_year = null;

    public function mount(?Program $program = null)
    {
        $this->program = $program;
        $this->name = $program->name ?? '';
        $this->degree_id = $program->degree_id ?? null;
        $this->faculty_id = $program->faculty_id ?? null;
        $this->price_per_year = $program->price_per_year ?? null;
    }

    #[On('edit-program')]
    public function loadProgram($programId)
    {
        $this->program = Program::findOrFail($programId);
        $this->name = $this->program->name;
        $this->degree_id = $this->program->degree_id;
        $this->faculty_id = $this->program->faculty_id;
        $this->price_per_year = $this->program->price_per_year;
        $this->resetValidation();
    }

    public function updatedDegreeId()
    {
        // Degree seçiləndə faculty_id-ni reset et
        $this->faculty_id = null;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'price_per_year' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Proqram adı mütləqdir.',
            'name.max' => 'Proqram adı maksimum 255 simvol ola bilər.',
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

        // Unique constraint yoxla (current program-ni istisna et)
        $exists = Program::where('degree_id', $this->degree_id)
            ->where('faculty_id', $this->faculty_id)
            ->where('name', $this->name)
            ->where('id', '!=', $this->program->id)
            ->exists();

        if ($exists) {
            $this->addError('name', 'Bu dərəcə və fakültə üçün bu proqram adı artıq mövcuddur.');
            return;
        }

        $this->program->update([
            'name' => $this->name,
            'degree_id' => $this->degree_id,
            'faculty_id' => $this->faculty_id,
            'price_per_year' => $this->price_per_year,
        ]);

        // Reset form
        $this->reset(['name', 'degree_id', 'faculty_id', 'price_per_year']);
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('program-updated');
        $this->dispatch('close-edit-modal');
    }

    #[On('reset-edit-form')]
    public function resetForm()
    {
        if ($this->program) {
            $this->name = $this->program->name;
            $this->degree_id = $this->program->degree_id;
            $this->faculty_id = $this->program->faculty_id;
            $this->price_per_year = $this->program->price_per_year;
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
