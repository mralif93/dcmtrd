<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Issuer Information') }}
            </h2>
            
            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
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

            <div class="pb-6">
              <h1 class="font-bold text-xl">{{ $issuer->issuer_name }}</h1>
              <p class="text-grey-800 leading-light">Issuer Short Name: {{ $issuer->issuer_short_name }}</p>
              <p class="text-grey-800 leading-light">Registration Number: {{ $issuer->registration_number }}</p>
            </div>

            <div class="flex justify-end items-end">
                <a href="{{ route('bond-m.create', $issuer) }}" class="inline-flex items-center px-4 py-2 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 active:bg-blue-300 transition">
                    Create New Bond
                </a>
            </div>

            <!-- Table Bond -->
            <div class="bg-white border-b border-gray-200 shadow rounded-lg mt-4">
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Bond/Sukuk Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Rating') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Category') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Last Traded Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Yield (%)') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Price (RM)') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Traded Amt (RM mil)') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('O/S Amt (RM mil)') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Residual Tenure') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bonds as $bond)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('security-info.show', $bond) }}">
                                            {{ $bond->bond_sukuk_name }}
                                        </a>
                                    </div>
                                    @if($bond->sub_name)
                                        <div class="text-sm text-gray-500 mt-1">{{ $bond->sub_name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        {{ $bond->rating ?? __('N/A') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
                                        {{ $bond->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $bond->last_traded_date?->format('d M Y') ?? __('N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $bond->last_traded_yield ? number_format($bond->last_traded_yield, 2) : __('N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $bond->last_traded_price ? number_format($bond->last_traded_price, 2) : __('N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $bond->last_traded_amount ? number_format($bond->last_traded_amount, 2) : __('N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($bond->o_s_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">
                                        {{ number_format($bond->residual_tenure, 2) }} yrs
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('bond-m.edit', $bond) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500">
                                    {{ __('No bond issues found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($bonds->hasPages())
                    <div class="p-6">
                        {{ $bonds->links() }}
                    </div>
                @endif
            </div>

            <div class="flex justify-end items-end pt-6">
                <a href="{{ route('announcement-m.create', $issuer) }}" class="inline-flex items-center px-4 py-2 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 active:bg-blue-300 transition">
                    Create New Announcement
                </a>
            </div>

            <!-- Table Issuer -->
            <div class="bg-white border-b border-gray-200 shadow rounded-lg mt-4">
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Announce Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Announcement Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($announcements as $announcement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ $announcement->announcement_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        {{ $announcement->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm max-w-md">
                                    <a href="{{ route('announcement-m.show', $announcement) }}">
                                        <div class="font-medium text-gray-500">{{ $announcement->title }}</div>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('announcement-m.edit', $announcement) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No announcements found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($announcements->hasPages())
                    <div class="p-6 border-t">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
