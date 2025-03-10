<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Documentation Item Details') }}
            </h2>
            <a href="{{ route('documentation-items-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">{{ $documentationItem->document_type }}</h3>
                    <div>
                        <a href="{{ route('documentation-items-info.edit', $documentationItem->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 mr-2">
                            Edit
                        </a>
                        <form action="{{ route('documentation-items-info.destroy', $documentationItem->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this documentation item?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Document Information -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Document Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Document Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->document_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Item Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->item_number }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->description ?? 'No description provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Validity Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->validity_date ? $documentationItem->validity_date->format('M d, Y') : 'Not specified' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->location ?? 'Not specified' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Prefilled Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($documentationItem->is_prefilled)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes - Prefilled by Legal Department</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No - Not prefilled</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Checklist Information -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Related Checklist</h4>
                    
                    @if($documentationItem->checklist)
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Checklist ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist->id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($documentationItem->checklist->type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $documentationItem->checklist->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                          ($documentationItem->checklist->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($documentationItem->checklist->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Assigned Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist->assigned_department }}</dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->checklist->description ?? 'No description provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Property</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($documentationItem->checklist->property)
                                        <a href="{{ route('properties-info.show', $documentationItem->checklist->property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $documentationItem->checklist->property->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">No property assigned</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $documentationItem->checklist->approval_date ? $documentationItem->checklist->approval_date->format('M d, Y') : 'Not yet approved' }}
                                </dd>
                            </div>
                        </dl>
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('checklists-info.show', $documentationItem->checklist->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200">
                                View Complete Checklist &rarr;
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No associated checklist found or the checklist has been deleted.</p>
                    @endif
                </div>

                <!-- System Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-md font-medium text-gray-700 mb-2">System Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Record ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentationItem->id }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>