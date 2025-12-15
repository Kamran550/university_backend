<div>
    <!-- Form -->
    <form wire:submit="save">
        
        <!-- Program Name Fields (EN and TR) -->
        <div class="mb-6">
            <!-- English Name Field -->
            <div class="mb-4">
                <label for="modal-name-en" class="block text-sm font-medium text-gray-700 mb-2">
                    Program Name (English) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="modal-name-en"
                    wire:model="name_en"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('name_en') border-red-500 @else border-gray-300 @enderror"
                    placeholder="For example: Computer Science, Economics, Law"
                    autofocus
                >
                @error('name_en')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Turkish Name Field -->
            <div class="mb-4">
                <label for="modal-name-tr" class="block text-sm font-medium text-gray-700 mb-2">
                    Program Name (Turkish) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="modal-name-tr"
                    wire:model="name_tr"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('name_tr') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Məsələn: Kompüter Elmləri, İqtisadiyyat, Hüquq"
                >
                @error('name_tr')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Degree Field -->
        <div class="mb-6">
            <label for="modal-degree" class="block text-sm font-medium text-gray-700 mb-2">
                Degree <span class="text-red-500">*</span>
            </label>
            <select 
                id="modal-degree"
                wire:model.live="degree_id"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('degree_id') border-red-500 @else border-gray-300 @enderror"
            >
                <option value="">Select Degree</option>
                @foreach($degrees as $degree)
                    <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                @endforeach
            </select>
            @error('degree_id')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Faculty Field -->
        <div class="mb-6">
            <label for="modal-faculty" class="block text-sm font-medium text-gray-700 mb-2">
                Faculty <span class="text-red-500">*</span>
            </label>
            <select 
                id="modal-faculty"
                wire:model="faculty_id"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('faculty_id') border-red-500 @else border-gray-300 @enderror"
                @if(!$degree_id) disabled @endif
            >
                <option value="">@if($degree_id) Select Faculty @else Select Degree First @endif</option>
                @if($degree_id)
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('faculty_id')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Price per Year Field -->
        <div class="mb-6">
            <label for="modal-price" class="block text-sm font-medium text-gray-700 mb-2">
                Yearly Price (EUR) <span class="text-red-500">*</span>
            </label>
            <input 
                type="number" 
                id="modal-price"
                wire:model="price_per_year"
                min="0"
                step="1"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('price_per_year') border-red-500 @else border-gray-300 @enderror"
                placeholder="0"
            >
            @error('price_per_year')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Study Languages -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Study Languages <span class="text-red-500">*</span>
            </label>
            <div class="space-y-3">
                <!-- English Language -->
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        wire:model="study_language_en"
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    >
                    <span class="ml-2 text-sm text-gray-700">English (EN)</span>
                </label>
                
                <!-- Turkish Language -->
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        wire:model="study_language_tr"
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    >
                    <span class="ml-2 text-sm text-gray-700">Turkish (TR)</span>
                </label>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                Select the languages in which this program will be taught.
            </p>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <button 
                type="button"
                @click="$dispatch('close-modal')"
                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition duration-150 ease-in-out">
                Cancel
            </button>
            <button 
                type="submit"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="save">
                    Save
                </span>
                <span wire:loading wire:target="save" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>

    </form>
</div>
