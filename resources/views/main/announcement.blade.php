<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Announcement Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 pb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="space-y-4">
                    <!-- Title Section -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-4 pb-6">{{ $announcement->title }}</h1>
                    
                    <!-- Metadata Section -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold w-1/3">ANNOUNCEMENT DATE:</span>
                            <span class="w-2/3">{{ $announcement->announcement_date->format('d-M-Y') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold w-1/3">CATEGORY:</span>
                            <span class="w-2/3">{{ $announcement->category }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold w-1/3">SUB-CATEGORY:</span>
                            <span class="w-2/3">{{ $announcement->sub_category }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold w-1/3">ISSUER NAME:</span>
                            <span class="w-2/3">{{ $announcement->issuer->issuer_name }}</span>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="pt-4">
                        <h3 class="font-semibold mb-2">DESCRIPTION:</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $announcement->description }}</p>
                    </div>

                    <!-- Content Section -->
                    <div class="pt-4">
                        <h3 class="font-semibold mb-2">CONTENT:</h3>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $announcement->content }}</div>
                    </div>

                    <!-- Attachment Section -->
                    @if($announcement->attachment)
                    <div class="pt-4">
                        <h3 class="font-semibold mb-2">ATTACHMENT:</h3>
                        <a href="{{ asset('storage/' . $announcement->attachment) }}" 
                           class="text-blue-600 hover:text-blue-800"
                           target="_blank">
                            {{ basename($announcement->attachment) }}
                        </a>
                    </div>
                    @endif

                    <!-- Source Section -->
                    <div class="pt-4 text-right border-t mt-4">
                        <span class="text-sm text-gray-500">SOURCE: {{ $announcement->source }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>