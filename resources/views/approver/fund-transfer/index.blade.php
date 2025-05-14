<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Placement & Fund Transfer') }}
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

            @php
                // Get all available months
                $start = \Carbon\Carbon::create(2024, 1, 1);
                $end = now();
                $months = [];

                while ($start <= $end) {
                    $months[] = $start->copy();
                    $start->addMonth();
                }

                // Set active month if passed in the request, otherwise, show all records
                $activeMonth = request('month') ?? null;
            @endphp

            <!-- Scrollable month pills -->
            <div class="p-4 mb-2 bg-white rounded-lg shadow">
                <div class="pb-2 overflow-x-auto border-b border-gray-200">
                    <div class="px-2 min-w-max">
                        <nav class="flex gap-2 whitespace-nowrap">
                            <!-- Add "All" option for showing all records -->
                            <a href="?"
                                class="px-4 py-2 rounded-full text-sm font-medium border transition
                            {{ !$activeMonth ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                All
                            </a>
                            @foreach ($months as $month)
                                @php
                                    $label = $month->format('Y M');
                                    $value = $month->format('Y-m');
                                    $isActive = $value === $activeMonth;
                                @endphp
                                <a href="?month={{ $value }}"
                                    class="px-4 py-2 rounded-full text-sm font-medium border transition
                                {{ $isActive ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Table for displaying Placement & Fund Transfer -->
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">List of Placement & Fund Transfers</h3>
                    <span
                        class="text-sm text-gray-500">{{ $activeMonth ? \Carbon\Carbon::parse($activeMonth)->format('F Y') : 'All Records' }}</span>
                </div>

                <!-- Table Container -->
                <div class="px-6 py-4">
                    <div class="w-full overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm table-auto">
                                <thead>
                                    <tr class="text-sm text-left text-gray-500 bg-gray-100">
                                        <th class="px-6 py-3 font-medium">Date</th>
                                        <th class="px-8 py-3 font-medium">Details</th>
                                        <th class="px-6 py-3 font-medium">Placement Amount</th>
                                        <th class="px-6 py-3 font-medium">Fund Transfer Amount</th>
                                        <th class="px-6 py-3 font-medium">Prepared By</th>
                                        <th class="px-6 py-3 font-medium">Verified By</th>
                                        <th class="px-6 py-3 font-medium">Verified Date</th>
                                        <th class="px-6 py-3 font-medium">Status</th>
                                        <th class="px-6 py-3 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($fundTransfers as $fundTransfer)
                                        <tr class="text-sm text-gray-600 border-t">
                                            <td class="px-6 py-3 text-left whitespace-nowrap">{{ $fundTransfer->date }}
                                            </td>
                                            <td
                                                class="max-w-md px-6 py-3 text-sm break-words whitespace-pre-wrap align-top">
                                                {{ $fundTransfer->details }}
                                            </td>

                                            <td class="px-6 py-3 text-right">
                                                {{ number_format($fundTransfer->placement_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-3 text-right">
                                                {{ number_format($fundTransfer->fund_transfer_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-3">{{ $fundTransfer->prepared_by }}</td>
                                            <td class="px-6 py-3">{{ $fundTransfer->verified_by ?? '-' }}</td>
                                            <td class="px-6 py-3">{{ $fundTransfer->approval_datetime ?? '-' }}</td>
                                            <td class="px-6 py-3">
                                                @if ($fundTransfer->status === 'Pending')
                                                    <span class="px-2 py-1 text-xs text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                                                @elseif ($fundTransfer->status === 'Approved')
                                                    <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">Approved</span>
                                                @elseif ($fundTransfer->status === 'Rejected')
                                                    <div class="space-y-1">
                                                        <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded-full">Rejected</span>
                                                        @if ($fundTransfer->remarks)
                                                            <p class="text-xs text-red-600">Reason: {{ $fundTransfer->remarks }}</p>
                                                        @endif
                                                    </div>
                                                @elseif ($fundTransfer->status === 'Draft')
                                                    <span class="px-2 py-1 text-xs text-gray-700 bg-gray-300 rounded-full">Draft</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs text-gray-800 bg-gray-100 rounded-full">Unknown</span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-6 py-3 space-y-1 text-center">

                                                @if ($fundTransfer->status === 'Pending')
                                                    <a href="{{ route('done-fund-transfer-a.approval', $fundTransfer) }}"
                                                        class="inline-block px-3 py-1 mt-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">
                                                        Approve
                                                    </a>
                                                    <button onclick="openRejectModal({{ $fundTransfer->id }})"
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Reject
                                                    </button>
                                                @endif


                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-3 text-center text-gray-500">No records
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            <script>
                function openRejectModal(id) {
                    const modal = document.getElementById('rejectModal');
                    const form = document.getElementById('rejectForm');
        
                    form.action = `/approver/fund-transfer/${id}/reject`;
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
