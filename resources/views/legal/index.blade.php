<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Legal Dashboard') }}
        </h2>
    </x-slot>

    @if(Auth::user()->hasPermission('LEGAL'))
    <div class="hidden py-12 dashboard-section" id="legal-section" data-section="legal">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Legal Information</p>
        </div>
    </div>
    @endif

    @if(Auth::user()->hasPermission('REITS'))
    <div class="hidden py-12 dashboard-section" id="reits-section" data-section="reits">
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

            <!-- Header -->
            <div class="pb-6">
                <h2 class="text-xl font-bold leading-tight text-gray-800">
                    {{ __('Real Estate Investment Trusts (REITs)') }}
                </h2>
            </div>

            <!-- Checklists List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Checklists List</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="hidden bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET" action="{{ route('checklists.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Field -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    placeholder="Search by property, tenant...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                                <option value="verified" @selected(request('status') === 'verified')>Verified</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Apply Filters
                            </button>

                            @if(request('search') || request('status'))
                                <a href="{{ route('checklists.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Checklists Table -->
                <div class="overflow-x-auto border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant Info</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Legal Documents</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($checklists as $checklist)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $checklist->property_title }}</div>
                                        <div class="text-xs text-gray-500">{{ $checklist->property_location ?? 'No location' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $checklist->tenant_name ?? 'N/A' }}</div>
                                        @if($checklist->tenancy_commencement_date && $checklist->tenancy_expiry_date)
                                        <div class="text-xs text-gray-500">
                                            {{ date('d/m/Y', strtotime($checklist->tenancy_commencement_date)) }} to {{ date('d/m/Y', strtotime($checklist->tenancy_expiry_date)) }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            @if($checklist->title_ref)
                                                <span class="mr-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Title</span>
                                            @endif
                                            @if($checklist->lease_agreement_ref)
                                                <span class="mr-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Lease</span>
                                            @endif
                                            @if($checklist->maintenance_agreement_ref)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Maintenance</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ match(strtolower($checklist->status)) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'scheduled' => 'bg-blue-100 text-blue-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'active' => 'bg-green-100 text-green-800',
                                                'inactive' => 'bg-gray-100 text-gray-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'draft' => 'bg-blue-100 text-blue-800',
                                                'withdrawn' => 'bg-purple-100 text-purple-800',
                                                'in progress' => 'bg-indigo-100 text-indigo-800',
                                                'on hold' => 'bg-orange-100 text-orange-800',
                                                'reviewing' => 'bg-teal-100 text-teal-800',
                                                'approved' => 'bg-emerald-100 text-emerald-800',
                                                'expired' => 'bg-rose-100 text-rose-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                            {{ ucfirst($checklist->status) }}
                                        </span>
                                        @if($checklist->approval_datetime)
                                            <div class="text-xs text-gray-500 mt-1">
                                                Approved: {{ date('d M Y', strtotime($checklist->approval_datetime)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('checklist-l.edit', $checklist) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('checklist-l.show', $checklist) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">No checklists found {{ request('search') ? 'matching your search' : '' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $checklists->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- JavaScript for handling section display -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the section parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get('section');
            
            // Initially hide the default message (will show it if no valid section is found)
            const defaultMessage = document.getElementById('default-message');
            
            // Select all section elements
            const sections = document.querySelectorAll('.dashboard-section');
            
            // If a section parameter is present
            if (section) {
                // Find the target section
                const targetSection = document.querySelector(`[data-section="${section}"]`);
                
                if (targetSection) {
                    // Hide default message
                    if (defaultMessage) {
                        defaultMessage.classList.add('hidden');
                    }
                    
                    // Show only the target section
                    targetSection.classList.remove('hidden');
                } else {
                    // If no valid section was found, show the default message
                    if (defaultMessage) {
                        defaultMessage.classList.remove('hidden');
                    }
                }
            } else {
                // If no section parameter, show the default message
                if (defaultMessage) {
                    defaultMessage.classList.remove('hidden');
                }
            }
        });
    </script>
</x-app-layout>
