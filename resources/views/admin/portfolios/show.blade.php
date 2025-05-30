<!-- resources/views/portfolios/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolio Details') }}
            </h2>
            <a href="{{ route('portfolios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Portfolio Information</h3>
                </div>

                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $portfolio->portfolio_name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Portfolio Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->portfolioType ? $portfolio->portfolioType->name : 'Not assigned' }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm">
                                @if($portfolio->status == 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($portfolio->status == 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($portfolio->status == 'reject')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @elseif($portfolio->status == 'inactive')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $portfolio->status }}
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->prepared_by ?: 'Not specified' }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->verified_by ?: 'Not verified' }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Approval Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->approval_datetime ? date('M j, Y h:i A', strtotime($portfolio->approval_datetime)) : 'Not approved yet' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                
                @if($portfolio->remarks)
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Remarks</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $portfolio->remarks }}</p>
                    </div>
                </div>
                @endif

                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documents</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Annual Report</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($portfolio->annual_report)
                                    <a href="{{ Storage::url($portfolio->annual_report) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                        View Document
                                    </a>
                                @else
                                    <p class="text-sm text-gray-400">No document uploaded</p>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Trust Deed Document</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($portfolio->trust_deed_document)
                                    <a href="{{ Storage::url($portfolio->trust_deed_document) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                        View Document
                                    </a>
                                @else
                                    <p class="text-sm text-gray-400">No document uploaded</p>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Insurance Document</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($portfolio->insurance_document)
                                    <a href="{{ Storage::url($portfolio->insurance_document) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                        View Document
                                    </a>
                                @else
                                    <p class="text-sm text-gray-400">No document uploaded</p>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Valuation Report</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($portfolio->valuation_report)
                                    <a href="{{ Storage::url($portfolio->valuation_report) }}" target="_blank" class="inline-flex items-center mt-1 px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 hover:bg-indigo-200">
                                        View Document
                                    </a>
                                @else
                                    <p class="text-sm text-gray-400">No document uploaded</p>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Records</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Properties</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <p class="text-sm text-gray-900">{{ $portfolio->properties->count() }} properties</p>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Financials</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                            <p class="text-sm text-gray-900">{{ $portfolio->financials->count() }} financial records</p>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->created_at->format('M j, Y h:i A') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->updated_at->format('M j, Y h:i A') }}
                            </dd>
                        </div>
                        @if($portfolio->deleted_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Deleted At</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $portfolio->deleted_at->format('M j, Y h:i A') }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('portfolios.index') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('portfolios.edit', $portfolio) }}" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Portfolio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>