<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Checklist Response') }}
            </h2>
            <a href="{{ route('checklist-responses.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Responses
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
                    <form action="{{ route('checklist-responses.store') }}" method="POST" enctype="multipart/form-data" id="checklistResponseForm" class="space-y-6">
                        @csrf

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="checklist_id" class="block text-sm font-medium text-gray-700">Checklist <span class="text-red-600">*</span></label>
                                    <select name="checklist_id" id="checklist_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                                        <option value="">Select Checklist</option>
                                        @foreach ($checklists as $checklist)
                                            <option value="{{ $checklist->id }}" {{ old('checklist_id') == $checklist->id ? 'selected' : '' }}>
                                                {{ $checklist->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('checklist_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit <span class="text-red-600">*</span></label>
                                    <select name="unit_id" id="unit_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                                        <option value="">Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tenant_id" class="block text-sm font-medium text-gray-700">Tenant</label>
                                    <select name="tenant_id" id="tenant_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="">Select Tenant (Optional)</option>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tenant_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Status Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-600">*</span></label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300" required>
                                        <option value="Draft" {{ old('status', 'Draft') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Reviewed" {{ old('status') == 'Reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Response Data -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Response Data <span class="text-red-600">*</span></h3>
                            <div id="responseDataContainer">
                                <div id="checklist-items" class="mb-3">
                                    <div class="p-4 bg-blue-50 rounded">
                                        Please select a checklist to load its items.
                                    </div>
                                </div>
                                <input type="hidden" name="response_data" id="response_data" value="{{ old('response_data', '{}') }}">
                                @error('response_data')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Files -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Files</h3>
                            
                            <div class="mb-4">
                                <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                                <input type="file" name="images[]" id="images" multiple accept="image/*" 
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">You can upload multiple images (max 2MB each)</p>
                                @error('images.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="attachments" class="block text-sm font-medium text-gray-700">Attachments</label>
                                <input type="file" name="attachments[]" id="attachments" multiple
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">You can upload multiple files (max 10MB each)</p>
                                @error('attachments.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('checklist-responses.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize response data
            let responseData = {};
            try {
                responseData = JSON.parse(document.getElementById('response_data').value);
            } catch (e) {
                responseData = {};
            }
            
            // Handle checklist selection
            const checklistSelect = document.getElementById('checklist_id');
            checklistSelect.addEventListener('change', function() {
                const checklistId = this.value;
                if (checklistId) {
                    fetchChecklistItems(checklistId);
                } else {
                    document.getElementById('checklist-items').innerHTML = '<div class="p-4 bg-blue-50 rounded">Please select a checklist to load its items.</div>';
                    responseData = {};
                    updateResponseDataField();
                }
            });
            
            // Fetch checklist items from API
            function fetchChecklistItems(checklistId) {
                fetch(`/api/checklists/${checklistId}`)
                    .then(response => response.json())
                    .then(data => {
                        renderChecklistItems(data);
                    })
                    .catch(error => {
                        console.error('Error fetching checklist:', error);
                        document.getElementById('checklist-items').innerHTML = '<div class="p-4 bg-red-50 rounded">Error loading checklist items. Please try again.</div>';
                    });
            }
            
            // Render checklist items
            function renderChecklistItems(checklist) {
                const container = document.getElementById('checklist-items');
                let html = '';
                
                if (checklist.items && checklist.items.length > 0) {
                    html = '<div class="space-y-4">';
                    html += `<h5 class="text-lg font-medium">${checklist.name}</h5>`;
                    
                    checklist.items.forEach((item, index) => {
                        const itemId = `item_${item.id || index}`;
                        html += `<div class="mb-3 p-4 border rounded">`;
                        html += `<h6 class="font-medium mb-2">${item.question}</h6>`;
                        
                        if (item.type === 'yes_no') {
                            html += `
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="${itemId}" value="yes" 
                                            ${responseData[itemId] === 'yes' ? 'checked' : ''}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            onchange="updateItemResponse('${itemId}', 'yes')">
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="${itemId}" value="no" 
                                            ${responseData[itemId] === 'no' ? 'checked' : ''}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            onchange="updateItemResponse('${itemId}', 'no')">
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            `;
                        } else if (item.type === 'text') {
                            html += `
                                <textarea class="mt-1 block w-full rounded-md border-gray-300" 
                                    id="${itemId}" rows="2" 
                                    onchange="updateItemResponse('${itemId}', this.value)">${responseData[itemId] || ''}</textarea>
                            `;
                        } else if (item.type === 'numeric') {
                            html += `
                                <input type="number" class="mt-1 block w-full rounded-md border-gray-300" 
                                    id="${itemId}" value="${responseData[itemId] || ''}" 
                                    onchange="updateItemResponse('${itemId}', this.value)">
                            `;
                        } else if (item.type === 'dropdown' && item.options) {
                            html += `<select class="mt-1 block w-full rounded-md border-gray-300" 
                                        id="${itemId}" onchange="updateItemResponse('${itemId}', this.value)">`;
                            html += `<option value="">Select an option</option>`;
                            item.options.forEach(option => {
                                html += `<option value="${option}" ${responseData[itemId] === option ? 'selected' : ''}>${option}</option>`;
                            });
                            html += `</select>`;
                        }
                        
                        html += `</div>`;
                    });
                    
                    html += '</div>';
                } else {
                    html = '<div class="p-4 bg-yellow-50 rounded">No items found in this checklist.</div>';
                }
                
                container.innerHTML = html;
                
                // Define the updateItemResponse function in global scope
                window.updateItemResponse = function(itemId, value) {
                    responseData[itemId] = value;
                    updateResponseDataField();
                };
            }
            
            // Update the hidden response_data field
            function updateResponseDataField() {
                document.getElementById('response_data').value = JSON.stringify(responseData);
            }
            
            // Trigger checklist load if a checklist is already selected
            if (checklistSelect.value) {
                fetchChecklistItems(checklistSelect.value);
            }
            
            // Form submission validation
            const form = document.getElementById('checklistResponseForm');
            form.addEventListener('submit', function(event) {
                const responseDataField = document.getElementById('response_data');
                
                // Check if response data is empty
                if (responseDataField.value === '{}') {
                    event.preventDefault();
                    alert('Please fill out at least one response item before submitting.');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>