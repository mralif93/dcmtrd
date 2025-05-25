<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('List Corporate Bond Security') }}
            </h2>

            <!-- Dropdown Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                    <span>{{ __('Menu') }}</span>
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 z-10 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="py-1">
                        <!-- Dashboard -->
                        <a href="{{ route('approver.dashboard', ['section' => 'dcmtrd']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Dashboard') }}
                        </a>

                        <!-- Trustee Fee -->
                        <a href="{{ route('trustee-fee-a.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Trustee Fee') }}
                        </a>

                        <!-- Compliance Covenant -->
                        <a href="{{ route('compliance-covenant-a.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Compliance Covenant') }}
                        </a>

                        <!-- Activity Diary -->
                        <a href="{{ route('activity-diary-a.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Activity Diary') }}
                        </a>

                        <!-- Listing Security -->
                        <a href="{{ route('list-security-a.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Listing Security') }}
                        </a>

                        <!-- Listing Security -->
                        <a href="{{ route('fund-transfer-a.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Placement & Fund Transfer') }}
                        </a>

                        <!-- Audit Log -->
                        <a href="#" class="hidden block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Audit Log') }}
                        </a>

                        <!-- Reports -->
                        <a href="#" class="hidden block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Reports') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="flex items-center justify-between px-4 py-5 sm:px-6">
                    <div class="flex space-x-2">
                        <!-- List Security Requests Button -->
                        <a href="{{ route('list-security-request-a.show') }}"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-green-500 border border-transparent rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6h18M3 12h18M3 18h18" />
                            </svg>
                            View Requests
                        </a>
                    </div>
                </div>

                <!-- Simple Search Bar -->
                <div class="px-4 py-4 border-t border-gray-200 bg-gray-50 sm:px-6">
                    <form method="GET" action="{{ route('list-security-a.index') }}">
                        <div
                            class="flex flex-col items-start gap-3 mt-8 md:flex-row md:items-center md:justify-between">
                            <!-- Added mt-8 here to push it further down -->
                            <!-- Text Search Input -->
                            <div class="w-full md:w-auto">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Search by any keyword"
                                    class="block w-full px-3 py-2 mt-1 border-gray-300 rounded-md shadow-sm md:w-64 focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center gap-2 mt-4 md:mt-0">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>

                                @if (request('search'))
                                    <a href="{{ route('list-security-a.index') }}"
                                        class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Tabs for Issuer Status -->
                <div x-data="{ status: '{{ request('status') ?? '' }}' }" class="bg-white border-b border-gray-200">
                    <nav class="flex px-4 py-3 space-x-2 text-sm font-medium text-gray-500" aria-label="Tabs">
                        @php
                            $statuses = [
                                '' => 'All',
                                'Draft' => 'Draft',
                                'Active' => 'Active',
                                'Pending' => 'Pending',
                                'Rejected' => 'Rejected',
                            ];
                        @endphp

                        @foreach ($statuses as $value => $label)
                            @php
                                $count = $statusCounts[$value] ?? 0;
                            @endphp
                            <a :class="status === '{{ $value }}' ? 'bg-indigo-100 text-indigo-700' :
                                'hover:bg-gray-100 text-gray-600'"
                                href="{{ route('list-security-a.index', array_merge(request()->except('page'), ['status' => $value])) }}"
                                @click="status = '{{ $value }}'" class="px-3 py-1.5 rounded-md transition">
                                {{ $label }} ({{ $count }})
                            </a>
                        @endforeach

                    </nav>
                </div>

                <!-- List of Securities Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    #
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Issuer
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Security Name
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Security Code
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Asset Name Type
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($securities as $security)
                                <tr>
                                    <!-- Serial Number -->
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration + ($securities->currentPage() - 1) * $securities->perPage() }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('list-security-a.details', ['security' => $security->id]) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $security->issuer->issuer_short_name ?? '-' }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->security_name }}
                                    </td>

                                    <!-- Security Code -->
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->security_code }}
                                    </td>

                                    <!-- Asset Name Type -->
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->asset_name_type }}
                                    </td>
                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <span
                                                class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
            {{ match ($security->status) {
                'Active' => 'bg-green-100 text-green-800',
                'Pending' => 'bg-yellow-100 text-yellow-800',
                'Rejected' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800',
            } }}">
                                                {{ $security->status ?? 'N/A' }}
                                            </span>

                                            @if ($security->status === 'Rejected' && $security->remarks)
                                                <p class="mt-1 text-xs text-red-600">
                                                    Reason: {{ $security->remarks }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>


                                    <!-- Actions (Approve/Reject) -->
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        @if ($security->status !== 'Draft' && $security->status !== 'Active' && $security->status !== 'Rejected')
                                            <div class="flex flex-row justify-end space-x-2">
                                                <!-- Approve Button -->
                                                <form method="POST"
                                                    action="{{ route('list-security-a.approve', $security) }}"
                                                    onsubmit="return confirm('Are you sure you want to approve this?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded hover:bg-green-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Approve
                                                    </button>
                                                </form>

                                                <!-- Reject Button (triggers modal) -->
                                                <button onclick="openRejectModal({{ $security->id }})"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">No action available</span>
                                            {{-- No action available --}}
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500">
                                        No securities found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $securities->links() }}
                </div>

                <!-- Reject Modal -->
                <div id="rejectModal"
                    class="fixed inset-0 z-50 items-center justify-center hidden transition duration-300 bg-black/30 backdrop-blur-sm">
                    <div
                        class="relative w-full max-w-md p-6 mx-auto bg-white border border-gray-100 shadow-xl rounded-2xl">
                        <h2 class="mb-4 text-lg font-semibold text-gray-800">Reject Security</h2>
                        <form method="POST" id="rejectForm">
                            @csrf
                            <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                            <textarea name="reason" rows="3" required
                                class="w-full p-2 mt-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-red-200 focus:outline-none"></textarea>

                            <div class="flex justify-end mt-6 space-x-2">
                                <button type="button" onclick="closeRejectModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow hover:bg-red-700">
                                    Confirm Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');

            form.action = `/approver/list-security/${id}/reject`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
