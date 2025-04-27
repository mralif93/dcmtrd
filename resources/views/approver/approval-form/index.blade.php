<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Approval Forms') }}
            </h2>
            <a href="{{ route('approver.dashboard', ['section' => 'reits']) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
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

            <!-- Portfolio Summary Card (if applicable) -->
            @if(isset($portfolio) && $portfolio->exists)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">{{ $portfolio->portfolio_name }}</h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $portfolio->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($portfolio->status) }}
                    </span>
                </div>
                
                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Properties</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ $portfolio->properties->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Approval Forms: {{ $portfolio->approvalForms->count() }}</p>
                        </div>
                        
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Status</h4>
                            <div class="flex flex-col space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Pending</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $portfolio->approvalForms->where('status', 'pending')->count() }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Approved</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $portfolio->approvalForms->where('status', 'approved')->count() }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Rejected</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $portfolio->approvalForms->where('status', 'rejected')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Recent Activity</h4>
                            <div class="flex flex-col space-y-2">
                                @forelse($portfolio->approvalForms->sortByDesc('updated_at')->take(3) as $recentForm)
                                    <div class="text-sm text-gray-600">
                                        <span class="text-indigo-600">{{ $recentForm->category }}</span> - 
                                        {{ \Carbon\Carbon::parse($recentForm->updated_at)->diffForHumans() }}
                                    </div>
                                @empty
                                    <div class="text-sm text-gray-600">No recent activity</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Approval Forms Section -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Approval Forms</h3>
                </div>
                
                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form action="{{ route('approval-form-a.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @if(isset($portfolio) && $portfolio->exists)
                            <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
                        @endif
                        
                        <!-- 1. Received Date -->
                        <div>
                            <label for="received_date" class="block text-sm font-medium text-gray-700">Received Date</label>
                            <input type="date" name="received_date" id="received_date" value="{{ request('received_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                        </div>
                        
                        <!-- 2. Send Date -->
                        <div>
                            <label for="send_date" class="block text-sm font-medium text-gray-700">Send Date</label>
                            <input type="date" name="send_date" id="send_date" value="{{ request('send_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                        </div>
                        
                        <!-- 3. Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- 4. Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end space-x-2 md:col-span-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('approval-form-a.index', isset($portfolio) && $portfolio->exists ? ['portfolio_id' => $portfolio->id] : []) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Approval Forms Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border-t border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category / Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Send Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($approvalForms as $form)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">
                                            {{ $form->received_date->format('d M Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            #{{ $form->id }} {{ $form->portfolio->portfolio_name ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">
                                            {{ $form->category }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ Str::limit($form->details, 100) }}
                                        </div>
                                        @if($form->property)
                                        <div class="text-xs text-gray-500 mt-1">
                                            Property: {{ $form->property->name }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($form->send_date)
                                        <div class="font-medium text-gray-900">
                                            {{ $form->send_date->format('d M Y') }}
                                        </div>
                                        @else
                                        <div class="text-sm text-gray-500 italic">
                                            Not sent yet
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $form->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($form->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                                'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($form->status) }}
                                        </span>
                                        @if($form->approval_datetime && $form->status !== 'pending')
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $form->approval_datetime->format('d M Y') }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('approval-form-a.details', $form) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if($form->attachment)
                                            <a href="{{ asset('storage/' . $form->attachment) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900" title="View Attachment">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No approval forms found {{ request('search') || request('category') || request('portfolio_id') || request('status') ? 'matching your filters' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $approvalForms->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>