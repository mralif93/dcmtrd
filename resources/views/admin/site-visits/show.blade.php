<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Site Visit Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('site-visits.index') }}" class="text-blue-500 hover:underline">
                            &larr; Back to Site Visits
                        </a>
                    </div>

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
                            <div>{!! $siteVisit->status_badge !!}</div>
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
                                            <span>{{ $siteVisit->date_site_visit->format('F d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Inspector:</span>
                                            <span>{{ $siteVisit->inspector_name ?? 'Not Assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between py-1 border-b">
                                            <span class="font-medium">Status:</span>
                                            <span>{!! $siteVisit->status_badge !!}</span>
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

                            @if($siteVisit->notes)
                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                                    <div class="mt-2 p-4 bg-gray-50 rounded text-sm">
                                        {!! nl2br(e($siteVisit->notes)) !!}
                                    </div>
                                </div>
                            @endif

                            @if($siteVisit->attachment)
                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Attachment</h4>
                                    <div class="mt-2">
                                        <a href="{{ route('site-visits.download', $siteVisit) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download Attachment
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-2">
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
    </div>
</x-app-layout>