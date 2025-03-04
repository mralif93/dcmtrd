<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checklist Details') }}
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
                        <h3 class="text-lg font-medium text-gray-900">{{ $checklist->property->name }}</h3>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Property Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Name</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->property->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Address</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->property->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Checklist Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Type</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->type }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Approval Date</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->approval_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Status</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($checklist->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($checklist->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="px-4 mb-4">
                                <p class="text-xs font-medium text-gray-500">Description</p>
                                <p class="text-sm text-gray-900">{{ $checklist->description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2">System Information</h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Created at</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->created_at->format('d/m/Y h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Updated at</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->updated_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                        <div class="flex justify-end gap-x-4">
                            <a href="{{ route('checklists.index') }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('checklists.edit', $checklist) }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Checklist
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>