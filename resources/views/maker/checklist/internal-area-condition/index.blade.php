<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Internal Area Conditions List') }}
            </h2>
            <a href="{{ route('checklist-internal-area-conditions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add New Condition
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
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

            <div class="bg-white shadow rounded-lg p-6 mb-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Search & Filters
                </h3>

                <form method="GET" action="{{ route('checklist-internal-area-conditions.index') }}">
                    <div class="space-y-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}" 
                                placeholder="Search by ID, prepared by, verified by..." 
                                class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                            />
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <select 
                                    name="status" 
                                    class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition duration-150 ease-in-out"
                                >
                                    <option value="all" {{ ($status ?? '') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                    <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="verified" {{ ($status ?? '') == 'verified' ? 'selected' : '' }}>Verified</option>
                                    <option value="approved" {{ ($status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ ($status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <input 
                                    type="date" 
                                    name="date" 
                                    value="{{ $date ?? '' }}" 
                                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                                />
                            </div>
                            
                            <div class="relative">
                                <select 
                                    name="condition_type" 
                                    class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition duration-150 ease-in-out"
                                >
                                    <option value="">All Condition Types</option>
                                    <option value="door_window" {{ ($condition_type ?? '') === 'door_window' ? 'selected' : '' }}>Door/Window</option>
                                    <option value="staircase" {{ ($condition_type ?? '') === 'staircase' ? 'selected' : '' }}>Staircase</option>
                                    <option value="toilet" {{ ($condition_type ?? '') === 'toilet' ? 'selected' : '' }}>Toilet</option>
                                    <option value="ceiling" {{ ($condition_type ?? '') === 'ceiling' ? 'selected' : '' }}>Ceiling</option>
                                    <option value="wall" {{ ($condition_type ?? '') === 'wall' ? 'selected' : '' }}>Wall</option>
                                    <option value="water_seeping" {{ ($condition_type ?? '') === 'water_seeping' ? 'selected' : '' }}>Water Seeping</option>
                                    <option value="loading_bay" {{ ($condition_type ?? '') === 'loading_bay' ? 'selected' : '' }}>Loading Bay</option>
                                    <option value="basement_car_park" {{ ($condition_type ?? '') === 'basement_car_park' ? 'selected' : '' }}>Basement/Car Park</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex justify-end items-center pt-2 space-x-3">
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Apply Filters
                            </button>
                            
                            @if(isset($search) || isset($status) && $status != 'all' || isset($date) && $date != '' || isset($condition_type) && $condition_type != '')
                                <a 
                                    href="{{ route('checklist-internal-area-conditions.index') }}" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Internal Area Conditions List
                </h3>
                <div class="overflow-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Checklist ID</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Prepared By</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Verified By</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Created At</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($internalAreaConditions as $condition)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $condition->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $condition->checklist_id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $condition->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $condition->status == 'verified' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $condition->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $condition->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($condition->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $condition->prepared_by }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $condition->verified_by ?? 'Not verified' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $condition->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('checklist-internal-area-conditions.show', $condition) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('checklist-internal-area-conditions.edit', $condition) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">No internal area conditions found {{ request('search') ? 'matching your search' : '' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if(isset($internalAreaConditions) && method_exists($internalAreaConditions, 'links'))
                <div class="mt-4">
                    {{ $internalAreaConditions->links() }}
                </div>
                
                <!-- Results count -->
                <div class="mt-2 text-sm text-gray-500">
                    Showing {{ $internalAreaConditions->firstItem() ?? 0 }} to {{ $internalAreaConditions->lastItem() ?? 0 }} of {{ $internalAreaConditions->total() }} internal area conditions
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>