<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Enums\PaymentTypeEnum;
use App\Enums\PaymentStatusEnum;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'page')]
    public int $page = 1;

    #[Url(as: 'search')]
    public string $search = '';

    #[Url(as: 'payment_type')]
    public ?string $paymentType = null;

    #[Url(as: 'status')]
    public ?string $status = null;

    public $queryString = ['page', 'search', 'paymentType', 'status'];

    protected function getPageName()
    {
        return 'page';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaymentType()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->paymentType = null;
        $this->status = null;
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        $query = Payments::with('user');

        // Search filter
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('surname', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Payment type filter
        if ($this->paymentType) {
            $query->where('payment_type', $this->paymentType);
        }

        // Status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $payments = $query->orderBy('created_at', 'asc')->paginate(10);
        $payments->setPath(route('admin.payments.index'));

        return view('livewire.admin.payments.index', [
            'payments' => $payments,
            'paymentTypes' => PaymentTypeEnum::cases(),
            'statuses' => PaymentStatusEnum::cases(),
        ]);
    }
}
