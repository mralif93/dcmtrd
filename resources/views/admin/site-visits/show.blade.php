<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Site Visit Details') }}
            </h2>
            <a href="{{ route('site-visits.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 p-4 rounded-md">
                            <div class="text-green-600 font-medium">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-700">
                                Site Visit for {{ $siteVisit->property->name }}
                            </h3>
                            <div class="px-2 py-1 rounded text-xs font-semibold {{ $siteVisit->getStatusBadgeClassAttribute() }}">
                                {{ ucfirst($siteVisit->status) }}
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Property Details</h4>
                                    <div class="mt-1 text-sm text-gray-900">
                                        <p class="font-semibold">{{ $siteVisit->property->name }}</p>
                                        <p>{{ $siteVisit->property->address }}</p>
                                        <p>{{ $siteVisit->property->city }}, {{ $siteVisit->property->state }} {{ $siteVisit->property->postal_code }}</p>
                                        <p>{{ $siteVisit->property->country }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Visit Information</h4>
                                    <div class="mt-1 text-sm">
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Date:</span>
                                            <span>{{ $siteVisit->date_visit->format('F d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Time:</span>
                                            <span>{{ $siteVisit->getFormattedTimeAttribute() }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Status:</span>
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $siteVisit->getStatusBadgeClassAttribute() }}">
                                                {{ ucfirst($siteVisit->status) }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Created:</span>
                                            <span>{{ $siteVisit->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Last Updated:</span>
                                            <span>{{ $siteVisit->updated_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 mt-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Personnel</h4>
                                    <div class="mt-1 text-sm">
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Trustee:</span>
                                            <span>{{ $siteVisit->trustee ?? 'Not Assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Manager:</span>
                                            <span>{{ $siteVisit->manager ?? 'Not Assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Maintenance Manager:</span>
                                            <span>{{ $siteVisit->maintenance_manager ?? 'Not Assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Building Manager:</span>
                                            <span>{{ $siteVisit->building_manager ?? 'Not Assigned' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Approval Information</h4>
                                    <div class="mt-1 text-sm">
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Prepared By:</span>
                                            <span>{{ $siteVisit->prepared_by ?? 'Not Assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Verified By:</span>
                                            <span>{{ $siteVisit->verified_by ?? 'Not Verified' }}</span>
                                        </div>
                                        @if($siteVisit->approval_datetime)
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Approval Date:</span>
                                            <span>{{ \Carbon\Carbon::parse($siteVisit->approval_datetime)->format('M d, Y H:i') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($siteVisit->notes)
                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                                    <div class="mt-2 p-4 bg-gray-50 rounded text-sm">
                                        {!! nl2br(e($siteVisit->notes)) !!}
                                    </div>
                                </div>
                            @endif

                            @if($siteVisit->hasAttachment())
                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Attachment</h4>
                                    <div class="mt-2">
                                        <a href="{{ route('site-visits.download-attachment', $siteVisit) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download Attachment
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($siteVisit->isScheduled())
                                <div class="mt-6 p-4 bg-blue-50 rounded-md border border-blue-100">
                                    <h4 class="text-sm font-medium text-blue-700">Actions</h4>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <a href="{{ route('site-visits.edit', $siteVisit) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit Visit
                                        </a>
                                        <button type="button" onclick="document.getElementById('complete-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Mark as Completed
                                        </button>
                                        <button type="button" onclick="document.getElementById('cancel-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel Visit
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-wrap justify-end gap-2">
                            <a href="{{ route('site-visits.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Back to List
                            </a>
                            <a href="{{ route('site-visits.edit', $siteVisit) }}" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                Edit Site Visit
                            </a>
                            <form action="{{ route('site-visits.destroy', $siteVisit) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this site visit?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                    Delete Site Visit
                                </button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Mark as Completed Modal -->
    <div id="complete-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mark Visit as Completed</h3>
            <form action="{{ route('site-visits.mark-as-completed', $siteVisit) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label for="verified_by" class="block text-sm font-medium text-gray-700 mb-1">Verified By *</label>
                        <input type="text" name="verified_by" id="verified_by" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $siteVisit->notes }}</textarea>
                    </div>
                    
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
                        <input type="file" name="attachment" id="attachment" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('complete-modal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Mark as Completed
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Visit Modal -->
    <div id="cancel-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Cancel Site Visit</h3>
            <form action="{{ route('site-visits.mark-as-cancelled', $siteVisit) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="cancel_notes" class="block text-sm font-medium text-gray-700 mb-1">Reason for Cancellation *</label>
                    <textarea name="notes" id="cancel_notes" rows="3" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('cancel-modal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Close
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Cancel Visit
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>