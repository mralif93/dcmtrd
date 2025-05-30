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

                <!-- Status Badge -->
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ 
                                $activity->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                ($activity->status == 'overdue' ? 'bg-red-100 text-red-800' : 
                                ($activity->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                ($activity->status == 'compiled' ? 'bg-purple-100 text-purple-800' : 
                                ($activity->status == 'notification' ? 'bg-orange-100 text-orange-800' : 
                                ($activity->status == 'passed' ? 'bg-teal-100 text-teal-800' : 'bg-yellow-100 text-yellow-800'))))) 
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $activity->status ?? 'pending')) }}
                            </span>
                            
                            @if($activity->due_date)
                                @php
                                    $remainingDays = \Carbon\Carbon::now()->startOfDay()->diffInDays($activity->due_date, false);
                                @endphp
                                <span class="ml-3 text-sm {{ $remainingDays < 0 ? 'text-red-600 font-medium' : ($remainingDays <= 2 ? 'text-orange-600 font-medium' : 'text-gray-600') }}">
                                    {{ $remainingDays < 0 
                                        ? 'Overdue by ' . abs($remainingDays) . ' ' . Str::plural('day', abs($remainingDays))
                                        : $remainingDays . ' ' . Str::plural('day', $remainingDays) . ' remaining' 
                                    }}
                                </span>
                            @endif
                        </div>

                        <div>
                            @if($activity->hasExtensions())
                                <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded-full font-medium">
                                    Has {{ $activity->extension_date_2 ? '2' : '1' }} extension(s)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex justify-between items-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $activity->status == 'active' ? 'bg-green-100 text-green-800' : 
                                       ($activity->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($activity->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                                
                                <!-- Approval Actions -->
                                @if($activity->status == 'pending')
                                <div class="flex space-x-2">
                                    <!-- Approve Button -->
                                    <form action="{{ route('activity-diary-a.approve', $activity) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    
                                    <!-- Reject Button (Modal Trigger) -->
                                    <button type="button" onclick="openRejectModal()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                                @endif
                            </dd>
                        </div>
                        
                        @if($activity->prepared_by)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->prepared_by }}</dd>
                        </div>
                        @endif
                        
                        @if($activity->verified_by)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->verified_by }}</dd>
                        </div>
                        @endif
                        
                        @if($activity->approval_datetime)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($activity->approval_datetime)->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif

                        @if($activity->remarks)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->remarks ?? 'N/A' }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Issuer Information Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Issuer</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->issuer->issuer_name ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Issuer Short Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->issuer->issuer_short_name ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Activity Details Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Activity Details</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->purpose }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Letter Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->letter_date ? $activity->letter_date->format('d/m/Y') : 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->due_date ? $activity->due_date->format('d/m/Y') : 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Extension Date 1</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->extension_date_1 ? $activity->extension_date_1->format('d/m/Y') : 'N/A' }}
                                @if($activity->extension_note_1)
                                    <span class="ml-2 text-gray-500">({{ $activity->extension_note_1 }})</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Extension Date 2</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->extension_date_2 ? $activity->extension_date_2->format('d/m/Y') : 'N/A' }}
                                @if($activity->extension_note_2)
                                    <span class="ml-2 text-gray-500">({{ $activity->extension_note_2 }})</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->remarks ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Latest Due Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @php
                                    $latestDueDate = $activity->getLatestDueDate();
                                @endphp
                                {{ $latestDueDate ? \Carbon\Carbon::parse($latestDueDate)->format('d/m/Y') : 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Formatted Due Dates Timeline Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Due Dates Timeline</h3>
                    
                    @php
                        $dueDates = $activity->getAllDueDates();
                    @endphp
                    
                    @if(count($dueDates) > 0)
                        <div class="space-y-6">
                            @foreach($dueDates as $index => $dateInfo)
                                @php
                                    $daysFromNow = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($dateInfo['date']), false);
                                    $isPast = $daysFromNow < 0;
                                    $dateLabel = $index === 0 ? 'Original Due Date' : 'Extension ' . $index;
                                    $badgeColor = $index === 0 ? 'bg-blue-500' : ($index === 1 ? 'bg-orange-500' : 'bg-red-500');
                                    $badgeText = $index === 0 ? '1' : ($index === 1 ? '2' : '3');
                                @endphp
                                
                                <div class="rounded-md bg-white shadow-sm border border-gray-200 overflow-hidden">
                                    <div class="flex items-center px-4 py-3 sm:px-6 bg-gray-50 border-b border-gray-200">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full {{ $badgeColor }} flex items-center justify-center mr-3">
                                            <span class="text-white font-bold">{{ $badgeText }}</span>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">{{ $dateLabel }}</div>
                                    </div>
                                    
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="text-lg font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($dateInfo['date'])->format('d F Y') }}
                                        </div>
                                        
                                        @if($dateInfo['note'])
                                            <div class="mt-2 text-sm text-gray-700">{{ $dateInfo['note'] }}</div>
                                        @endif
                                        
                                        <div class="mt-2">
                                            @if($isPast)
                                                <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">
                                                    Passed {{ abs($daysFromNow) }} days ago
                                                </span>
                                            @elseif($daysFromNow === 0)
                                                <span class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">
                                                    Due today
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">
                                                    Due in {{ $daysFromNow }} days
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-sm text-gray-500 italic">No due dates set for this activity</div>
                    @endif
                </div>

                <!-- Verification Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Verification Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->verified_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->approval_datetime ? $activity->approval_datetime->format('d/m/Y H:i') : 'N/A' }}
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
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <a href="{{ route('activity-diary-a.index') }}" 
                    class="mr-3 mb-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                    
                    <a href="{{ route('activity-diary-a.by-issuer', $activity->issuer_id) }}" 
                    class="mb-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        View All Activities for {{ $activity->issuer->issuer_short_name ?? 'Issuer' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="fixed inset-0 overflow-y-auto hidden" id="rejectionModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('activity-diary-a.reject', $activity) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Activity Diary</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Please provide a reason for rejecting this activity diary. This information will be saved in the remarks field.
                                    </p>
                                    <div class="mt-3">
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                        <div class="mt-1">
                                            <textarea id="rejection_reason" name="rejection_reason" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Reject
                        </button>
                        <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openRejectModal() {
            document.getElementById('rejectionModal').classList.remove('hidden');
        }
        
        function closeRejectModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>