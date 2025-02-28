<!-- resources/views/admin/checklists/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Checklist') }}: {{ $checklist->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('checklists.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to All Checklists
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

            <!-- Checklist Details Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Checklist Information</h3>
                    <form action="{{ route('checklists.update', $checklist->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Checklist Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $checklist->name) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="2" 
                                    class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $checklist->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Sections Input -->
                        <div>
                            <label for="sections" class="block text-sm font-medium text-gray-700">Sections (comma separated)</label>
                            <input type="text" id="sections" name="sections" 
                                value="{{ old('sections', implode(', ', $checklist->sections)) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300"
                                placeholder="General, Safety, Quality, etc.">
                            <p class="mt-1 text-xs text-gray-500">Add sections separated by commas. These will be used to organize checklist items.</p>
                            @error('sections')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Checklist
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Checklist Items Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Checklist Items</h3>
                        <a href="{{ route('checklist-items.create', ['checklist_id' => $checklist->id]) }}" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Item
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Required</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if($checklist->items->isEmpty())
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No items found. Add your first checklist item to get started.
                                        </td>
                                    </tr>
                                @else
                                    @foreach($checklist->items->sortBy(['section', 'order']) as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->section }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->item_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $item->type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($item->required)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Yes
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        No
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->order }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('checklist-items.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('checklist-items.destroy', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this item?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section Preview -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Checklist Preview</h3>
                    
                    @if($checklist->items->isEmpty())
                        <p class="text-gray-500">Add items to see how your checklist will appear.</p>
                    @else
                        @foreach($checklist->sections as $section)
                            <div class="mb-8">
                                <h4 class="text-lg font-semibold mb-4 pb-2 border-b">{{ $section }}</h4>
                                <div class="space-y-6">
                                    @foreach($checklist->items->where('section', $section)->sortBy('order') as $item)
                                        <div class="border p-4 rounded-md bg-gray-50">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <label class="block font-medium text-gray-700">
                                                        {{ $item->item_name }}
                                                        @if($item->required)
                                                            <span class="text-red-500">*</span>
                                                        @endif
                                                    </label>
                                                    
                                                    @if($item->description)
                                                        <p class="mt-1 text-sm text-gray-500">{{ $item->description }}</p>
                                                    @endif
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                                                    {{ $item->type }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-3">
                                                @if($item->type === 'Boolean')
                                                    <div class="flex items-center space-x-4">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="preview_{{ $item->id }}" disabled
                                                                class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <span class="ml-2">Yes</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="preview_{{ $item->id }}" disabled
                                                                class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <span class="ml-2">No</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="preview_{{ $item->id }}" disabled
                                                                class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <span class="ml-2">N/A</span>
                                                        </label>
                                                    </div>
                                                @elseif($item->type === 'Text')
                                                    <textarea rows="2" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100" disabled
                                                        placeholder="Text response"></textarea>
                                                @elseif($item->type === 'Number')
                                                    <input type="number" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100" disabled
                                                        placeholder="Number input">
                                                @elseif($item->type === 'Rating')
                                                    <div class="flex flex-wrap items-center gap-4">
                                                        @if(!empty($item->options))
                                                            @foreach($item->options as $option)
                                                                <label class="inline-flex items-center">
                                                                    <input type="radio" name="preview_{{ $item->id }}" value="{{ $option }}" disabled
                                                                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                                    <span class="ml-2">{{ $option }}</span>
                                                                </label>
                                                            @endforeach
                                                        @else
                                                            <span class="text-gray-500 italic">No rating options defined</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>