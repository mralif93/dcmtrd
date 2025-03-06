<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Property Improvement Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $propertyImprovement->improvement_type }} ({{ $propertyImprovement->item_number }})</h3>
                        <div>
                            <a href="{{ route('property-improvements-info.edit', $propertyImprovement->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('property-improvements-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
                                @if ($propertyImprovement->status == 'completed')
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @elseif ($propertyImprovement->status == 'pending')
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-gray-100">
                                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-lg font-medium">
                                    @if ($propertyImprovement->status == 'completed')
                                        <span class="text-green-700">Completed</span>
                                    @elseif ($propertyImprovement->status == 'pending')
                                        <span class="text-yellow-700">Pending</span>
                                    @else
                                        <span class="text-gray-700">Not Applicable</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600">
                                    Item {{ $propertyImprovement->item_number }} - {{ $propertyImprovement->improvement_type }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <!-- Property Improvement Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Improvement Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Item Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->item_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Improvement Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->improvement_type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Sub Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->sub_type ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($propertyImprovement->status) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->approval_date ? $propertyImprovement->approval_date->format('Y-m-d') : 'Not approved yet' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Property & Checklist Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Property & Checklist Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Property</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->checklist->property->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Property Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->checklist->property->address ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Checklist ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->checklist_id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Checklist Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->checklist->description ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Scope of Work -->
                        <div class="col-span-2">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Scope of Work</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $propertyImprovement->scope_of_work ?? 'No scope of work specified.' }}</p>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Timestamps</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $propertyImprovement->updated_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <form action="{{ route('property-improvements-info.destroy', $propertyImprovement->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property improvement?');">
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