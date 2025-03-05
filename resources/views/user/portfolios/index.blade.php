<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolios List') }}
            </h2>
            <a href="{{ route('portfolios-info.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Add New Portfolio
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

            <div class="bg-white shadow rounded-lg p-6">
                <div class="border rounded-lg overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Annual Report</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Trust Deed Document</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Insurance Document</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Valuation Report</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($portfolios as $portfolio)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $portfolio->portfolio_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($portfolio->annual_report)
                                            <a href="{{ Storage::url($portfolio->annual_report) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                                Download
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-400">-</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($portfolio->trust_deed_document)
                                            <a href="{{ Storage::url($portfolio->trust_deed_document) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                                Download
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-400">-</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($portfolio->insurance_document)
                                            <a href="{{ Storage::url($portfolio->insurance_document) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                                Download
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-400">-</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($portfolio->valuation_report)
                                            <a href="{{ Storage::url($portfolio->valuation_report) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                                Download
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-400">-</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span>
                                            {{ $portfolio->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('portfolios-info.show', $portfolio->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('portfolios-info.edit', $portfolio->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('portfolios-info.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
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
                                    <td>
                                        No portfolio found {{ request('search') ? 'matching your search' : '' }}!!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>