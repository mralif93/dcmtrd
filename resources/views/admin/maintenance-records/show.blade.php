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
        
          @if(session('success'))
              <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                  <div class="flex items-center">
                      <div class="flex-shrink-0">
                          <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                          </svg>
                      </div>
                      <div class="ml-3">
                          <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                      </div>
                  </div>
              </div>
          @endif

          <!-- Maintenance Record Overview -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6">
                  <div class="flex justify-between items-center mb-4">
                      <h3 class="text-lg font-semibold text-gray-900">Record Overview</h3>
                      <span class="px-2 py-1 text-xs rounded-full 
                          @if($maintenanceRecord->status === 'Completed') bg-green-100 text-green-800
                          @elseif($maintenanceRecord->status === 'In Progress') bg-yellow-100 text-yellow-800
                          @elseif($maintenanceRecord->status === 'Pending') bg-blue-100 text-blue-800
                          @elseif($maintenanceRecord->status === 'On Hold') bg-gray-100 text-gray-800
                          @else bg-red-100 text-red-800 @endif">
                          {{ $maintenanceRecord->status }}
                      </span>
                  </div>
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                          <div class="grid grid-cols-2 gap-4">
                              <div class="text-sm text-gray-500">Property</div>
                              <div>
                                  <a href="{{ route('properties.show', $maintenanceRecord->property) }}" 
                                    class="text-blue-600 hover:text-blue-900">
                                      {{ $maintenanceRecord->property->name }}
                                  </a>
                              </div>
                              
                              @if($maintenanceRecord->unit)
                                  <div class="text-sm text-gray-500">Unit</div>
                                  <div>
                                      <a href="{{ route('units.show', $maintenanceRecord->unit) }}" 
                                        class="text-blue-600 hover:text-blue-900">
                                          {{ $maintenanceRecord->unit->unit_number }}
                                      </a>
                                  </div>
                              @endif
                              
                              <div class="text-sm text-gray-500">Request Type</div>
                              <div>{{ $maintenanceRecord->request_type }}</div>
                              
                              <div class="text-sm text-gray-500">Priority</div>
                              <div>
                                  <span class="px-2 py-1 text-xs rounded-full 
                                      @if($maintenanceRecord->priority === 'Low') bg-green-100 text-green-800
                                      @elseif($maintenanceRecord->priority === 'Medium') bg-yellow-100 text-yellow-800
                                      @elseif($maintenanceRecord->priority === 'High') bg-orange-100 text-orange-800
                                      @else bg-red-100 text-red-800 @endif">
                                      {{ $maintenanceRecord->priority }}
                                  </span>
                              </div>
                              
                              <div class="text-sm text-gray-500">Reported By</div>
                              <div>{{ $maintenanceRecord->reported_by }}</div>
                              
                              <div class="text-sm text-gray-500">Category</div>
                              <div>{{ $maintenanceRecord->category }}</div>
                          </div>
                      </div>
                      
                      <div>
                          <div class="grid grid-cols-2 gap-4">
                              <div class="text-sm text-gray-500">Work Order Number</div>
                              <div>{{ $maintenanceRecord->work_order_number }}</div>
                              
                              <div class="text-sm text-gray-500">Request Date</div>
                              <div>{{ $maintenanceRecord->request_date->format('M d, Y') }}</div>
                              
                              <div class="text-sm text-gray-500">Scheduled Date</div>
                              <div>
                                  {{ $maintenanceRecord->scheduled_date 
                                      ? $maintenanceRecord->scheduled_date->format('M d, Y') 
                                      : 'Not Scheduled' }}
                              </div>
                              
                              <div class="text-sm text-gray-500">Completion Date</div>
                              <div>
                                  {{ $maintenanceRecord->completion_date 
                                      ? $maintenanceRecord->completion_date->format('M d, Y') 
                                      : 'Not Completed' }}
                              </div>
                              
                              <div class="text-sm text-gray-500">Estimated Time</div>
                              <div>{{ $maintenanceRecord->estimated_time ?? 'Not Specified' }}</div>
                              
                              <div class="text-sm text-gray-500">Actual Time</div>
                              <div>{{ $maintenanceRecord->actual_time ?? 'Not Recorded' }}</div>
                              
                              <div class="text-sm text-gray-500">Assigned To</div>
                              <div>{{ $maintenanceRecord->assigned_to }}</div>
                          </div>
                      </div>
                  </div>
                  
                  <div class="mt-6">
                      <div class="text-sm text-gray-500 mb-2">Description</div>
                      <div class="bg-gray-50 p-4 rounded-md">
                          {{ $maintenanceRecord->description ?? 'No description provided' }}
                      </div>
                  </div>
              </div>
          </div>

          <!-- Financial Details -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4">Financial Information</h3>
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                          <div class="grid grid-cols-2 gap-4">
                              <div class="text-sm text-gray-500">Estimated Cost</div>
                              <div>${{ number_format($maintenanceRecord->estimated_cost, 2) }}</div>
                              
                              <div class="text-sm text-gray-500">Actual Cost</div>
                              <div>
                                  {{ $maintenanceRecord->actual_cost 
                                      ? '$' . number_format($maintenanceRecord->actual_cost, 2) 
                                      : 'Not Finalized' }}
                              </div>
                          </div>
                      </div>
                      
                      <div>
                          <div class="grid grid-cols-2 gap-4">
                              <div class="text-sm text-gray-500">Contractor</div>
                              <div>{{ $maintenanceRecord->contractor_name ?? 'Not Assigned' }}</div>
                              
                              <div class="text-sm text-gray-500">Contractor Contact</div>
                              <div>{{ $maintenanceRecord->contractor_contact ?? 'No Contact' }}</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Additional Details -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                          <div class="text-sm text-gray-500 mb-2">Materials Used</div>
                          <div class="bg-gray-50 p-4 rounded-md">
                              @if($maintenanceRecord->materials_used)
                                  <ul class="list-disc list-inside">
                                      @foreach(json_decode($maintenanceRecord->materials_used) as $material)
                                          <li>{{ $material }}</li>
                                      @endforeach
                                  </ul>
                              @else
                                  <p>No materials recorded</p>
                              @endif
                          </div>
                      </div>
                      
                      <div>
                          <div class="text-sm text-gray-500 mb-2">Warranty Information</div>
                          <div class="bg-gray-50 p-4 rounded-md">
                              {{ $maintenanceRecord->warranty_info ?? 'No warranty information provided' }}
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Images -->
          @if($maintenanceRecord->images)
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6">
                      <h3 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Images</h3>
                      
                      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                          @foreach(json_decode($maintenanceRecord->images) as $image)
                              <div class="relative group">
                                  <img src="{{ Storage::url($image) }}" alt="Maintenance Image" 
                                      class="w-full h-48 object-cover rounded-md">
                                  <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                      <a href="{{ Storage::url($image) }}" target="_blank" 
                                        class="text-white opacity-0 group-hover:opacity-100 bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded-md">
                                          View Full Size
                                      </a>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
          @endif
      </div>
  </div>

</x-app-layout>