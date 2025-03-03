<!-- resources/views/portfolios/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portfolio Details') }}
        </h2>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $portfolio->portfolio_name }}</h3>
                        <div class="space-x-2">
                            <a href="{{ route('portfolios.edit', $portfolio->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Edit
                            </a>
                            <a href="{{ route('portfolios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Portfolio Information</h4>
                        <div class="border rounded-md overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Portfolio ID</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Portfolio Name</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->portfolio_name }}</p>
                                </div>
                            </div>
                            <div class="bg-white px-4 py-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Created At</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Last Updated</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->updated_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Documents</h4>
                        <div class="border rounded-md overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Annual Report</p>
                                    @if($portfolio->annual_report)
                                        <a href="{{ Storage::url($portfolio->annual_report) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                            View Document
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400">No document uploaded</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Trust Deed Document</p>
                                    @if($portfolio->trust_deed_document)
                                        <a href="{{ Storage::url($portfolio->trust_deed_document) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                            View Document
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400">No document uploaded</p>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-white px-4 py-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Insurance Document</p>
                                    @if($portfolio->insurance_document)
                                        <a href="{{ Storage::url($portfolio->insurance_document) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                            View Document
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400">No document uploaded</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Valuation Report</p>
                                    @if($portfolio->valuation_report)
                                        <a href="{{ Storage::url($portfolio->valuation_report) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                            View Document
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400">No document uploaded</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Associated Records</h4>
                        <div class="border rounded-md overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Properties</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->properties->count() }} properties</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Portfolio Types</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->portfolioTypes->count() }} types</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Financials</p>
                                    <p class="text-sm text-gray-900">{{ $portfolio->financials->count() }} financial records</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Delete Portfolio
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>