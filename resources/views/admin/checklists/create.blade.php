<!-- resources/views/admin/checklists/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Checklist') }}
            </h2>
            <a href="{{ route('checklists.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Checklists
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
                    <form action="{{ route('checklists.store') }}" method="POST" id="checklistForm" class="space-y-6">
                        @csrf

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Checklist Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Checklist Type</label>
                                    <input type="text" id="type" name="type" value="{{ old('type') }}" 
                                        placeholder="E.g., Inspection, Move-in, Maintenance"
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('type')
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
                                    <label for="template_id" class="block text-sm font-medium text-gray-700">Start from Template (Optional)</label>
                                    <select id="template_id" name="template_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="">None (Create from scratch)</option>
                                        @foreach($templates as $id => $name)
                                            <option value="{{ $id }}" {{ old('template_id') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('template_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center space-x-6 mt-6">
                                    <div>
                                        <label for="is_template" class="inline-flex items-center">
                                            <input type="checkbox" id="is_template" name="is_template" value="1" 
                                                {{ old('is_template') ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2">Save as Template</span>
                                        </label>
                                    </div>

                                    <div>
                                        <label for="active" class="inline-flex items-center">
                                            <input type="checkbox" id="active" name="active" value="1" 
                                                {{ old('active', '1') == '1' ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2">Active</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sections -->
                        <div class="border-b pb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Sections (Optional)</h3>
                                <button type="button" id="addSectionBtn" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-2 rounded">
                                    Add Section
                                </button>
                            </div>
                            
                            <div id="sectionsContainer" class="space-y-4">
                                <!-- Sections will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="border-b pb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Checklist Items</h3>
                                <button type="button" id="addItemBtn" 
                                    class="bg-green-500 hover:bg-green-700 text-white text-sm py-1 px-2 rounded">
                                    Add Item
                                </button>
                            </div>
                            
                            <div id="itemsContainer" class="space-y-6">
                                <!-- Items will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('checklists.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Checklist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Template (hidden) -->
    <template id="sectionTemplate">
        <div class="section-item bg-gray-50 p-4 rounded relative">
            <button type="button" class="remove-section absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section Title</label>
                    <input type="text" name="sections[{index}][title]" 
                        class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section ID</label>
                    <input type="text" name="sections[{index}][id]" 
                        class="mt-1 block w-full rounded-md border-gray-300" required>
                    <p class="mt-1 text-xs text-gray-500">Used to link items to this section. Use simple identifiers, e.g., "section1"</p>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <textarea name="sections[{index}][description]" rows="2" 
                        class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>
            </div>
        </div>
    </template>

    <!-- Item Template (hidden) -->
    <template id="itemTemplate">
        <div class="item-wrapper bg-gray-50 p-4 rounded relative">
            <button type="button" class="remove-item absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Question/Item</label>
                    <input type="text" name="items[{index}][question]" 
                        class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="items[{index}][type]" class="item-type mt-1 block w-full rounded-md border-gray-300" required>
                        <option value="text">Text</option>
                        <option value="textarea">Text Area</option>
                        <option value="number">Number</option>
                        <option value="boolean">Yes/No</option>
                        <option value="select">Single Select</option>
                        <option value="multiselect">Multi Select</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section (Optional)</label>
                    <select name="items[{index}][section]" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">No Section</option>
                        <!-- Section options will be populated dynamically -->
                    </select>
                </div>
                
                <div class="options-container hidden col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Options (one per line)</label>
                    <textarea name="items[{index}][options_text]" rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Order</label>
                    <input type="number" name="items[{index}][order]" min="0" value="0"
                        class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                
                <div class="flex items-center mt-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="items[{index}][required]" value="1" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="ml-2">Required</span>
                    </label>
                </div>
            </div>
        </div>
    </template>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let sectionCounter = 0;
            let itemCounter = 0;
            
            // Initialize containers
            const sectionsContainer = document.getElementById('sectionsContainer');
            const itemsContainer = document.getElementById('itemsContainer');
            
            // Section template
            const sectionTemplate = document.getElementById('sectionTemplate').innerHTML;
            
            // Item template
            const itemTemplate = document.getElementById('itemTemplate').innerHTML;
            
            // Add section button
            document.getElementById('addSectionBtn').addEventListener('click', function() {
                addSection();
            });
            
            // Add item button
            document.getElementById('addItemBtn').addEventListener('click', function() {
                addItem();
            });
            
            // Function to add a new section
            function addSection() {
                const sectionHtml = sectionTemplate.replace(/{index}/g, sectionCounter);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = sectionHtml;
                const sectionElement = tempDiv.firstElementChild;
                
                // Add remove event listener
                sectionElement.querySelector('.remove-section').addEventListener('click', function() {
                    sectionElement.remove();
                    updateSectionOptions();
                });
                
                sectionsContainer.appendChild(sectionElement);
                sectionCounter++;
                
                // Update section options in all items
                updateSectionOptions();
            }
            
            // Function to add a new item
            function addItem() {
                const itemHtml = itemTemplate.replace(/{index}/g, itemCounter);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = itemHtml;
                const itemElement = tempDiv.firstElementChild;
                
                // Add remove event listener
                itemElement.querySelector('.remove-item').addEventListener('click', function() {
                    itemElement.remove();
                });
                
                // Add change event for item type
                const typeSelect = itemElement.querySelector('.item-type');
                const optionsContainer = itemElement.querySelector('.options-container');
                
                typeSelect.addEventListener('change', function() {
                    if (this.value === 'select' || this.value === 'multiselect') {
                        optionsContainer.classList.remove('hidden');
                    } else {
                        optionsContainer.classList.add('hidden');
                    }
                });
                
                itemsContainer.appendChild(itemElement);
                
                // Update section options
                updateSectionOptions();
                
                itemCounter++;
            }
            
            // Function to update section options in all items
            function updateSectionOptions() {
                // Get all section IDs and titles
                const sections = [];
                document.querySelectorAll('#sectionsContainer .section-item').forEach(function(section) {
                    const idInput = section.querySelector('input[name^="sections"][name$="[id]"]');
                    const titleInput = section.querySelector('input[name^="sections"][name$="[title]"]');
                    
                    if (idInput && idInput.value && titleInput && titleInput.value) {
                        sections.push({
                            id: idInput.value,
                            title: titleInput.value
                        });
                    }
                });
                
                // Update all section dropdowns in items
                document.querySelectorAll('select[name^="items"][name$="[section]"]').forEach(function(select) {
                    const currentValue = select.value;
                    
                    // Clear all options except the first one
                    while (select.options.length > 1) {
                        select.remove(1);
                    }
                    
                    // Add section options
                    sections.forEach(function(section) {
                        const option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.title;
                        select.appendChild(option);
                    });
                    
                    // Restore selected value if it still exists
                    if (currentValue) {
                        for (let i = 0; i < select.options.length; i++) {
                            if (select.options[i].value === currentValue) {
                                select.selectedIndex = i;
                                break;
                            }
                        }
                    }
                });
            }
            
            // Event listeners for realtime section title updates
            sectionsContainer.addEventListener('input', function(e) {
                if (e.target.name && e.target.name.includes('[title]')) {
                    updateSectionOptions();
                }
            });
            
            // Process form submission
            document.getElementById('checklistForm').addEventListener('submit', function(e) {
                // Process options from textareas into JSON arrays
                document.querySelectorAll('textarea[name$="[options_text]"]').forEach(function(textarea) {
                    const index = textarea.name.match(/\[(\d+)\]/)[1];
                    const lines = textarea.value.split('\n').filter(line => line.trim() !== '');
                    
                    if (lines.length > 0) {
                        // Create a hidden input for the JSON options
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = `items[${index}][options]`;
                        hiddenInput.value = JSON.stringify(lines);
                        textarea.parentNode.appendChild(hiddenInput);
                    }
                });
                
                // Convert sections to JSON
                const sectionsData = [];
                document.querySelectorAll('#sectionsContainer .section-item').forEach(function(section) {
                    const idInput = section.querySelector('input[name^="sections"][name$="[id]"]');
                    const titleInput = section.querySelector('input[name^="sections"][name$="[title]"]');
                    const descInput = section.querySelector('textarea[name^="sections"][name$="[description]"]');
                    
                    if (idInput && idInput.value && titleInput && titleInput.value) {
                        sectionsData.push({
                            id: idInput.value,
                            title: titleInput.value,
                            description: descInput ? descInput.value : ''
                        });
                    }
                });
                
                if (sectionsData.length > 0) {
                    const sectionsInput = document.createElement('input');
                    sectionsInput.type = 'hidden';
                    sectionsInput.name = 'sections';
                    sectionsInput.value = JSON.stringify(sectionsData);
                    this.appendChild(sectionsInput);
                }
            });
            
            // Add at least one item by default
            addItem();
        });
    </script>
    @endpush
</x-app-layout>