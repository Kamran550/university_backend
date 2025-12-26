<div class="p-6 max-w-5xl mx-auto">

    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Payment Details</h1>
            <p class="mt-1 text-sm text-gray-600">View detailed information about the payment</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="downloadReceipt" wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove
                    wire:target="downloadReceipt">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <svg class="animate-spin w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" wire:loading wire:target="downloadReceipt">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span wire:loading.remove wire:target="downloadReceipt">Download Receipt</span>
                <span wire:loading wire:target="downloadReceipt">Generating...</span>
            </button>
            <a href="{{ route('admin.payments.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Payments
            </a>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-6">

            <!-- Student Information -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h2>
                <div class="flex items-center">
                    <div class="shrink-0 h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-semibold text-xl">
                            {{ strtoupper(substr($payment->user->name ?? '', 0, 1)) }}{{ strtoupper(substr($payment->user->surname ?? '', 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-4">
                        <div class="text-lg font-semibold text-gray-900">
                            {{ $payment->user->name ?? 'N/A' }} {{ $payment->user->surname ?? '' }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $payment->user->email ?? 'N/A' }}
                        </div>
                        @if ($payment->user->phone)
                            <div class="text-sm text-gray-500">
                                {{ $payment->user->phone }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Payment ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Payment ID</label>
                    <div class="text-lg font-semibold text-gray-900">#{{ $payment->id }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Invoiced Number</label>
                    <div class="text-lg font-semibold text-gray-900">{{ $payment->invoiced_number }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Payment Method</label>
                    <div class="text-lg font-semibold text-gray-900">
                        @if ($payment->payment_method->value === 'cash')
                            By Cash
                        @else
                            Online via Credit Card
                        @endif
                    </div>
                </div>


                <!-- Payment Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Payment Type</label>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $payment->payment_type->value }}
                    </span>
                </div>

                <!-- Academic Year -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Academic Year</label>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $payment->academic_year }}-{{ $payment->academic_year + 1 }}
                    </div>
                </div>

                <!-- Semester -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Semester</label>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        {{ $payment->semester }}
                    </span>
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Amount</label>
                    <div class="text-2xl font-bold text-gray-900">
                        € {{ number_format($payment->amount, 2) }}
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                    @if ($payment->status->value === 'paid')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Paid
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Cancelled
                        </span>
                    @endif
                </div>

                <!-- Created At -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $payment->created_at->format('d.m.Y') }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $payment->created_at->format('H:i:s') }}
                    </div>
                </div>

                <!-- Updated At -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                    <div class="text-lg font-semibold text-gray-900">
                        {{ $payment->updated_at->format('d.m.Y') }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $payment->updated_at->format('H:i:s') }}
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
