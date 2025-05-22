<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Transaction Documents') }}
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
                        <a href="{{ route('maker.dashboard', ['section' => 'dcmtrd']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Dashboard') }}
                        </a>

                        <!-- Trustee Fee -->
                        <a href="{{ route('trustee-fee-m.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Trustee Fee') }}
                        </a>

                        <!-- Compliance Covenant -->
                        <a href="{{ route('compliance-covenant-m.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Compliance Covenant') }}
                        </a>

                        <!-- Activity Diary -->
                        <a href="{{ route('activity-diary-m.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Activity Diary') }}
                        </a>

                        <!-- Listing Security -->
                        <a href="{{ route('list-security-m.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Transaction Documents') }}
                        </a>

                        <!-- Listing Security -->
                        <a href="{{ route('fund-transfer-m.index') }}"
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

    <script>
        function confirmApproval(event, value) {
            event.preventDefault();
            if (confirm(`Are you confirm to submit the trustee fee "${value}" for approval?`)) {
                // If confirmed, proceed to the approval page
                window.location.href = event.currentTarget.href;
            }
        }
    </script>

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

            <div class="overflow-hidden bg-white shadow rounded-xl">
                <div
                    class="flex flex-col px-6 py-5 space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">📄 List of Transaction Documents</h3>
                        <p class="px-4 py-2 mt-2 text-sm text-red-800 bg-red-100 rounded-md shadow-sm">
                            ⚠️ Only <strong>active</strong> status will display in Legal Department view.<br>
                            Make sure status is <strong>active</strong> and <strong>submitted for approval</strong>
                            first.
                        </p>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row sm:gap-3">
                        <!-- Create Button -->
                        <a href="{{ route('legal.request-documents.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition duration-150 bg-pink-700 rounded-lg shadow hover:bg-pink-800">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Make Request
                        </a>

                        <!-- Add Transaction Documents Button -->
                        <a href="{{ route('list-security-m.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition duration-150 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Transaction Documents
                        </a>

                        <!-- View Requests Button -->
                        <a href="{{ route('list-security-request-m.show') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition duration-150 bg-green-600 rounded-lg shadow hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6h18M3 12h18M3 18h18" />
                            </svg>
                            View Requests
                        </a>
                    </div>
                </div>

                <!-- Simple Search Bar -->
                <div class="px-4 py-4 border-t border-gray-200 bg-gray-50 sm:px-6">
                    <form method="GET" action="{{ route('list-security-m.index') }}">
                        <div
                            class="flex flex-col items-start gap-3 mt-8 md:flex-row md:items-center md:justify-between">
                            <!-- Added mt-8 here to push it further down -->
                            <!-- Text Search Input -->
                            <div class="w-full md:w-auto">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Search by invoice no or keyword"
                                    class="block w-full px-3 py-2 mt-1 border-gray-300 rounded-md shadow-sm md:w-64 focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center gap-2 mt-4 md:mt-0">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>

                                @if (request('search'))
                                    <a href="{{ route('list-security-m.index') }}"
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
                                href="{{ route('list-security-m.index', array_merge(request()->except('page'), ['status' => $value])) }}"
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
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration + ($securities->currentPage() - 1) * $securities->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('list-security-m.details', ['security' => $security->id]) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $security->issuer->issuer_short_name ?? '-' }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->security_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->security_code }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->asset_name_type }}
                                    </td>
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
                                                <p class="mt-1 text-xs text-red-600">Reason: {{ $security->remarks }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        @if ($security->status === 'Draft')
                                            <div class="flex flex-row justify-end space-x-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('list-security-m.edit', $security) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded hover:bg-indigo-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <!-- Submit for Approval Button -->
                                                <form method="POST"
                                                    action="{{ route('list-security-m.approval', $security) }}"
                                                    onsubmit="return confirm('Submit for approval?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M8 16l4-4-4-4m8 8V8" />
                                                        </svg>
                                                        Submit
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif ($security->status === 'Rejected')
                                            <form method="POST"
                                                action="{{ route('list-security-m.reset', $security) }}"
                                                onsubmit="return confirm('Reset to Draft?');">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 4v5h.582M20 20v-5h-.581M4.582 9A7.97 7.97 0 018 4a8 8 0 018 8h4m-4 0a8 8 0 01-8 8 7.97 7.97 0 01-3.418-.732" />
                                                    </svg>
                                                    Reset to Draft
                                                </button>

                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">No action available</span>
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
            </div>
        </div>
    </div>
</x-app-layout>
