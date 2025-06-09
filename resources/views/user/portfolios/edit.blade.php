<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Portfolio') }}
            </h2>
            <a href="{{ route('portfolios-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('portfolios-info.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="portfolio_types_id" class="block text-sm font-medium text-gray-700">Portfolio Type</label>
                        <select id="portfolio_types_id" name="portfolio_types_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select Portfolio Type</option>
                            @foreach ($portfolioTypes as $type)
                                <option value="{{ $type->id }}" {{ (old('portfolio_types_id') ?? $portfolio->portfolio_types_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('portfolio_types_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="portfolio_name" class="block text-sm font-medium text-gray-700">Portfolio Name</label>
                        <input id="portfolio_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="portfolio_name" value="{{ old('portfolio_name', $portfolio->portfolio_name) }}" required autofocus>
                        @error('portfolio_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="annual_report" class="block text-sm font-medium text-gray-700">Annual Report</label>
                        <input id="annual_report" type="file" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="annual_report">
                        @if ($portfolio->annual_report)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Current file: 
                                    <a href="{{ Storage::url($portfolio->annual_report) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                        View Attachment
                                    </a>
                                </p>
                            </div>
                        @endif
                        @error('annual_report')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Accepted file types: PDF, DOC, DOCX. Max size: 10MB.</p>
                    </div>

                    <div class="mb-4">
                        <label for="trust_deed_document" class="block text-sm font-medium text-gray-700">Trust Deed Document</label>
                        <input id="trust_deed_document" type="file" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="trust_deed_document">
                        @if ($portfolio->trust_deed_document)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Current file: 
                                    <a href="{{ Storage::url($portfolio->trust_deed_document) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                        View Attachment
                                    </a>
                                </p>
                            </div>
                        @endif
                        @error('trust_deed_document')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Accepted file types: PDF, DOC, DOCX. Max size: 10MB.</p>
                    </div>

                    <div class="mb-4">
                        <label for="insurance_document" class="block text-sm font-medium text-gray-700">Insurance Document</label>
                        <input id="insurance_document" type="file" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="insurance_document">
                        @if ($portfolio->insurance_document)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Current file: 
                                    <a href="{{ Storage::url($portfolio->insurance_document) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                        View Attachment
                                    </a>
                                </p>
                            </div>
                        @endif
                        @error('insurance_document')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Accepted file types: PDF, DOC, DOCX. Max size: 10MB.</p>
                    </div>

                    <div class="mb-4">
                        <label for="valuation_report" class="block text-sm font-medium text-gray-700">Valuation Report</label>
                        <input id="valuation_report" type="file" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="valuation_report">
                        @if ($portfolio->valuation_report)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Current file: 
                                    <a href="{{ Storage::url($portfolio->valuation_report) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                        View Attachment
                                    </a>
                                </p>
                            </div>
                        @endif
                        @error('valuation_report')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Accepted file types: PDF, DOC, DOCX. Max size: 10MB.</p>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="active" {{ old('status', $portfolio->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $portfolio->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('portfolios-info.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>