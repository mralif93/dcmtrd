<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documentation Item Details') }}
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
                        <h3 class="text-lg font-medium text-gray-900">{{ $documentationItem->document_type }}</h3>
                        <div>
                            <a href="{{ route('documentation-items-info.edit', $documentationItem->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('documentation-items-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->id }}</dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Item Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->item_number }}</dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Document Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->document_type }}</dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Checklist ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist_id }}</dd>
                        </div>

                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->description ?? 'N/A' }}</dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Validity Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $documentationItem->validity_date ? $documentationItem->validity_date->format('Y-m-d') : 'N/A' }}
                            </dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->location ?? 'N/A' }}</dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Prefilled by Legal Department</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if ($documentationItem->is_prefilled)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                                @endif
                            </dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $documentationItem->created_at->format('Y-m-d H:i:s') }}
                            </dd>
                        </div>

                        <div class="col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $documentationItem->updated_at->format('Y-m-d H:i:s') }}
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Related Checklist Information</h4>
                        
                        @if ($documentationItem->checklist)
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                                <div class="col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Checklist Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist->type }}</dd>
                                </div>
                                
                                <div class="col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Checklist Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist->status }}</dd>
                                </div>

                                <div class="col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Checklist Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist->description ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        @else
                            <p class="text-sm text-gray-500">No related checklist found or the checklist has been deleted.</p>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <form action="{{ route('documentation-items-info.destroy', $documentationItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
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