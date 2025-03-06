<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Condition Check Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $conditionCheck->item_name }}</h3>
                        <div>
                            <a href="{{ route('condition-checks.edit', $conditionCheck->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('condition-checks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <div class="mr-4">
                                @if ($conditionCheck->is_satisfied)
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-lg font-medium">
                                    @if ($conditionCheck->is_satisfied)
                                        <span class="text-green-700">Condition is Satisfactory</span>
                                    @else
                                        <span class="text-red-700">Condition is Not Satisfactory</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600">
                                    Item {{ $conditionCheck->item_number }} in {{ $conditionCheck->section }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <!-- Condition Check Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Condition Check Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Item Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->item_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Item Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->item_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Section</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->section }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Property & Checklist Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Property & Checklist Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Property</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->property->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Property Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->property->address ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Checklist ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->checklist_id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Checklist Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->checklist->description ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Remarks -->
                        <div class="col-span-2">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Remarks</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-700">{{ $conditionCheck->remarks ?? 'No remarks available' }}</p>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Timestamps</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $conditionCheck->updated_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <form action="{{ route('condition-checks.destroy', $conditionCheck->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this condition check?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>