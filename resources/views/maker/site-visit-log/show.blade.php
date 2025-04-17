<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Diary Details') }}
        </h2>
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
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Activity Diary Information</h3>
                </div>

                <!-- Status & Verification Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $siteVisitLog->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($siteVisitLog->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($siteVisitLog->status) }}
                                </span>
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Follow-up Required</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $siteVisitLog->follow_up_required ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $siteVisitLog->follow_up_required ? 'Required' : 'Not Required' }}
                                </span>
                            </dd>
                        </div>

                        @if($siteVisitLog->prepared_by)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->prepared_by }}</dd>
                        </div>
                        @endif
                        
                        @if($siteVisitLog->verified_by)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->verified_by }}</dd>
                        </div>
                        @endif
                        
                        @if($siteVisitLog->approval_datetime)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date/Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($siteVisitLog->approval_datetime)->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Remarks Section -->
                @if($siteVisitLog->remarks)
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Remarks</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-900">{{ $siteVisitLog->remarks }}</p>
                        </div>
                    </dl>
                </div>
                @endif

                <!-- Basic Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Basic Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Site Visit</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $siteVisitLog->siteVisit->property->name }} ({{ $siteVisitLog->siteVisit->property->city }})
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Visit Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->visitation_date->format('d/m/Y') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Purpose of Visit</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->purpose }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Report Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Report Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Report Submission Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $siteVisitLog->report_submission_date ? $siteVisitLog->report_submission_date->format('d/m/Y') : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Report Attachment</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($siteVisitLog->report_attachment)
                                    <div class="flex items-center">
                                        <a href="{{ asset('storage/' . $siteVisitLog->report_attachment) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                            {{ basename($siteVisitLog->report_attachment) }}
                                        </a>
                                        <a href="{{ asset('storage/' . $siteVisitLog->report_attachment) }}" class="ml-2 text-indigo-600 hover:text-indigo-900" target="_blank">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-gray-500">No attachment</span>
                                @endif
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
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @if($siteVisitLog->deleted_at)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Deleted At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siteVisitLog->deleted_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        @if(!$siteVisitLog->follow_up_required)
                        <form action="#" method="POST" class="hidden inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Mark for Follow-up
                            </button>
                        </form>
                        @endif

                        <div class="flex space-x-2">
                            <a href="{{ route('site-visit-log-m.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('site-visit-log-m.edit', $siteVisitLog) }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Activity Diary
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>