<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Trustee Fees Management') }}
            </h2>

            <!-- Dropdown Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center text-gray-700 px-3 py-2 text-sm font-medium rounded-md bg-white border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none">
                    <span>{{ __('Menu') }}</span>
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" 
                    @click.away="open = false" 
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="py-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Dashboard') }}
                        </a>

                        <!-- Trustee Fee -->
                        <a href="{{ route('trustee-fee-a.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Trustee Fee') }}
                        </a>

                        <!-- Compliance Covenant -->
                        <a href="{{ route('compliance-covenant-a.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Compliance Covenant') }}
                        </a>

                        <!-- Activity Diary -->
                        <a href="{{ route('activity-diary-a.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Activity Diary') }}
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
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Trustee Fees</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Facility Search Field -->
                            <div>
                                <label for="facility_information_id" class="block text-sm font-medium text-gray-700">Facility</label>
                                <select name="facility_information_id" id="facility_information_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Facilities</option>
                                    @foreach($facilities as $facility)
                                        <option value="{{ $facility->id }}" @selected(request('facility_information_id') == $facility->id)>
                                            {{ $facility->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Month Filter -->
                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                                <select name="month" id="month" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Months</option>
                                    @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                        <option value="{{ $month }}" @selected(request('month') === $month)>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Search
                                </button>

                                @if(request('facility_information_id') || request('month'))
                                    <a href="{{ route('trustee-fee-a.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Trustee Fees Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facility</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anniversary Period</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($trustee_fees as $fee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('trustee-fee-a.show', $fee) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $fee->facility->name }}
                                            <p>({{ $fee->description  }})</p>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">RM {{ number_format($fee->getTotalAmount(), 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $fee->start_anniversary_date->format('d/m/Y') }} - 
                                        {{ $fee->end_anniversary_date->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $fee->status == 'Active' ? 'bg-green-100 text-green-800' : 
                                            ($fee->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($fee->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $fee->status }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('trustee-fee-a.show', $fee) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($trustee_fees->count() === 0)
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No trustee fees found.</div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $trustee_fees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>