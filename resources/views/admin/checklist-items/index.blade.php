<!-- resources/views/admin/checklist-items/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Items') }}
            </h2>
            <div class="flex space-x-2">
                @if(request('checklist_id'))
                    <a href="{{ route('checklist-items.create', ['checklist_id' => request('checklist_id')]) }}" 
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Add Item
                    </a>
                @endif
                <a href="{{ route('checklists.index') }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    All Checklists
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

            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('checklist-items.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-1/3">
                            <label for="checklist_id" class="block text-sm font-medium text-gray-700">Checklist</label>
                            <select name="checklist_id" id="checklist_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">All Checklists</option>
                                @foreach($checklists as $id => $name)
                                    <option value="{{ $id }}" {{ request('checklist_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="w-full md:w-1/4">
                            <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                            <select name="section" id="section" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">All Sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>{{ $section }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="w-full md:w-1/4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Item Type</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">All Types</option>
                                <option value="Boolean" {{ request('type') == 'Boolean' ? 'selected' : '' }}>Yes/No</option>
                                <option value="Text" {{ request('type') == 'Text' ? 'selected' : '' }}>Text</option>
                                <option value="Number" {{ request('type') == 'Number' ? 'selected' : '' }}>Number</option>
                                <option value="Rating" {{ request('type') == 'Rating' ? 'selected' : '' }}>Rating</option>
                            </select>
                        </div>
                        
                        <div class="w-full md:w-1/6 flex items-end">
                            <button type="submit" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Items List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Checklist</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Required</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->checklist->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->section }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('checklist-items.show', $item->id) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $item->item_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            {{ $item->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $item->required ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $item->required ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('checklist-items.show', $item->id) }}" 
                                            class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <a href="{{ route('checklist-items.edit', $item->id) }}" 
                                            class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('checklist-items.destroy', $item->id) }}" 
                                                method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Are you sure you want to delete this item?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">No items found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>