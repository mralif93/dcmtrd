<!-- resources/views/maker/checklist/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Details') }}
            </h2>
            <a href="{{ route('legal.dashboard', ['section' => 'reits']) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Checklist for: {{ $checklist->property_title }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $checklist->property_location }}</p>
                </div>

                <!-- Status Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($checklist->status)) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-blue-100 text-blue-800',
                                        'withdrawn' => 'bg-purple-100 text-purple-800',
                                        'in progress' => 'bg-indigo-100 text-indigo-800',
                                        'on hold' => 'bg-orange-100 text-orange-800',
                                        'reviewing' => 'bg-teal-100 text-teal-800',
                                        'approved' => 'bg-emerald-100 text-emerald-800',
                                        'expired' => 'bg-rose-100 text-rose-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($checklist->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- General Property Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Property Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Property Title</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->property_title }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Property Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->property_location }}</dd>
                        </div>
                        @if($checklist->siteVisit)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Related Site Visit</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{ route('site-visit-l.show', $checklist->siteVisit) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ date('d/m/Y', strtotime($checklist->siteVisit->date_visit)) }} - {{ $checklist->siteVisit->inspector_name }}
                                </a>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Legal Documentation Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">1.0 Legal Documentation</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Title Reference</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->title_ref ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Title Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->title_location ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Trust Deed Reference</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->trust_deed_ref ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Trust Deed Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->trust_deed_location ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Sale & Purchase Agreement</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->sale_purchase_agreement ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Lease Agreement Reference</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->lease_agreement_ref ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Lease Agreement Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->lease_agreement_location ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Agreement to Lease</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->agreement_to_lease ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Maintenance Agreement Reference</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->maintenance_agreement_ref ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Maintenance Agreement Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->maintenance_agreement_location ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Development Agreement</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->development_agreement ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Other Legal Documents</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->other_legal_docs ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Tenancy Agreement Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">2.0 Tenancy Agreement</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tenant Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->tenant_name ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tenant Property</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->tenant_property ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tenancy Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checklist->tenancy_approval_date ? date('d/m/Y', strtotime($checklist->tenancy_approval_date)) : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tenancy Commencement Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checklist->tenancy_commencement_date ? date('d/m/Y', strtotime($checklist->tenancy_commencement_date)) : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tenancy Expiry Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checklist->tenancy_expiry_date ? date('d/m/Y', strtotime($checklist->tenancy_expiry_date)) : 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- External Area Conditions Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">3.0 External Area Conditions</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.1 General Cleanliness</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_general_cleanliness_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_general_cleanliness_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->general_cleanliness_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->general_cleanliness_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.2 Fencing & Main Gate</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_fencing_gate_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_fencing_gate_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->fencing_gate_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->fencing_gate_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.3 External Facade</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_external_facade_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_external_facade_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->external_facade_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->external_facade_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.4 Car Park</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->car_park_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->car_park_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.5 Land Settlement</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_land_settlement_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_land_settlement_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->land_settlement_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->land_settlement_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.6 Rooftop</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_rooftop_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_rooftop_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->rooftop_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->rooftop_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">3.7 Drainage</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_drainage_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_drainage_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->drainage_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->drainage_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">External Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->external_remarks ?? 'No remarks' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Internal Area Conditions Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">4.0 Internal Area Conditions</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.1 Door & Window</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_door_window_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_door_window_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->door_window_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->door_window_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.2 Staircase</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_staircase_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_staircase_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->staircase_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->staircase_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.3 Toilet</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_toilet_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_toilet_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->toilet_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->toilet_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.4 Ceiling</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_ceiling_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_ceiling_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->ceiling_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->ceiling_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.5 Wall</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_wall_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_wall_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->wall_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->wall_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.6 Water Seeping/Leaking</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_water_seeping_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_water_seeping_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->water_seeping_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->water_seeping_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.7 Loading Bay</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_loading_bay_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_loading_bay_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->loading_bay_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->loading_bay_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">4.8 Basement Car Park</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_basement_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $checklist->is_basement_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                </span>
                                @if($checklist->basement_car_park_remarks)
                                <p class="mt-2 text-sm text-gray-700">{{ $checklist->basement_car_park_remarks }}</p>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Internal Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->internal_remarks ?? 'No remarks' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Property Development Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">5.0 Property Development</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.1 Development/Expansion</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->development_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->development_date)) }}</div>
                                @endif
                                @if($checklist->development_expansion_status)
                                <div class="mt-1">Scope: {{ $checklist->development_expansion_status }}</div>
                                @endif
                                @if($checklist->development_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->development_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->development_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->development_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->development_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->development_date && !$checklist->development_expansion_status && !$checklist->development_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.2 Renovation</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->renovation_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->renovation_date)) }}</div>
                                @endif
                                @if($checklist->renovation_status)
                                <div class="mt-1">Scope: {{ $checklist->renovation_status }}</div>
                                @endif
                                @if($checklist->renovation_completion_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->renovation_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->renovation_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->renovation_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->renovation_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->renovation_date && !$checklist->renovation_status && !$checklist->renovation_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.3 External Repainting</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->repainting_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->repainting_date)) }}</div>
                                @endif
                                @if($checklist->external_repainting_status)
                                <div class="mt-1">Scope: {{ $checklist->external_repainting_status }}</div>
                                @endif
                                @if($checklist->repainting_completion_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->repainting_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->repainting_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->repainting_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->repainting_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->repainting_date && !$checklist->external_repainting_status && !$checklist->repainting_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Disposal/Installation/Replacement Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">5.4 Disposal/Installation/Replacement</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">a) Water Tank/Calorifier Tank</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->water_tank_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->water_tank_date)) }}</div>
                                @endif
                                @if($checklist->water_tank_status)
                                <div class="mt-1">Scope: {{ $checklist->water_tank_status }}</div>
                                @endif
                                @if($checklist->water_tank_completion_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->water_tank_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->water_tank_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->water_tank_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->water_tank_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->water_tank_date && !$checklist->water_tank_status && !$checklist->water_tank_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">b) Air Conditioning/Chiller System/AHU</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->air_conditioning_approval_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->air_conditioning_approval_date)) }}</div>
                                @endif
                                @if($checklist->air_conditioning_scope)
                                <div class="mt-1">Scope: {{ $checklist->air_conditioning_scope }}</div>
                                @endif
                                @if($checklist->air_conditioning_status)
                                <div class="mt-1">Status Information: {{ $checklist->air_conditioning_status }}</div>
                                @endif
                                @if($checklist->air_conditioning_completion_status)
                                <div class="mt-1">Completion Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->air_conditioning_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->air_conditioning_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->air_conditioning_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->air_conditioning_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->air_conditioning_approval_date && !$checklist->air_conditioning_scope && !$checklist->air_conditioning_status && !$checklist->air_conditioning_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">c) Lift/Escalator System</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->lift_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->lift_date)) }}</div>
                                @endif
                                @if($checklist->lift_escalator_scope)
                                <div class="mt-1">Scope: {{ $checklist->lift_escalator_scope }}</div>
                                @endif
                                @if($checklist->lift_escalator_status)
                                <div class="mt-1">Status Information: {{ $checklist->lift_escalator_status }}</div>
                                @endif
                                @if($checklist->lift_escalator_completion_status)
                                <div class="mt-1">Completion Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->lift_escalator_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->lift_escalator_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->lift_escalator_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->lift_escalator_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->lift_date && !$checklist->lift_escalator_scope && !$checklist->lift_escalator_status && !$checklist->lift_escalator_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">d) Fire Fighting/Alarm System</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->fire_system_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->fire_system_date)) }}</div>
                                @endif
                                @if($checklist->fire_system_scope)
                                <div class="mt-1">Scope: {{ $checklist->fire_system_scope }}</div>
                                @endif
                                @if($checklist->fire_system_status)
                                <div class="mt-1">Status Information: {{ $checklist->fire_system_status }}</div>
                                @endif
                                @if($checklist->fire_system_completion_status)
                                <div class="mt-1">Completion Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->fire_system_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->fire_system_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->fire_system_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->fire_system_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->fire_system_date && !$checklist->fire_system_scope && !$checklist->fire_system_status && !$checklist->fire_system_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">e) Others</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($checklist->other_system_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->other_system_date)) }}</div>
                                @endif
                                @if($checklist->other_property)
                                <div class="mt-1">Details: {{ $checklist->other_property }}</div>
                                @endif
                                @if($checklist->other_completion_status)
                                <div class="mt-1">Completion Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $checklist->other_completion_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($checklist->other_completion_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($checklist->other_completion_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->other_completion_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!$checklist->other_system_date && !$checklist->other_property && !$checklist->other_completion_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Other Proposals/Approvals Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">5.5 Other Proposals/Approvals</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Details</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->other_proposals_approvals ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">System Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->verified_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checklist->approval_datetime ? $checklist->approval_datetime->format('d/m/Y h:i A') : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->created_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->updated_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->remarks ?? 'No remarks available' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('legal.dashboard', ['section' => 'reits']) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('checklist-l.edit', $checklist) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Checklist
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>