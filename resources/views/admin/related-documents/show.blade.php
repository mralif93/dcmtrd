<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">Details for "{{ $document->document_name }}"</p>
            </div>

            @if(session('success'))
                <div class="mb-4">
                    <div class="bg-green-500 text-white p-4 rounded-lg">
                        {{ session('success') }}
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
                        <a href="{{ route('related-documents.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Back to List
                        </a>
                        <a href="{{ route('related-documents.edit', $document) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit Document
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>