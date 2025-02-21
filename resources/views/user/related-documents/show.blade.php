<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document Details') }}
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Core Information</h3>
                </div>

                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Document Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $document->document_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Document Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $document->document_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Related Facility</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $document->facility->facility_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Upload Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $document->upload_date->format('d/m/Y') }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">File</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ Storage::url($document->file_path) }}" class="text-indigo-600 hover:underline">Download Document</a>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('related-documents-info.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('related-documents-info.edit', $document) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Document
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>