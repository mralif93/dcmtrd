<!-- resources/views/properties/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Property Details') }}
            </h2>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $property->name }}</h3>
                    </div>

                    <!-- Basic Information Section -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Basic Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Property Name</p>
                                    <p class="text-sm text-gray-900">{{ $property->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Category</p>
                                    <p class="text-sm text-gray-900">{{ $property->category }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Batch Number</p>
                                    <p class="text-sm text-gray-900">{{ $property->batch_no }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Portfolio</p>
                                    <p class="text-sm text-gray-900">
                                        <a href="{{ route('portfolios.show', $property->portfolio->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $property->portfolio->portfolio_name }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Status</p>
                                    <p class="text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $property->status ?? 'Active' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information Section -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Location Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div class="col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Address</p>
                                    <p class="text-sm text-gray-900">{{ $property->address }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">City</p>
                                    <p class="text-sm text-gray-900">{{ $property->city }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">State</p>
                                    <p class="text-sm text-gray-900">{{ $property->state }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Country</p>
                                    <p class="text-sm text-gray-900">{{ $property->country }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Postal Code</p>
                                    <p class="text-sm text-gray-900">{{ $property->postal_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Details Section -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Property Details</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Land Size</p>
                                    <p class="text-sm text-gray-900">{{ number_format($property->land_size, 2) }} sqm</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Gross Floor Area</p>
                                    <p class="text-sm text-gray-900">{{ number_format($property->gross_floor_area, 2) }} sqm</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Usage</p>
                                    <p class="text-sm text-gray-900">{{ $property->usage }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Ownership</p>
                                    <p class="text-sm text-gray-900">{{ $property->ownership }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Section -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Financial Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Value</p>
                                    <p class="text-sm text-gray-900">{{ number_format($property->value, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Share Amount</p>
                                    <p class="text-sm text-gray-900">{{ number_format($property->share_amount, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Market Value</p>
                                    <p class="text-sm text-gray-900">{{ number_format($property->market_value, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Associated Records Section -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Associated Records</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenants</p>
                                    <p class="text-sm text-gray-900">
                                        <a href="{{ route('properties.tenants', $property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $property->tenants->count() }} tenants
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Checklists</p>
                                    <p class="text-sm text-gray-900">
                                        <a href="{{ route('properties.checklists', $property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $property->checklists->count() }} checklists
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Site Visits</p>
                                    <p class="text-sm text-gray-900">
                                        <a href="{{ route('properties.site-visits', $property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $property->siteVisits->count() }} site visits
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information Section -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">System Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenants</p>
                                    <p class="text-sm text-gray-900">
                                        <a href="{{ route('properties.tenants', $property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $property->created_at->format('d/m/Y h:i A') }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Checklists</p>
                                    <p class="text-sm text-gray-900">
                                        <a href="{{ route('properties.checklists', $property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $property->updated_at->format('d/m/Y h:i A') }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                        <div class="flex justify-end gap-x-4">
                            <a href="{{ route('properties.index') }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('properties.edit', $property) }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Property
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>