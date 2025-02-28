
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($trashed) && $trashed ? 'Deleted Compliance Covenants' : 'Compliance Covenants' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-end mb-4">
                        @if(isset($trashed) && $trashed)
                            <a href="{{ route('compliance-covenants.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2">Back to Active</a>
                        @else
                            <a href="{{ route('compliance-covenants.trashed') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2">View Deleted</a>
                            <a href="{{ route('compliance-covenants.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Add New</a>
                        @endif
                    </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search Form -->
                    <form action="{{ route('compliance-covenants.index') }}" method="GET" class="mb-6">
                        <div class="flex flex-wrap -mx-2">
                            <div class="px-2 w-full md:w-1/3 mb-4">
                                <label for="issuer_short_name" class="block text-sm font-medium text-gray-700 mb-1">Issuer</label>
                                <input type="text" name="issuer_short_name" id="issuer_short_name" placeholder="Search by issuer name" 
                                    value="{{ request('issuer_short_name') }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="px-2 w-full md:w-1/3 mb-4">
                                <label for="financial_year_end" class="block text-sm font-medium text-gray-700 mb-1">Financial Year</label>
                                <input type="text" name="financial_year_end" id="financial_year_end" placeholder="e.g. 2024" 
                                    value="{{ request('financial_year_end') }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="px-2 w-full md:w-1/3 mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">All</option>
                                    <option value="compliant" {{ request('status') == 'compliant' ? 'selected' : '' }}>Compliant</option>
                                    <option value="non_compliant" {{ request('status') == 'non_compliant' ? 'selected' : '' }}>Non-Compliant</option>
                                </select>
                            </div>
                            <div class="px-2 w-full flex justify-end mb-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Search</button>
                                @if(request('issuer_short_name') || request('financial_year_end') || request('status'))
                                    <a href="{{ route('compliance-covenants.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">Clear</a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- Data Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issuer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Financial Year End</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Audited FS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unaudited FS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($covenants as $covenant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $covenant->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $covenant->issuer_short_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $covenant->financial_year_end }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($covenant->audited_financial_statements)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($covenant->unaudited_financial_statements)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($covenant->isCompliant())
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Compliant
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Incomplete
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                @if(isset($trashed) && $trashed)
                                                    <form action="{{ route('compliance-covenants.restore', $covenant->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restore</button>
                                                    </form>
                                                    <form action="{{ route('compliance-covenants.force-delete', $covenant->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to permanently delete this covenant?')">
                                                            Permanently Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('compliance-covenants.show', $covenant) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                    <a href="{{ route('compliance-covenants.edit', $covenant) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <form action="{{ route('compliance-covenants.destroy', $covenant) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this covenant?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No compliance covenants found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $covenants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>