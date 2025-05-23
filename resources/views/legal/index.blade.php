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
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET" action="{{ route('legal.dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Field -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search Property</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    placeholder="Search by property name or city...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Submit and Reset Buttons -->
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search
                            </button>
                            
                            @if(request('search') || request('status'))
                                <a href="{{ route('legal.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Site Visit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prepared By</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($checklists as $checklist)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $checklist->siteVisit->property->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $checklist->siteVisit->property->address ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($checklist->siteVisit)
                                            <div class="text-sm text-gray-900">
                                                <span class="font-medium">Date:</span> {{ $checklist->siteVisit->date_visit ? date('d M Y', strtotime($checklist->siteVisit->date_visit)) : 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <span class="font-medium">Time:</span> {{ $checklist->siteVisit->time_visit ? date('h:i A', strtotime($checklist->siteVisit->time_visit)) : 'N/A' }}
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">No visit scheduled</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($checklist->legalDocumentation && $checklist->legalDocumentation->status)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ match(strtolower($checklist->legalDocumentation->status)) {
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                    'inactive' => 'bg-gray-100 text-gray-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                } }}">
                                                {{ ucfirst($checklist->legalDocumentation->status) }}
                                            </span>
                                            @if($checklist->legalDocumentation->approval_datetime)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Approved: {{ date('d M Y', strtotime($checklist->legalDocumentation->approval_datetime)) }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Not Started
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($checklist->legalDocumentation && $checklist->legalDocumentation->prepared_by)
                                            <div class="text-sm text-gray-900">{{ $checklist->legalDocumentation->prepared_by ?? 'Not assigned' }}</div>
                                        @else
                                            <div class="text-sm text-gray-900">Not assigned</div>
                                        @endif
                                        @if($checklist->legalDocumentation && $checklist->legalDocumentation->verified_by)
                                            <div class="text-xs text-gray-500">Verified by: {{ $checklist->legalDocumentation->verified_by }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            @if($checklist->legalDocumentation)
                                                <a href="{{ route('checklist-legal-l.edit', $checklist->legalDocumentation->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('checklist-legal-l.show', $checklist->legalDocumentation->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="text-gray-400 cursor-not-allowed">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </span>
                                                <span class="text-gray-400 cursor-not-allowed">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5
                                                        .586-8.586z" />
                                                    </svg>
                                                </span>
                                            @endif
                                            
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
                // If no section parameter, show REITS section by default if user has permission
                const reitsSection = document.getElementById('reits-section');
                if (reitsSection) {
                    reitsSection.classList.remove('hidden');
                    if (defaultMessage) {
                        defaultMessage.classList.add('hidden');
                    }
                } else if (defaultMessage) {
                    defaultMessage.classList.remove('hidden');
                }
            }
        });
    </script>
</x-app-layout>
