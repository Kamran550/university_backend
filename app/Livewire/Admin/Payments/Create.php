<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\User;
use App\Models\Role;
use App\Enums\PaymentTypeEnum;
use App\Enums\PaymentStatusEnum;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.admin')]
class Create extends Component
{
    public ?int $user_id = null;
    public string $studentSearch = '';
    public bool $showStudentDropdown = false;
    public string $payment_type = '';
    public string $academic_year = '';
    public string $semester = 'Fall';
    public string $amount = '';
    public string $status = 'paid';

    public function updatedStudentSearch()
    {
        Log::info('updatedStudentSearch called', [
            'studentSearch' => $this->studentSearch,
            'length' => strlen($this->studentSearch)
        ]);
        $this->showStudentDropdown = !empty($this->studentSearch);
    }

    public function selectStudent($userId, $studentName)
    {
        $this->user_id = $userId;
        $this->studentSearch = $studentName;
        $this->showStudentDropdown = false;
    }

    public function clearStudent()
    {
        $this->user_id = null;
        $this->studentSearch = '';
        $this->showStudentDropdown = false;
    }

    protected function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'payment_type' => ['required', 'in:' . implode(',', PaymentTypeEnum::values())],
            'academic_year' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'in:Fall,Spring'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:' . implode(',', PaymentStatusEnum::values())],
        ];
    }

    protected function messages()
    {
        return [
            'user_id.required' => 'Student selection is required.',
            'user_id.exists' => 'Selected student does not exist.',
            'payment_type.required' => 'Payment type is required.',
            'payment_type.in' => 'Invalid payment type selected.',
            'academic_year.required' => 'Academic year is required.',
            'semester.required' => 'Semester is required.',
            'semester.in' => 'Semester must be either Fall or Spring.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be greater than or equal to 0.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status selected.',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            Payments::create([
                'user_id' => $this->user_id,
                'payment_type' => $this->payment_type,
                'academic_year' => $this->academic_year,
                'semester' => $this->semester,
                'amount' => $this->amount,
                'status' => $this->status,
            ]);

            Log::info('Payment created', [
                'user_id' => $this->user_id,
                'payment_type' => $this->payment_type,
                'academic_year' => $this->academic_year,
                'amount' => $this->amount,
            ]);

            session()->flash('success', 'Payment created successfully!');

            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            Log::error('Error creating payment', [
                'error' => $e->getMessage(),
                'data' => $this->toArray(),
            ]);

            session()->flash('error', 'An error occurred while creating the payment.');
        }
    }

    public function render()
    {
        $studentRole = Role::where('name', 'student')->first();
        Log::info('Student role', ['role' => $studentRole]);
        $students = collect();

        Log::info('Student render', [
            'studentSearch' => $this->studentSearch,
            'studentSearch_length' => strlen($this->studentSearch ?? ''),
            'showStudentDropdown' => $this->showStudentDropdown
        ]);
        if (!empty($this->studentSearch)) {
            $query = User::with('role')
                ->where('role_id', $studentRole?->id ?? 3);

            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->studentSearch . '%')
                    ->orWhere('surname', 'like', '%' . $this->studentSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->studentSearch . '%')
                    ->orWhere('username', 'like', '%' . $this->studentSearch . '%');
            });

            $students = $query->limit(10)->get();
            Log::info('Query executed', [
                'search_term' => $this->studentSearch,
                'found_count' => $students->count(),
                'students' => $students->pluck('name', 'surname')->toArray()
            ]);
        }

        return view('livewire.admin.payments.create', [
            'students' => $students,
            'paymentTypes' => PaymentTypeEnum::cases(),
            'statuses' => PaymentStatusEnum::cases(),
        ]);
    }
}
