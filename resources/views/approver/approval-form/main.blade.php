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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Approval Forms</h3>
                    <a href="{{ route('approval-form-a.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New Approval Form
                    </a>
                </div>

                <!-- Status Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex px-6 space-x-6">
                        <a href="{{ route('approval-form-a.main', ['tab' => 'all'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            All Forms
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['all'] }}</span>
                        </a>
                        <a href="{{ route('approval-form-a.main', ['tab' => 'pending'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Pending
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['pending'] }}</span>
                        </a>
                        <a href="{{ route('approval-form-a.main', ['tab' => 'active'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'active' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Active
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['active'] }}</span>
                        </a>
                        <a href="{{ route('approval-form-a.main', ['tab' => 'rejected'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'rejected' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Rejected
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['rejected'] }}</span>
                        </a>
                        <a href="{{ route('approval-form-a.main', ['tab' => 'inactive'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'inactive' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Inactive
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['inactive'] }}</span>
                        </a>
                    </nav>
                </div>

                <!-- Search and filter options -->
                <div class="px-4 py-3 bg-gray-50 sm:px-6">
                    <form action="{{ route('approval-form-a.main') }}" method="GET" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        
                        <!-- 1. Received Date -->
                        <div>
                            <label for="received_date" class="block text-sm font-medium text-gray-700">Received Date</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="date" name="received_date" id="received_date" value="{{ request('received_date') }}" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- 2. Send Date -->
                        <div>
                            <label for="send_date" class="block text-sm font-medium text-gray-700">Send Date</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="date" name="send_date" id="send_date" value="{{ request('send_date') }}" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- 3. Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category" name="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Filter Buttons -->
                        @if($activeTab == 'all')
                        <div class="flex items-end space-x-3 md:col-span-4">
                        @else
                        <div class="flex items-end space-x-3">
                        @endif
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filter Results
                            </button>
                            <a href="{{ route('approval-form-a.main', ['tab' => $activeTab]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Approval Forms Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category / Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Send Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($approvalForms as $form)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $form->received_date->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        #{{ $form->id }} {{ $form->portfolio->portfolio_name ?? '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
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
                                    <div class="text-sm text-gray-900">
                                        {{ $form->send_date->format('d M Y') }}
                                    </div>
                                    @else
                                    <div class="text-sm text-gray-500 italic">
                                        Not sent yet
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($form->status)) {
                                            'approved' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
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
                                        @if($form->attachment)
                                        <a href="{{ asset('storage/' . $form->attachment) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900" title="View Attachment">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        @endif
                                        
                                        <a href="{{ route('approval-form-a.details', $form) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('approval-form-a.edit', $form) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit Approval Form">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($approvalForms->count() === 0)
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No approval forms found.</div>
                                </td>
                            </tr>
                            @endif
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

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Approval Form</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Please provide a reason for rejecting this approval form.</p>
                        </div>
                    </div>
                </div>
                
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <div class="mt-4">
                        <label for="remarks" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                        <textarea id="remarks" name="remarks" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Reject
                        </button>
                        <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add any JavaScript functionality needed for filtering or dynamic behavior
        });
        
        function openRejectModal(formId) {
            document.getElementById('rejectForm').action = `/approver/approval-form/${formId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
