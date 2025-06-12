<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Activity Diary Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <!-- Header Section -->
                <div class="flex items-center justify-between px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Activity Diary Information</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('activity-diary-m.edit', $activity) }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @php
                                $statusColors = [
                                    'Completed' => 'bg-green-100 text-green-800',
                                    'Overdue' => 'bg-red-100 text-red-800',
                                    'In Progress' => 'bg-blue-100 text-blue-800',
                                    'Compiled' => 'bg-purple-100 text-purple-800',
                                    'Notification' => 'bg-orange-100 text-orange-800',
                                    'Passed' => 'bg-teal-100 text-teal-800',
                                    'Draft' => 'bg-gray-100 text-gray-800',
                                    'Active' => 'bg-emerald-100 text-emerald-800',
                                    'Rejected' => 'bg-rose-100 text-rose-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                ];

                                $status = $activity->status ?? 'Pending';
                                $statusClass = $statusColors[$status] ?? 'bg-yellow-100 text-yellow-800';
                            @endphp

                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>


                            @if ($activity->due_date)
                                @php
                                    use Carbon\Carbon;
                                    use Illuminate\Support\Str;
                                
                                    // Parse dates at start of day
                                    $dueDate = Carbon::parse($activity->due_date)->startOfDay();
                                    $today = Carbon::today();
                                
                                    // Calculate exclusive days difference
                                    $remainingDays = $today->diffInDays($dueDate, false);
                                @endphp
                                <span
                                    class="ml-3 text-sm {{ $remainingDays < 0 ? 'text-red-600 font-medium' : ($remainingDays <= 2 ? 'text-orange-600 font-medium' : 'text-gray-600') }}">
                                    {{ $remainingDays < 0
                                        ? 'Overdue by ' . abs($remainingDays) . ' ' . Str::plural('day', abs($remainingDays))
                                        : $remainingDays . ' ' . Str::plural('day', $remainingDays) . ' remaining' }}
                                </span>
                            @endif
                        </div>

                        <div>
                            @if ($activity->hasExtensions())
                                <span class="px-2 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full">
                                    Has {{ $activity->extension_date_2 ? '2' : '1' }} extension(s)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Issuer Information Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Issuer</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->issuer->issuer_name ?? 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Issuer Short Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->issuer->issuer_short_name ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Activity Details Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Activity Details</h3>
                    </div>
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->purpose }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Letter Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->letter_date ? $activity->letter_date->format('d/m/Y') : 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->due_date ? $activity->due_date->format('d/m/Y') : 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Extension Date 1</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->extension_date_1 ? $activity->extension_date_1->format('d/m/Y') : 'N/A' }}
                                @if ($activity->extension_note_1)
                                    <span class="ml-2 text-gray-500">({{ $activity->extension_note_1 }})</span>
                                @endif
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Extension Date 2</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->extension_date_2 ? $activity->extension_date_2->format('d/m/Y') : 'N/A' }}
                                @if ($activity->extension_note_2)
                                    <span class="ml-2 text-gray-500">({{ $activity->extension_note_2 }})</span>
                                @endif
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->remarks ?? 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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
                <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                    <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Due Dates Timeline</h3>

                    @php
                        $dueDates = $activity->getAllDueDates();
                    @endphp

                    @if (count($dueDates) > 0)
                        <div class="space-y-6">
                            @foreach ($dueDates as $index => $dateInfo)
                                @php
                                    use Carbon\Carbon;
                                    use Illuminate\Support\Str;
                                
                                    // Parse dates at start of day
                                    $dateToCheck = Carbon::parse($dateInfo['date'])->startOfDay();
                                    $today = Carbon::today();
                                
                                    // Calculate exclusive days difference
                                    $daysFromNow = $today->diffInDays($dateToCheck, false);
                                    $isPast = $daysFromNow < 0;
                                    $dateLabel = $index === 0 ? 'Original Due Date' : 'Extension ' . $index;
                                    $badgeColor =
                                        $index === 0 ? 'bg-blue-500' : ($index === 1 ? 'bg-orange-500' : 'bg-red-500');
                                    $badgeText = $index === 0 ? '1' : ($index === 1 ? '2' : '3');
                                @endphp

                                <div class="overflow-hidden bg-white border border-gray-200 rounded-md shadow-sm">
                                    <div
                                        class="flex items-center px-4 py-3 border-b border-gray-200 sm:px-6 bg-gray-50">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 rounded-full {{ $badgeColor }} flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">{{ $badgeText }}</span>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">{{ $dateLabel }}</div>
                                    </div>

                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="text-lg font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($dateInfo['date'])->format('d F Y') }}
                                        </div>

                                        @if ($dateInfo['note'])
                                            <div class="mt-2 text-sm text-gray-700">{{ $dateInfo['note'] }}</div>
                                        @endif

                                        <div class="mt-2">
                                            @if ($isPast)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                                    Passed {{ abs($daysFromNow) }} days ago
                                                </span>
                                            @elseif($daysFromNow === 0)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                                    Due today
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                                    Due in {{ $daysFromNow }} days
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-sm italic text-gray-500">No due dates set for this activity</div>
                    @endif
                </div>

                <!-- Verification Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Verification Information</h3>
                    </div>
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->verified_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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
                        <h3 class="text-lg font-medium leading-6 text-gray-900">System Information</h3>
                    </div>
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $activity->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Status Update Section (if not completed) -->
                @if ($activity->status !== 'Pending' && $activity->status !== 'Rejected' && $activity->status !== 'Draft')
                    <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                        <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Update Status</h3>
                        <form action="{{ route('activity-diary-m.update-status', $activity) }}" method="POST"
                            class="flex flex-wrap items-center gap-4">
                            @csrf
                            @method('PATCH')

                            <select name="status"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="In_progress"
                                    {{ $activity->status == 'In_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed">Mark as Completed</option>
                                <option value="Overdue" {{ $activity->status == 'Overdue' ? 'selected' : '' }}>Overdue
                                </option>
                                <option value="Compiled" {{ $activity->status == 'Compiled' ? 'selected' : '' }}>
                                    Compiled</option>
                                <option value="Notification"
                                    {{ $activity->status == 'Notification' ? 'selected' : '' }}>Notification</option>
                                <option value="Passed" {{ $activity->status == 'Passed' ? 'selected' : '' }}>Passed
                                </option>
                            </select>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Status
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="px-4 py-4 border-t border-gray-200 sm:px-6">
                    <a href="{{ route('activity-diary-m.index') }}"
                        class="inline-flex items-center px-4 py-2 mb-2 mr-3 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                        </svg>
                        Back to List
                    </a>

                    <a href="{{ route('activity-diary-m.by-issuer', $activity->issuer_id) }}"
                        class="inline-flex items-center px-4 py-2 mb-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        View All Activities for {{ $activity->issuer->issuer_short_name ?? 'Issuer' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
