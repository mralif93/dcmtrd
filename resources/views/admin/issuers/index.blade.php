<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Issuers List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4">
                    <div class="bg-green-500 text-white p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <!-- Header with Search and Create Button -->
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
                    <!-- Search Form -->
                    <form class="w-full sm:w-1/2" method="GET">
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Search by short name or issuer name...">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors !important">
                                    Search
                                </button>
                        </div>
                    </form>

                    <!-- Create Button (Right-aligned) -->
                    <div class="flex justify-end sm:justify-start">
                        <a href="{{ route('issuers.create') }}" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors !important flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            New Issuer
                        </a>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Short Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Issuer Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Registration No.</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($issuers as $issuer)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $issuer->issuer_short_name }}</td>
                                    <td class="px-6 py-4">{{ $issuer->issuer_name }}</td>
                                    <td class="px-6 py-4">{{ $issuer->registration_number }}</td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('issuers.show', $issuer) }}" 
                                        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('issuers.edit', $issuer) }}" 
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('issuers.destroy', $issuer) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors"
                                                    onclick="return confirm('Are you sure you want to delete this issuer?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No issuers found {{ request('search') ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (Tailwind-styled) -->
                <div class="mt-6">
                    {{ $issuers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>