<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Issuers List') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('issuers.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-300">
                    Create Issuer
                </a>
                <a href="{{ route('issuers.create') }}" class="px-4 py-2 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-green-300">
                    Upload Issuers
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6 bg-white rounded-lg shadow">
                <!-- Header with Search and Create Button -->
                <div class="flex flex-col justify-between gap-4 mb-6 sm:flex-row">
                    <!-- Search Form -->
                    <form class="w-full sm:w-1/2" method="GET">
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Search by short name or issuer name...">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors !important">
                                    Search
                                </button>
                        </div>
                    </form>
                </div>

                <!-- Table Container -->
                <div class="overflow-hidden border rounded-lg">
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
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $issuer->issuer_short_name }}</td>
                                    <td class="px-6 py-4">{{ $issuer->issuer_name }}</td>
                                    <td class="px-6 py-4">{{ $issuer->registration_number }}</td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('issuers.show', $issuer) }}" 
                                        class="px-3 py-1 text-blue-800 transition-colors bg-blue-100 rounded-md hover:bg-blue-200">
                                            View
                                        </a>
                                        <a href="{{ route('issuers.edit', $issuer) }}" 
                                        class="px-3 py-1 text-green-800 transition-colors bg-green-100 rounded-md hover:bg-green-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('issuers.destroy', $issuer) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 text-red-800 transition-colors bg-red-100 rounded-md hover:bg-red-200"
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