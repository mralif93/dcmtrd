<!-- resources/views/site-visits/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Site Visit') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('site-visits.edit', $siteVisit) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Site Visit
                </a>
                <a href="{{ route('site-visits.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Site Visits
                </a>
            </div>
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

            <!-- Site Visit Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Site Visit Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Visitor Name</div>
                                <div>{{ $siteVisit->visitor_name }}</div>
                                
                                <div class="text-sm text-gray-500">Email</div>
                                <div>{{ $siteVisit->visitor_email }}</div>
                                
                                <div class="text-sm text-gray-500">Phone</div>
                                <div>{{ $siteVisit->visitor_phone }}</div>
                                
                                <div class="text-sm text-gray-500">Property</div>
                                <div>{{ $siteVisit->property->name ?? 'N/A' }}</div>
                                
                                <div class="text-sm text-gray-500">Unit</div>
                                <div>{{ $siteVisit->unit->unit_number ?? 'N/A' }}</div>
                                
                                <div class="text-sm text-gray-500">Visit Date</div>
                                <div>{{ $siteVisit->visit_date->format('M d, Y h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Visit Type</div>
                                <div>{{ $siteVisit->visit_type }}</div>
                                
                                <div class="text-sm text-gray-500">Status</div>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($siteVisit->visit_status === 'Completed') bg-green-100 text-green-800
                                        @elseif($siteVisit->visit_status === 'Scheduled') bg-blue-100 text-blue-800
                                        @elseif($siteVisit->visit_status === 'Cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $siteVisit->visit_status }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-500">Conducted By</div>
                                <div>{{ $siteVisit->conducted_by }}</div>
                                
                                <div class="text-sm text-gray-500">Source</div>
                                <div>{{ $siteVisit->source }}</div>
                                
                                <div class="text-sm text-gray-500">Interested</div>
                                <div>{{ $siteVisit->interested ? 'Yes' : 'No' }}</div>
                                
                                @if($siteVisit->quoted_price)
                                <div class="text-sm text-gray-500">Quoted Price</div>
                                <div>${{ number_format($siteVisit->quoted_price, 2) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($siteVisit->actual_visit_start || $siteVisit->actual_visit_end)
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-gray-500">Actual Visit Start</div>
                            <div>{{ $siteVisit->actual_visit_start ? $siteVisit->actual_visit_start->format('M d, Y h:i A') : 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Actual Visit End</div>
                            <div>{{ $siteVisit->actual_visit_end ? $siteVisit->actual_visit_end->format('M d, Y h:i A') : 'N/A' }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($siteVisit->follow_up_required)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Follow Up Required</div>
                        <div>Yes - {{ $siteVisit->follow_up_date ? $siteVisit->follow_up_date->format('M d, Y') : 'No date set' }}</div>
                    </div>
                    @endif
                    
                    @if($siteVisit->visitor_feedback)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Visitor Feedback</div>
                        <div class="mt-1 p-3 border rounded bg-gray-50">{{ $siteVisit->visitor_feedback }}</div>
                    </div>
                    @endif
                    
                    @if($siteVisit->agent_notes)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Agent Notes</div>
                        <div class="mt-1 p-3 border rounded bg-gray-50">{{ $siteVisit->agent_notes }}</div>
                    </div>
                    @endif
                    
                    @if($siteVisit->requirements)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Requirements</div>
                        <div class="mt-1 p-3 border rounded bg-gray-50">
                            <pre class="text-sm">{{ json_encode(json_decode($siteVisit->requirements), JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-between">
                <div>
                    <a href="{{ route('site-visits.index') }}" 
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Site Visits
                    </a>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('site-visits.edit', $siteVisit) }}" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <form action="{{ route('site-visits.destroy', $siteVisit) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('Are you sure you want to delete this site visit?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>