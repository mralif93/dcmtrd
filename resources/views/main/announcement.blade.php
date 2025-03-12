<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Announcement Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-4">
                    <!-- Title Section -->
                    <h1 class="pb-6 mb-4 text-2xl font-bold text-gray-900">{{ $announcement->title }}</h1>

                    <!-- Metadata Section -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between pb-2 border-b">
                            <span class="w-1/3 font-semibold">ANNOUNCEMENT DATE:</span>
                            <span class="w-2/3">{{ $announcement->announcement_date->format('d-M-Y') }}</span>
                        </div>
                        <div class="flex justify-between pb-2 border-b">
                            <span class="w-1/3 font-semibold">CATEGORY:</span>
                            <span class="w-2/3">{{ $announcement->category }}</span>
                        </div>
                        <div class="flex justify-between pb-2 border-b">
                            <span class="w-1/3 font-semibold">SUB-CATEGORY:</span>
                            <span class="w-2/3">{{ $announcement->sub_category }}</span>
                        </div>
                        <div class="flex justify-between pb-2 border-b">
                            <span class="w-1/3 font-semibold">ISSUER NAME:</span>
                            <span class="w-2/3">{{ $announcement->issuer->issuer_name }}</span>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="pt-4">
                        <h3 class="mb-2 font-semibold">DESCRIPTION:</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $announcement->description }}</p>
                    </div>

                    <!-- Content Section -->
                    <div class="pt-4">
                        <h3 class="mb-2 font-semibold">CONTENT:</h3>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $announcement->content }}</div>
                    </div>

                    <!-- Attachment Section -->
                    @if ($announcement->attachment)
                        <div class="pt-4">
                            <h3 class="mb-2 font-semibold">ATTACHMENT:</h3>
                            <a href="{{ asset('storage/' . $announcement->attachment) }}"
                                class="text-blue-600 hover:text-blue-800" target="_blank">
                                {{ basename($announcement->attachment) }}
                            </a>
                        </div>
                    @endif

                    <!-- Source Section -->
                    <div class="pt-4 mt-4 text-right border-t">
                        <span class="text-sm text-gray-500">SOURCE: {{ $announcement->source }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-main-layout>
