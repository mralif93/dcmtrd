<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('External Area Condition Details') }}
            </h2>
            <a href="{{ route('checklist-external-area.index', $externalAreaCondition->checklist->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Header Section -->
                <div class="px-4 py-5 sm:px-6 flex justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            External Area Condition for: {{ $externalAreaCondition->checklist->siteVisit->property->name ?? 'N/A' }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            {{ $externalAreaCondition->checklist->siteVisit->property->city ?? 'N/A' }}, {{ $externalAreaCondition->checklist->siteVisit->property->state ?? 'N/A' }}
                        </p>
                    </div>
                    <span class="px-2 py-1 h-6 text-xs font-semibold rounded-full
                        {{ match(strtolower($externalAreaCondition->status)) {
                            'completed' => 'bg-green-100 text-green-800',
                            'scheduled' => 'bg-blue-100 text-blue-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'draft' => 'bg-blue-100 text-blue-800',
                            'verified' => 'bg-purple-100 text-purple-800',
                            'in progress' => 'bg-indigo-100 text-indigo-800',
                            'on hold' => 'bg-orange-100 text-orange-800',
                            'reviewing' => 'bg-teal-100 text-teal-800',
                            'approved' => 'bg-emerald-100 text-emerald-800',
                            'expired' => 'bg-rose-100 text-rose-800',
                            default => 'bg-gray-100 text-gray-800'
                        } }}">
                        {{ ucfirst($externalAreaCondition->status) }}
                    </span>
                </div>

                <!-- External Area Conditions Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">External Area Conditions</h3>
                    </div>
                    <dl>
                        <!-- General Cleanliness -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">General Cleanliness</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_general_cleanliness_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_general_cleanliness_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->general_cleanliness_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->general_cleanliness_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- Fencing and Gate -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fencing & Main Gate</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_fencing_gate_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_fencing_gate_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->fencing_gate_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->fencing_gate_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- External Facade -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">External Facade</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_external_facade_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_external_facade_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->external_facade_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->external_facade_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- Car Park -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Car Park</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->car_park_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->car_park_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- Land Settlement -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Land Settlement</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_land_settlement_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_land_settlement_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->land_settlement_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->land_settlement_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- Rooftop -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Rooftop</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_rooftop_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_rooftop_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->rooftop_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->rooftop_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- Drainage -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Drainage</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $externalAreaCondition->is_drainage_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $externalAreaCondition->is_drainage_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($externalAreaCondition->drainage_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $externalAreaCondition->drainage_remarks }}</p>
                                @endif
                            </dd>
                        </div>

                        <!-- Additional External Remarks -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Additional External Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $externalAreaCondition->external_remarks ?? 'No additional remarks' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">System Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $externalAreaCondition->prepared_by ?? 'Not specified' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $externalAreaCondition->verified_by ?? 'Not verified yet' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($externalAreaCondition->status ?? 'draft')) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'draft' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($externalAreaCondition->status) }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">General Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $externalAreaCondition->remarks ?? 'No remarks available' }}</dd>
                        </div>
                        @if($externalAreaCondition->approval_datetime)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($externalAreaCondition->approval_datetime)->format('d/m/Y h:i A') }}</dd>
                        </div>
                        @endif
                        <div class="{{ $externalAreaCondition->approval_datetime ? 'bg-white' : 'bg-gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $externalAreaCondition->created_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                        <div class="{{ $externalAreaCondition->approval_datetime ? 'bg-gray-50' : 'bg-white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $externalAreaCondition->updated_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('checklist-external-area.index', $externalAreaCondition->checklist->id) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('checklist-external-area.edit', $externalAreaCondition->id) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit External Area Condition
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>