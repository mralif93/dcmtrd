<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Edit Maintenance Record') }}
          </h2>
          <a href="{{ route('maintenance-records.show', $lease) }}" 
              class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
              Back to Maintenance Records
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
                  <form action="{{ route('maintenance-records.update', $maintenanceRecord) }}" method="POST" class="space-y-6">
                      @csrf
                      @method('PUT')

                      <!-- Basic Information -->
                      <div class="border-b pb-6">
                          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Maintenance Request Details</h3>
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                              <div>
                                  <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                  <select id="property_id" name="property_id" class="mt-1 block w-full rounded-md border-gray-300">
                                      @foreach($properties as $property)
                                          <option value="{{ $property->id }}" 
                                              {{ old('property_id', $maintenanceRecord->property_id) == $property->id ? 'selected' : '' }}>
                                              {{ $property->name }}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('property_id')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit (Optional)</label>
                                  <select id="unit_id" name="unit_id" class="mt-1 block w-full rounded-md border-gray-300">
                                      <option value="">Select Unit</option>
                                      @foreach($units as $unit)
                                          <option value="{{ $unit->id }}" 
                                              {{ old('unit_id', $maintenanceRecord->unit_id) == $unit->id ? 'selected' : '' }}>
                                              {{ $unit->property->name }} - Unit {{ $unit->unit_number }}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('unit_id')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="request_type" class="block text-sm font-medium text-gray-700">Request Type</label>
                                  <select id="request_type" name="request_type" class="mt-1 block w-full rounded-md border-gray-300">
                                      <option value="Repair" {{ old('request_type', $maintenanceRecord->request_type) == 'Repair' ? 'selected' : '' }}>Repair</option>
                                      <option value="Routine Maintenance" {{ old('request_type', $maintenanceRecord->request_type) == 'Routine Maintenance' ? 'selected' : '' }}>Routine Maintenance</option>
                                      <option value="Emergency" {{ old('request_type', $maintenanceRecord->request_type) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                      <option value="Inspection" {{ old('request_type', $maintenanceRecord->request_type) == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                                  </select>
                                  @error('request_type')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                                  <select id="priority" name="priority" class="mt-1 block w-full rounded-md border-gray-300">
                                      <option value="Low" {{ old('priority', $maintenanceRecord->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                                      <option value="Medium" {{ old('priority', $maintenanceRecord->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                      <option value="High" {{ old('priority', $maintenanceRecord->priority) == 'High' ? 'selected' : '' }}>High</option>
                                      <option value="Urgent" {{ old('priority', $maintenanceRecord->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                  </select>
                                  @error('priority')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div class="col-span-2">
                                  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                  <textarea id="description" name="description" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $maintenanceRecord->description) }}</textarea>
                                  @error('description')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                      <!-- Scheduling & Timing -->
                      <div class="border-b pb-6">
                          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Scheduling and Timing</h3>
                          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                              <div>
                                  <label for="request_date" class="block text-sm font-medium text-gray-700">Request Date</label>
                                  <input type="date" id="request_date" name="request_date" 
                                      value="{{ old('request_date', $maintenanceRecord->request_date->format('Y-m-d')) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('request_date')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="scheduled_date" class="block text-sm font-medium text-gray-700">Scheduled Date</label>
                                  <input type="date" id="scheduled_date" name="scheduled_date" 
                                      value="{{ old('scheduled_date', optional($maintenanceRecord->scheduled_date)->format('Y-m-d')) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('scheduled_date')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="completion_date" class="block text-sm font-medium text-gray-700">Completion Date</label>
                                  <input type="date" id="completion_date" name="completion_date" 
                                      value="{{ old('completion_date', optional($maintenanceRecord->completion_date)->format('Y-m-d')) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('completion_date')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="estimated_time" class="block text-sm font-medium text-gray-700">Estimated Time</label>
                                  <input type="time" id="estimated_time" name="estimated_time" 
                                      value="{{ old('estimated_time', $maintenanceRecord->estimated_time) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('estimated_time')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="actual_time" class="block text-sm font-medium text-gray-700">Actual Time</label>
                                  <input type="time" id="actual_time" name="actual_time" 
                                      value="{{ old('actual_time', optional($maintenanceRecord->actual_time)->format('H:i')) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('actual_time')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                      <!-- Financial & Contractor Details -->
                      <div class="border-b pb-6">
                          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Financial and Contractor Information</h3>
                          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                              <div>
                                  <label for="estimated_cost" class="block text-sm font-medium text-gray-700">Estimated Cost</label>
                                  <div class="mt-1 relative rounded-md shadow-sm">
                                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                          <span class="text-gray-500 sm:text-sm">$</span>
                                      </div>
                                      <input type="number" id="estimated_cost" name="estimated_cost" step="0.01" 
                                          value="{{ old('estimated_cost', $maintenanceRecord->estimated_cost) }}"
                                          class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                  </div>
                                  @error('estimated_cost')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="actual_cost" class="block text-sm font-medium text-gray-700">Actual Cost</label>
                                  <div class="mt-1 relative rounded-md shadow-sm">
                                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                          <span class="text-gray-500 sm:text-sm">$</span>
                                      </div>
                                      <input type="number" id="actual_cost" name="actual_cost" step="0.01" 
                                          value="{{ old('actual_cost', optional($maintenanceRecord->actual_cost)) }}"
                                          class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                  </div>
                                  @error('actual_cost')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="contractor_name" class="block text-sm font-medium text-gray-700">Contractor Name</label>
                                  <input type="text" id="contractor_name" name="contractor_name" 
                                      value="{{ old('contractor_name', $maintenanceRecord->contractor_name) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('contractor_name')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="contractor_contact" class="block text-sm font-medium text-gray-700">Contractor Contact</label>
                                  <input type="text" id="contractor_contact" name="contractor_contact" 
                                      value="{{ old('contractor_contact', $maintenanceRecord->contractor_contact) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('contractor_contact')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                  <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300">
                                      <option value="Plumbing" {{ old('category', $maintenanceRecord->category) == 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                                      <option value="Electrical" {{ old('category', $maintenanceRecord->category) == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                      <option value="HVAC" {{ old('category', $maintenanceRecord->category) == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                                      <option value="Structural" {{ old('category', $maintenanceRecord->category) == 'Structural' ? 'selected' : '' }}>Structural</option>
                                      <option value="Landscaping" {{ old('category', $maintenanceRecord->category) == 'Landscaping' ? 'selected' : '' }}>Landscaping</option>
                                      <option value="Other" {{ old('category', $maintenanceRecord->category) == 'Other' ? 'selected' : '' }}>Other</option>
                                  </select>
                                  @error('category')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="work_order_number" class="block text-sm font-medium text-gray-700">Work Order Number</label>
                                  <input type="text" id="work_order_number" name="work_order_number" 
                                      value="{{ old('work_order_number', $maintenanceRecord->work_order_number) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('work_order_number')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                      <!-- Additional Details -->
                      <div class="border-b pb-6">
                          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Additional Information</h3>
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                              <div>
                                  <label for="reported_by" class="block text-sm font-medium text-gray-700">Reported By</label>
                                  <input type="text" id="reported_by" name="reported_by" 
                                      value="{{ old('reported_by', $maintenanceRecord->reported_by) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('reported_by')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
                                  <input type="text" id="assigned_to" name="assigned_to" 
                                      value="{{ old('assigned_to', $maintenanceRecord->assigned_to) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('assigned_to')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                  <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                      <option value="Pending" {{ old('status', $maintenanceRecord->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                      <option value="In Progress" {{ old('status', $maintenanceRecord->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                      <option value="Completed" {{ old('status', $maintenanceRecord->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                      <option value="On Hold" {{ old('status', $maintenanceRecord->status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                      <option value="Cancelled" {{ old('status', $maintenanceRecord->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                  </select>
                                  @error('status')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="approval_status" class="block text-sm font-medium text-gray-700">Approval Status</label>
                                  <select id="approval_status" name="approval_status" class="mt-1 block w-full rounded-md border-gray-300">
                                      <option value="Pending" {{ old('approval_status', $maintenanceRecord->approval_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                      <option value="Approved" {{ old('approval_status', $maintenanceRecord->approval_status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                                      <option value="Rejected" {{ old('approval_status', $maintenanceRecord->approval_status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                  </select>
                                  @error('approval_status')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div class="col-span-2">
                                  <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                  <textarea id="notes" name="notes" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes', $maintenanceRecord->notes) }}</textarea>
                                  @error('notes')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="recurring" class="inline-flex items-center">
                                      <input type="checkbox" id="recurring" name="recurring" value="1" 
                                          {{ old('recurring', $maintenanceRecord->recurring) ? 'checked' : '' }}
                                          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                      <span class="ml-2 text-sm text-gray-700">Recurring Maintenance</span>
                                  </label>
                                  @error('recurring')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <div>
                                  <label for="recurrence_interval" class="block text-sm font-medium text-gray-700">Recurrence Interval (Months)</label>
                                  <input type="number" id="recurrence_interval" name="recurrence_interval" 
                                      value="{{ old('recurrence_interval', $maintenanceRecord->recurrence_interval) }}" 
                                      class="mt-1 block w-full rounded-md border-gray-300">
                                  @error('recurrence_interval')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                      <!-- Materials and Warranty -->
                      <div class="border-b pb-6">
                          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Materials and Warranty</h3>
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                              <div>
                                  <label for="materials_used" class="block text-sm font-medium text-gray-700">Materials Used</label>
                                  <textarea id="materials_used" name="materials_used" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300">{{ old('materials_used', json_encode($maintenanceRecord->materials_used)) }}</textarea>
                                  @error('materials_used')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                                  <p class="mt-1 text-xs text-gray-500">Enter materials as a JSON array, e.g. ["Paint", "Screws", "Drywall"]</p>
                              </div>

                              <div>
                                  <label for="warranty_info" class="block text-sm font-medium text-gray-700">Warranty Information</label>
                                  <textarea id="warranty_info" name="warranty_info" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300">{{ old('warranty_info', $maintenanceRecord->warranty_info) }}</textarea>
                                  @error('warranty_info')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                      <!-- Images Upload -->
                      <div>
                          <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Maintenance Images</h3>
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                              <div>
                                  <label for="images" class="block text-sm font-medium text-gray-700">Upload Images</label>
                                  <input type="file" id="images" name="images[]" multiple 
                                      class="mt-1 block w-full rounded-md border-gray-300 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:py-2 file:px-4">
                                  @error('images')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              @if($maintenanceRecord->images)
                                  <div>
                                      <label class="block text-sm font-medium text-gray-700">Current Images</label>
                                      <div class="mt-1 flex space-x-2">
                                          @foreach(json_decode($maintenanceRecord->images) as $image)
                                              <img src="{{ Storage::url($image) }}" alt="Maintenance Image" 
                                                  class="h-20 w-20 object-cover rounded-md">
                                          @endforeach
                                      </div>
                                  </div>
                              @endif
                          </div>
                      </div>

                      <!-- Form Actions -->
                      <div class="flex justify-end space-x-4 mt-6">
                          <a href="{{ route('maintenance-records.show', $maintenanceRecord) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                              Cancel
                          </a>
                          <button type="submit" 
                                  class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                              Update Maintenance Record
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>