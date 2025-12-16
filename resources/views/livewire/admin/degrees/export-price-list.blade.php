<div>
    @if (session()->has('error'))
        <div class="mb-3 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex gap-2">
        <button wire:click="downloadPriceList('EN')" wire:loading.attr="disabled" wire:target="downloadPriceList"
            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg shadow-sm transition duration-150 ease-in-out">

            <!-- Loading Spinner -->
            <svg wire:loading wire:target="downloadPriceList" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>

            <!-- Download Icon -->
            <svg wire:loading.remove wire:target="downloadPriceList" class="w-5 h-5 mr-2" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>

            <span wire:loading.remove wire:target="downloadPriceList">Download Price List (EN)</span>
            <span wire:loading wire:target="downloadPriceList">Generating PDF...</span>
        </button>

        <button wire:click="downloadPriceList('TR')" wire:loading.attr="disabled" wire:target="downloadPriceList"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg shadow-sm transition duration-150 ease-in-out">

            <!-- Loading Spinner -->
            <svg wire:loading wire:target="downloadPriceList" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>

            <!-- Download Icon -->
            <svg wire:loading.remove wire:target="downloadPriceList" class="w-5 h-5 mr-2" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>

            <span wire:loading.remove wire:target="downloadPriceList">Fiyat Listesini İndir (TR)</span>
            <span wire:loading wire:target="downloadPriceList">PDF Hazırlanır...</span>
        </button>
    </div>
</div>
