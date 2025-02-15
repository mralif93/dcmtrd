<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Announcement Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">Details for the announcement titled "{{ $announcement->title }}"</p>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Core Information</h3>
                </div>

                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Issuer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $announcement->issuer->issuer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Announcement Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $announcement->announcement_date->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900 ">{{ $announcement->category }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Sub Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $announcement->sub_category ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Source</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $announcement->source }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Description</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $announcement->description }}</p>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Content</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $announcement->content }}</p>
                </div>

                @if($announcement->attachment)
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900">Attachment</h3>
                        <a href="{{ Storage::url($announcement->attachment) }}" class="text-blue-600 underline" target="_blank">Download Attachment</a>
                    </div>
                @endif

                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('announcements.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Back to List
                        </a>
                        <a href="{{ route('announcements.edit', $announcement) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit Announcement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>