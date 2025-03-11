<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">
                {{ __('Bonds List') }}
            </h2>

            <div class="flex gap-3">
                <!-- Create Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Create
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute left-0 z-10 w-48 mt-2 bg-white border rounded-md shadow-md">
                        <a href="{{ route('bonds.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Bond</a>
                        <a href="{{ route('related-documents-info.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Related Document</a>
                        <a href="{{ route('rating-movements-info.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Rating Movements</a>
                        <a href="{{ route('payment-schedules-info.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Payment Schedules</a>
                        <a href="{{ route('redemptions-info.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Redemptions</a>
                        <a href="{{ route('trading-activities-info.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Trading
                            Activities</a>
                    </div>
                </div>

                <!-- Upload Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="px-4 py-2 text-xs font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                        Upload
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute left-0 z-10 w-48 mt-2 bg-white border rounded-md shadow-md">
                        <a href="{{ route('upload.bond') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Upload Bonds</a>
                        <a href="{{ route('upload.rating-movement') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Upload Rating Movements</a>
                        <a href="{{ route('upload.payment-schedule') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Upload Payment Schedules</a>
                        <a href="{{ route('upload.trading-activity') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Upload Trading
                            Activities</a>
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

            <div class="p-6 bg-white rounded-lg shadow">
                <!-- Search and Create Header -->
                <div class="flex flex-col justify-between gap-4 mb-6 sm:flex-row">
                    <form method="GET" action="{{ route('bonds.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ $searchTerm }}"
                                placeholder="Search bond name, rating, or facility code..."
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">

                            <button type="submit"
                                class="px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                Search
                            </button>

                            @if ($searchTerm)
                                <a href="{{ route('bonds.index') }}"
                                    class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <!-- Table Container -->
                <div class="overflow-x-auto border rounded-lg shadow-sm">
                    <table class="w-full text-sm text-left min-w-max">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-medium text-gray-600 uppercase">
                                <th class="px-6 py-3">Prepared By</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Status Date</th>
                                <th class="px-6 py-3">Bond/Sukuk Name</th>
                                <th class="px-6 py-3">Rating</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Last Traded Date</th>
                                <th class="px-6 py-3">Last Traded Yield (%)</th>
                                <th class="px-6 py-3">Last Traded Price (RM)</th>
                                <th class="px-6 py-3">Last Traded Amount (RM 'mil)</th>
                                <th class="px-6 py-3">O/S Amount (RM'mil)</th>
                                <th class="px-6 py-3">Residual Tenure (Years)</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($bonds as $bond)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-600">{{ $bond->preparedBy->name }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 text-xs font-medium rounded-lg shadow-sm
                                            @if ($bond->status === 'Approved') text-green-800 bg-green-100 
                                            @elseif($bond->status === 'Re-Check') text-red-800 bg-red-100 
                                            @else text-yellow-800 bg-yellow-100 @endif">
                                            {{ $bond->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $bond->approval_date_time?->format('d M Y') ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-indigo-600">{{ $bond->bond_sukuk_name }}</td>
                                    <td class="px-6 py-4">{{ $bond->rating }}</td>
                                    <td class="px-6 py-4 font-medium">{{ $bond->category }}</td>
                                    <td class="px-6 py-4">{{ $bond->last_traded_date?->format('d M Y') ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $bond->last_traded_yield }}%</td>
                                    <td class="px-6 py-4">RM {{ number_format($bond->last_traded_price, 2) }}</td>
                                    <td class="px-6 py-4">RM {{ number_format($bond->last_traded_amount, 2) }} mil</td>
                                    <td class="px-6 py-4">RM {{ number_format($bond->outstanding_amount, 2) }} mil</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                            {{ round($bond->residual_tenure_years) }} yrs
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            @if ($bond->status === 'Re-Check' && auth()->user()->email !== 'roslimsyah@artrustees.com.my' && auth()->id() === $bond->prepared_by)
                                                <div x-data="{ open: false }" class="relative">
                                                    <!-- Button to Toggle Dropdown -->
                                                    <button @click="open = !open"
                                                        class="px-3 py-1 text-green-800 transition bg-green-100 rounded-md hover:bg-green-200">
                                                        Update
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div x-show="open" @click.away="open = false"
                                                        class="absolute left-0 z-10 w-40 mt-2 bg-white border rounded-md shadow-md">
                                                        <a href="{{ route('bonds.edit', $bond) }}"
                                                            class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-200">
                                                            Update Bond
                                                        </a>
                                                        <a href="{{ route('related-documents.edit', $bond) }}"
                                                            class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-200">
                                                            Update Related Documents
                                                        </a>
                                                        <a href="{{ route('rating-movements.edit', $bond) }}"
                                                            class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-200">
                                                            Update Rating Movements
                                                        </a>
                                                        <a href="{{ route('payment-schedules.edit', $bond) }}"
                                                            class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-200">
                                                            Update Payment Schedule
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- View Button (Always Visible) -->
                                            <a href="{{ route('bonds.show', $bond) }}"
                                                class="px-3 py-1 text-blue-800 transition bg-blue-100 rounded-md hover:bg-blue-200">
                                                Details
                                            </a>
                                        </div>
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                        No bonds found {{ $searchTerm ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($bonds->hasPages())
                    <div class="mt-6">
                        {{ $bonds->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
