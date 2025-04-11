<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">{{ __('Audit Log') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-500 rounded-md shadow-md bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
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

            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="flex items-center justify-between px-6 py-4 sm:px-6">
                    <h3 class="text-lg font-semibold text-gray-900">Audit Log</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('related-documents.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Export Audit Log
                        </a>
                    </div>
                </div>

                <div class="px-4 py-4 border-t border-gray-200 bg-gray-50 sm:px-6 rounded-t-md">
                    <form method="GET" action="{{ route('audit-trail.index') }}">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                            <!-- Start Date Filter -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ request('start_date') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- End Date Filter -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Search Field -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Search by user name...">
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Search
                                </button>

                                @if (request('search') || request('start_date') || request('end_date'))
                                    <a href="{{ route('audit-trail.index') }}"
                                        class="inline-flex items-center px-4 py-2 ml-2 font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Related Documents Table -->
                <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                    <table class="min-w-full divide-y divide-gray-200 table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    User</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Event</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Route</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    IP</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Device</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                                    Changes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($audits as $audit)
                                <tr class="hover:bg-gray-50">
                                    <!-- Date -->
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $audit->created_at->format('d/m/Y H:i:s') }}
                                    </td>

                                    <!-- User -->
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $audit->user->name ?? 'System' }}
                                    </td>

                                    <!-- Event -->
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $event = strtolower($audit->event);
                                            $color = match ($event) {
                                                'created' => 'text-blue-600 bg-blue-100',
                                                'updated' => 'text-green-600 bg-green-100',
                                                'deleted' => 'text-red-600 bg-red-100',
                                                default => 'text-gray-600 bg-gray-100',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-bold rounded-lg {{ $color }}">
                                            {{ ucfirst($event) }}
                                        </span>
                                    </td>


                                    <!-- Route -->
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $audit->url ?? 'N/A' }}
                                    </td>

                                    <!-- IP Address -->
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $audit->ip_address ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @php
                                            $userAgent = $audit->user_agent;
                                            $device = 'Unknown';
                                            $browser = 'Unknown';

                                            // Detect Device
                                            if (Str::contains($userAgent, 'Windows')) {
                                                $device = 'Windows';
                                            } elseif (Str::contains($userAgent, 'Macintosh')) {
                                                $device = 'Mac';
                                            } elseif (Str::contains($userAgent, 'Linux')) {
                                                $device = 'Linux';
                                            } elseif (Str::contains($userAgent, ['Android', 'iPhone'])) {
                                                $device = 'Mobile';
                                            }

                                            // Detect Browser
                                            if (
                                                Str::contains($userAgent, 'Chrome') &&
                                                !Str::contains($userAgent, 'Edg')
                                            ) {
                                                $browser = 'Chrome';
                                            } elseif (
                                                Str::contains($userAgent, 'Safari') &&
                                                !Str::contains($userAgent, 'Chrome')
                                            ) {
                                                $browser = 'Safari';
                                            } elseif (Str::contains($userAgent, 'Firefox')) {
                                                $browser = 'Firefox';
                                            } elseif (Str::contains($userAgent, 'Edg')) {
                                                $browser = 'Edge';
                                            } elseif (
                                                Str::contains($userAgent, 'Opera') ||
                                                Str::contains($userAgent, 'OPR')
                                            ) {
                                                $browser = 'Opera';
                                            }
                                        @endphp

                                        <div class="flex items-center space-x-2">
                                            <!-- Device Type -->
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                                                @if ($device === 'Windows') bg-blue-100 text-blue-800 @elseif($device === 'Mac') bg-gray-100 text-gray-800 
                                                @elseif($device === 'Linux') bg-yellow-100 text-yellow-800 @elseif($device === 'Mobile') bg-green-100 text-green-800 
                                                @else bg-gray-200 text-gray-600 @endif">
                                                {{ $device }}
                                            </span>

                                            <!-- Browser Type -->
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                                                @if ($browser === 'Chrome') bg-blue-100 text-blue-800 @elseif($browser === 'Safari') bg-gray-100 text-gray-800 
                                                @elseif($browser === 'Firefox') bg-red-100 text-red-800 @elseif($browser === 'Edge') bg-teal-100 text-teal-800 
                                                @elseif($browser === 'Opera') bg-purple-100 text-purple-800 @else bg-gray-200 text-gray-600 @endif">
                                                {{ $browser }}
                                            </span>
                                        </div>
                                    </td>


                                    <td class="px-6 py-4 text-sm">
                                        @if (!empty($audit->new_values))
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($audit->new_values as $key => $newValue)
                                                    @php
                                                        $oldValue = $audit->old_values[$key] ?? null; // Get old value (if exists)
                                                    @endphp
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-lg">
                                                        {{ ucfirst(str_replace('_', ' ', $key)) }}:

                                                        @if ($oldValue !== null)
                                                            <span
                                                                class="text-red-600 line-through">{{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}</span>
                                                            →
                                                        @endif

                                                        <span
                                                            class="text-green-600">{{ is_array($newValue) ? json_encode($newValue) : $newValue }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="italic text-gray-400">No changes</span>
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                        {{ $audits->links() }}
                    </div>
                </div>





                <!-- Pagination Links -->
                {{-- <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $documents->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
