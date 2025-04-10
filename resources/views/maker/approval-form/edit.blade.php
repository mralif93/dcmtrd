<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Approval Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('approval-form-m.update', $approvalForm) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6 pb-6">
                        <!-- Portfolio and Property Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Related Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Portfolio Dropdown -->
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                    <select name="portfolio_id" id="portfolio_id"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Portfolio --</option>
                                        @foreach($portfolios as $portfolio)
                                            <option value="{{ $portfolio->id }}" @selected(old('portfolio_id', $approvalForm->portfolio_id ?? null) == $portfolio->id)>
                                                {{ $portfolio->portfolio_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Property Dropdown -->
                                <div>
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                    <select name="property_id" id="property_id"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Property --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Details Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Form Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="form_number" class="block text-sm font-medium text-gray-700">Form Number</label>
                                    <input type="text" name="form_number" id="form_number" 
                                        value="{{ old('form_number', $approvalForm->form_number) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="form_title" class="block text-sm font-medium text-gray-700">Form Title *</label>
                                    <input type="text" name="form_title" id="form_title" required
                                        value="{{ old('form_title', $approvalForm->form_title) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="form_category" class="block text-sm font-medium text-gray-700">Form Category</label>
                                    <select name="form_category" id="form_category"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Category --</option>
                                        @foreach(['Legal', 'Financial', 'Operational', 'Administrative', 'Technical'] as $category)
                                            <option value="{{ $category }}" @selected(old('form_category', $approvalForm->form_category) == $category)>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="reference_code" class="block text-sm font-medium text-gray-700">Reference Code</label>
                                    <input type="text" name="reference_code" id="reference_code" 
                                        value="{{ old('reference_code', $approvalForm->reference_code) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dates and Status Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dates and Status</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="received_date" class="block text-sm font-medium text-gray-700">Received Date *</label>
                                    <input type="date" name="received_date" id="received_date" required
                                        value="{{ old('received_date', $approvalForm->received_date ? $approvalForm->received_date->format('Y-m-d') : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="send_date" class="block text-sm font-medium text-gray-700">Send Date</label>
                                    <input type="date" name="send_date" id="send_date" 
                                        value="{{ old('send_date', $approvalForm->send_date ? $approvalForm->send_date->format('Y-m-d') : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending" @selected(old('status', $approvalForm->status) == 'pending')>Pending</option>
                                        <option value="in_progress" @selected(old('status', $approvalForm->status) == 'in_progress')>In Progress</option>
                                        <option value="approved" @selected(old('status', $approvalForm->status) == 'approved')>Approved</option>
                                        <option value="rejected" @selected(old('status', $approvalForm->status) == 'rejected')>Rejected</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" name="location" id="location" 
                                        value="{{ old('location', $approvalForm->location) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Details Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Details</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $approvalForm->description) }}</textarea>
                                </div>
                                <div>
                                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea name="remarks" id="remarks" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks', $approvalForm->remarks) }}</textarea>
                                </div>
                                <div>
                                    <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment</label>
                                    @if($approvalForm->attachment)
                                        <div class="my-2">
                                            <span class="text-sm text-gray-500">Current file: </span>
                                            <a href="{{ asset('storage/' . $approvalForm->attachment) }}" class="text-sm text-indigo-600 hover:text-indigo-900" target="_blank">
                                                {{ basename($approvalForm->attachment) }}
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="attachment" id="attachment"
                                        class="mt-1 block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100">
                                    <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current file.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Approval Information Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Approval Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="prepared_by" class="block text-sm font-medium text-gray-700">Prepared By</label>
                                    <select name="prepared_by" id="prepared_by"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('prepared_by', $approvalForm->prepared_by) == $user->id)>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="verified_by" class="block text-sm font-medium text-gray-700">Verified By</label>
                                    <select name="verified_by" id="verified_by"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('verified_by', $approvalForm->verified_by) == $user->id)>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="approval_datetime" class="block text-sm font-medium text-gray-700">Approval Date/Time</label>
                                    <input type="datetime-local" name="approval_datetime" id="approval_datetime" 
                                        value="{{ old('approval_datetime', $approvalForm->approval_datetime ? $approvalForm->approval_datetime->format('Y-m-d\TH:i') : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('approval-form-m.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Approval Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Property Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to selects
            const portfolioSelect = document.getElementById('portfolio_id');
            const propertySelect = document.getElementById('property_id');
            
            // Define properties with their portfolio associations
            // This will be populated from PHP
            const properties = [
                @foreach($properties as $property)
                    {
                        id: {{ $property->id }},
                        name: "{{ $property->property_name }}",
                        portfolioId: {{ $property->portfolio_id ?? 'null' }}
                    },
                @endforeach
            ];
            
            // Current selected property (for edit form)
            const currentPropertyId = "{{ old('property_id', $approvalForm->property_id ?? '') }}";
            
            // Function to update properties dropdown
            function updateProperties() {
                // Get selected portfolio
                const selectedPortfolioId = portfolioSelect.value;
                
                // Clear current options
                propertySelect.innerHTML = '<option value="">-- Select Property --</option>';
                
                // Filter properties for selected portfolio
                const filteredProperties = selectedPortfolioId 
                    ? properties.filter(p => p.portfolioId == selectedPortfolioId)
                    : properties;
                    
                // Add filtered options
                filteredProperties.forEach(property => {
                    const option = document.createElement('option');
                    option.value = property.id;
                    option.textContent = property.name;
                    option.selected = (property.id == currentPropertyId);
                    propertySelect.appendChild(option);
                });
            }
            
            // Update properties when portfolio changes
            portfolioSelect.addEventListener('change', updateProperties);
            
            // Initial load
            updateProperties();
        });
    </script>
</x-app-layout>