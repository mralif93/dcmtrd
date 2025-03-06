<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Property Improvement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('property-improvements.index') }}" class="text-blue-600 hover:text-blue-900">
                            &larr; Back to Improvements
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Property Improvement Details</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Property</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->checklist->property->name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Address</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->checklist->property->address }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Item Number</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->item_number }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Improvement Type</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->improvement_type }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Sub Type</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->sub_type ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                    <p class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($propertyImprovement->status == 'completed') bg-green-100 text-green-800 
                                            @elseif($propertyImprovement->status == 'pending') bg-yellow-100 text-yellow-800 
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($propertyImprovement->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Approval Date</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->approval_date ? $propertyImprovement->approval_date->format('M d, Y') : 'Not approved yet' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Created At</h4>
                                    <p class="mt-1 text-lg">{{ $propertyImprovement->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-500">Scope of Work</h4>
                                <div class="mt-1 p-4 border border-gray-200 rounded-md bg-gray-50">
                                    <p class="whitespace-pre-line">{{ $propertyImprovement->scope_of_work ?? 'No scope of work specified.' }}</p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <a href="{{ route('property-improvements.edit', $propertyImprovement) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Edit
                                </a>
                                <form action="{{ route('property-improvements.destroy', $propertyImprovement) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this improvement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>