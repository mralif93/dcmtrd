<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolio Management') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('properties-info.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Add New Property
                </a>
                <a href="{{ route('financials.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Add Financial Record
                </a>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
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
            <!-- Portfolio Summary Card -->
            @if(isset($portfolio) && $portfolio->exists)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $portfolio->portfolio_name }}</h3>
                        <p class="text-gray-600">{{ $portfolio->portfolioType->name ?? 'N/A' }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $portfolio->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($portfolio->status) }}
                    </span>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Properties</h4>
                        <p class="text-2xl font-bold text-gray-800">{{ $portfolio->properties->count() }}</p>
                        <p class="text-sm text-gray-600 mt-1">Total Market Value: RM{{ number_format($portfolio->properties->sum('market_value'), 2) }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Financials</h4>
                        <p class="text-2xl font-bold text-gray-800">{{ $portfolio->financials->count() }}</p>
                        <p class="text-sm text-gray-600 mt-1">Total Outstanding: RM{{ number_format($portfolio->financials->sum('outstanding_amount'), 2) }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Documents</h4>
                        <div class="flex flex-col space-y-2">
                            @if($portfolio->annual_report)
                                <a href="{{ asset('storage/' . $portfolio->annual_report) }}" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Annual Report
                                </a>
                            @endif
                            @if($portfolio->trust_deed_document)
                                <a href="{{ asset('storage/' . $portfolio->trust_deed_document) }}" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Trust Deed
                                </a>
                            @endif
                            @if($portfolio->valuation_report)
                                <a href="{{ asset('storage/' . $portfolio->valuation_report) }}" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Valuation Report
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- Properties Section -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Properties
                </h3>
                
                <!-- Filter Controls -->
                <div class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4">
                    <form action="{{ route('properties-info.index') }}" method="GET" class="flex flex-col md:flex-row md:items-end md:space-x-2 col-span-full">
                        @if(isset($portfolio) && $portfolio->exists)
                            <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
                        @else
                        <div class="w-full">
                            <label for="portfolio_id" class="block text-sm font-medium text-gray-700 mb-1">Portfolio</label>
                            <select id="portfolio_id" name="portfolio_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Portfolios</option>
                                @foreach($portfolios as $portfolioOption)
                                    <option value="{{ $portfolioOption->id }}" {{ request('portfolio_id') == $portfolioOption->id ? 'selected' : '' }}>
                                        {{ $portfolioOption->portfolio_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div class="w-full">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select id="category" name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="w-full">
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <select id="city" name="city" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="w-full">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search properties..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div class="flex items-end space-x-2 pt-4 md:pt-0">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Filter
                            </button>
                            <a href="{{ route('properties-info.index', isset($portfolio) && $portfolio->exists ? ['portfolio_id' => $portfolio->id] : []) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
                <div class="overflow-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Location</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Info</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Value</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($properties as $property)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $property->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $property->category }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $property->city }}, {{ $property->state }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $property->country }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ $property->tenants->where('status', 'active')->count() }} Tenants
                                            </div>
                                            <div class="flex items-center text-gray-500 mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $property->siteVisits->where('status', 'scheduled')->count() }} Pending Visits
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">
                                                RM{{ number_format($property->market_value, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ number_format($property->land_size, 2) }} sqm
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('properties-info.show', $property->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('properties-info.edit', $property->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Property">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('properties-info.destroy', $property->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete Property" onclick="return confirm('Are you sure you want to delete this property?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No properties found {{ request('search') || request('batch_no') || request('category') || request('city') || request('portfolio_id') || request('status') ? 'matching your filters' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $properties->links() }}
                </div>
                
                <!-- Results count -->
                <div class="mt-2 text-sm text-gray-500">
                    Showing {{ $properties->firstItem() ?? 0 }} to {{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} properties
                </div>
            </div>

            <!-- Financials Section (Only show if portfolio is selected) -->
            @if(isset($portfolio) && $portfolio->exists)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Financial Records
                </h3>
                
                <div class="overflow-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bank</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Purpose</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Amounts</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Rate</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($portfolio->financials as $financial)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $financial->bank->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $financial->financialType->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $financial->purpose }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $financial->tenure }} ({{ $financial->profit_type }})
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">
                                                RM{{ number_format($financial->total_facility_amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Outstanding: RM{{ number_format($financial->outstanding_amount, 2) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $financial->profit_rate }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('financials.show', $financial->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('financials.edit', $financial->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Financial">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No financial records found for this portfolio
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Upcoming Site Visits Section -->
            @if(isset($portfolio) && $portfolio->exists)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Upcoming Site Visits
                </h3>
                
                <div class="overflow-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Property</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Inspector</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $upcomingVisits = collect();
                                foreach($portfolio->properties as $propertyItem) {
                                    $propertyVisits = $propertyItem->siteVisits()
                                        ->where('status', 'scheduled')
                                        ->where('date_visit', '>=', now())
                                        ->orderBy('date_visit', 'asc')
                                        ->get();
                                    $upcomingVisits = $upcomingVisits->concat($propertyVisits);
                                }
                                $upcomingVisits = $upcomingVisits->sortBy('date_visit')->take(5);
                            @endphp
                            
                            @forelse ($upcomingVisits as $visit)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $visit->property->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $visit->property->city }}, {{ $visit->property->state }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $visit->date_visit->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $visit->getFormattedTimeAttribute() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $visit->inspector_name ?: 'Not assigned' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $visit->getStatusBadgeClassAttribute() }}">
                                            {{ ucfirst($visit->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('site-visits.show', $visit->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('site-visits.edit', $visit->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Visit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No upcoming site visits scheduled
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 text-right">
                    <a href="{{ route('site-visits.index', ['portfolio_id' => $portfolio->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200">
                        View All Site Visits
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            <!-- Expiring Leases Section -->
            @if(isset($portfolio) && $portfolio->exists)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6M9 20h12a2 2 0 002-2V6a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Expiring Leases (Next 90 Days)
                </h3>
                
                <div class="overflow-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tenant</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Property</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Lease Details</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Expiry</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $expiringLeases = collect();
                                $nearExpiryDate = now()->addDays(90);
                                
                                foreach($portfolio->properties as $propertyItem) {
                                    foreach($propertyItem->tenants as $tenant) {
                                        $tenantLeases = $tenant->leases()
                                            ->where('status', 'active')
                                            ->where('end_date', '<=', $nearExpiryDate)
                                            ->where('end_date', '>=', now())
                                            ->orderBy('end_date', 'asc')
                                            ->get();
                                        $expiringLeases = $expiringLeases->concat($tenantLeases);
                                    }
                                }
                                $expiringLeases = $expiringLeases->sortBy('end_date')->take(5);
                            @endphp
                            
                            @forelse ($expiringLeases as $lease)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $lease->tenant->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $lease->tenant->contact_person }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $lease->tenant->property->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $lease->demised_premises }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="text-gray-900">{{ $lease->lease_name }}</div>
                                            <div class="text-xs text-gray-500">
                                                RM{{ number_format($lease->rental_amount, 2) }} / {{ $lease->rental_frequency }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $lease->end_date->format('d M Y') }}
                                        </div>
                                        <div class="text-xs font-semibold {{ $lease->end_date->diffInDays(now()) < 30 ? 'text-red-600' : 'text-yellow-600' }}">
                                            {{ $lease->end_date->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('leases.show', $lease->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('leases.renew', $lease->id) }}" class="text-green-600 hover:text-green-900" title="Renew Lease">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No leases expiring in the next 90 days
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 text-right">
                    <a href="{{ route('leases.index', ['portfolio_id' => $portfolio->id, 'expiring' => 'soon']) }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200">
                        View All Leases
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>