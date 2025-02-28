<!-- resources/views/admin/checklist-items/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Item Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('checklist-items.edit', $item->id) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Item
                </a>
                <a href="{{ route('checklists.edit', $item->checklist_id) }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Checklist
                </a>
            </div>
        </div>
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

            <!-- Checklist Item Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex justify-between">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Item Information</h3>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ $item->type }}
                                    </span>
                                    @if($item->required)
                                        <span class="px-2 py-1 text-xs rounded-full ml-1 bg-red-100 text-red-800">
                                            Required
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Item Name</div>
                                <div class="text-sm text-gray-900">{{ $item->item_name }}</div>
                                
                                <div class="text-sm font-medium text-gray-500">Section</div>
                                <div class="text-sm text-gray-900">{{ $item->section }}</div>
                                
                                <div class="text-sm font-medium text-gray-500">Display Order</div>
                                <div class="text-sm text-gray-900">{{ $item->order }}</div>
                                
                                <div class="text-sm font-medium text-gray-500">Belongs to Checklist</div>
                                <div class="text-sm text-gray-900">
                                    <a href="{{ route('checklists.show', $item->checklist) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $item->checklist->name }}
                                    </a>
                                </div>
                                
                                <div class="text-sm font-medium text-gray-500">Created</div>
                                <div class="text-sm text-gray-900">{{ $item->created_at->format('M d, Y h:i A') }}</div>
                                
                                <div class="text-sm font-medium text-gray-500">Last Updated</div>
                                <div class="text-sm text-gray-900">{{ $item->updated_at->format('M d, Y h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div>
                            @if($item->description)
                                <div>
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Description</h3>
                                    <div class="mt-2 p-4 bg-gray-50 rounded">
                                        {{ $item->description }}
                                    </div>
                                </div>
                            @endif
                            
                            @if($item->type === 'Rating' && !empty($item->options))
                                <div class="mt-6">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Rating Options</h3>
                                    <div class="mt-2 p-4 bg-gray-50 rounded">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($item->options as $option)
                                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                                                    {{ $option }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Item Type Details</h3>
                                <div class="mt-2 p-4 bg-gray-50 rounded">
                                    <div class="text-sm text-gray-700">
                                        @if($item->type === 'Boolean')
                                            <p>This is a Yes/No question that allows users to select Yes, No, or N/A.</p>
                                        @elseif($item->type === 'Text')
                                            <p>This is a text field that allows users to enter free-form text responses.</p>
                                        @elseif($item->type === 'Number')
                                            <p>This is a number field that allows users to enter numeric values only.</p>
                                        @elseif($item->type === 'Rating')
                                            <p>This is a rating selection that allows users to choose from predefined options.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Example -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Example Response Interface</h3>
                    <div class="mt-2 p-6 bg-gray-50 rounded border border-gray-200">
                        <label class="block font-medium text-gray-700 mb-2">
                            {{ $item->item_name }}
                            @if($item->required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <div class="mt-1">
                            @if($item->type === 'Boolean')
                                <div class="flex items-center space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="example" value="Yes" 
                                            class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="example" value="No" 
                                            class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">No</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="example" value="N/A" 
                                            class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">N/A</span>
                                    </label>
                                </div>
                            @elseif($item->type === 'Text')
                                <textarea rows="2" class="mt-1 block w-full rounded-md border-gray-300" 
                                    placeholder="Enter text response here..."></textarea>
                            @elseif($item->type === 'Number')
                                <input type="number" class="mt-1 block w-full rounded-md border-gray-300" 
                                    placeholder="Enter a number">
                            @elseif($item->type === 'Rating')
                                <div class="flex items-center space-x-4">
                                    @if(!empty($item->options))
                                        @foreach($item->options as $option)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="example" value="{{ $option }}" 
                                                    class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="ml-2">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <p class="text-gray-500 italic">No rating options defined</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('checklist-items.edit', $item->id) }}" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Edit Item
                </a>
                <form action="{{ route('checklist-items.destroy', $item->id) }}" 
                      method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">
                        Delete Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>