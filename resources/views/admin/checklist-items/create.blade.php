<!-- resources/views/admin/checklist-items/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Checklist Item to') }}: {{ $checklist->name }}
            </h2>
            <a href="{{ route('checklists.edit', $checklist->id) }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Checklist
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('checklist-items.store') }}" method="POST" class="space-y-6" id="itemForm">
                        @csrf
                        <input type="hidden" name="checklist_id" value="{{ $checklist->id }}">

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                                <input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                                @error('item_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                                <select id="section" name="section" class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Section</option>
                                    @foreach($checklist->sections as $section)
                                        <option value="{{ $section }}" {{ old('section') == $section ? 'selected' : '' }}>
                                            {{ $section }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Item Type</label>
                                <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Type</option>
                                    <option value="Boolean" {{ old('type') == 'Boolean' ? 'selected' : '' }}>Yes/No</option>
                                    <option value="Text" {{ old('type') == 'Text' ? 'selected' : '' }}>Text</option>
                                    <option value="Number" {{ old('type') == 'Number' ? 'selected' : '' }}>Number</option>
                                    <option value="Rating" {{ old('type') == 'Rating' ? 'selected' : '' }}>Rating</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Display Order</label>
                                <input type="number" id="order" name="order" value="{{ old('order', 0) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300" min="0">
                                @error('order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="required" class="inline-flex items-center">
                                    <input type="checkbox" id="required" name="required" value="1" 
                                        {{ old('required') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2">Required</span>
                                </label>
                                @error('required')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Rating Options (Conditional) -->
                        <div id="ratingOptionsSection" class="mt-6 {{ old('type') === 'Rating' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating Options</label>
                            
                            <div id="ratingOptions" class="space-y-2">
                                @if(old('options'))
                                    @foreach(old('options') as $index => $option)
                                        <div class="flex items-center">
                                            <input type="text" name="options[]" value="{{ $option }}" 
                                                class="mt-1 mr-2 block w-full rounded-md border-gray-300" 
                                                placeholder="Option {{ $index + 1 }}">
                                            <button type="button" class="remove-option text-red-600 hover:text-red-900">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center">
                                        <input type="text" name="options[]" 
                                            class="mt-1 mr-2 block w-full rounded-md border-gray-300" 
                                            placeholder="Option 1">
                                        <button type="button" class="remove-option text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            
                            <button type="button" id="addOption" class="mt-2 text-sm text-indigo-600 hover:text-indigo-900">
                                + Add Option
                            </button>
                            
                            @error('options')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('checklists.edit', $checklist->id) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const ratingOptionsSection = document.getElementById('ratingOptionsSection');
            const ratingOptions = document.getElementById('ratingOptions');
            const addOptionButton = document.getElementById('addOption');
            
            // Show/hide rating options based on type selection
            typeSelect.addEventListener('change', function() {
                if (this.value === 'Rating') {
                    ratingOptionsSection.classList.remove('hidden');
                } else {
                    ratingOptionsSection.classList.add('hidden');
                }
            });
            
            // Add option
            addOptionButton.addEventListener('click', function() {
                const optionCount = ratingOptions.children.length + 1;
                const newOption = document.createElement('div');
                newOption.className = 'flex items-center';
                newOption.innerHTML = `
                    <input type="text" name="options[]" 
                        class="mt-1 mr-2 block w-full rounded-md border-gray-300" 
                        placeholder="Option ${optionCount}">
                    <button type="button" class="remove-option text-red-600 hover:text-red-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                `;
                ratingOptions.appendChild(newOption);
            });
            
            // Remove option
            ratingOptions.addEventListener('click', function(e) {
                if (e.target.closest('.remove-option')) {
                    const option = e.target.closest('.flex');
                    // Don't remove if it's the last option
                    if (ratingOptions.children.length > 1) {
                        option.remove();
                    }
                }
            });
            
            // Form validation
            document.getElementById('itemForm').addEventListener('submit', function(e) {
                if (typeSelect.value === 'Rating') {
                    const options = document.querySelectorAll('input[name="options[]"]');
                    let hasValue = false;
                    
                    options.forEach(option => {
                        if (option.value.trim() !== '') {
                            hasValue = true;
                        }
                    });
                    
                    if (!hasValue) {
                        e.preventDefault();
                        alert('Please add at least one rating option');
                    }
                }
            });
        });
    </script>
</x-app-layout>