<!-- resources/views/checklists/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $checklist->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('checklists.create-response', $checklist) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Use Checklist
                </a>
                <a href="{{ route('checklists.edit', $checklist) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Checklist
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

            <!-- Checklist Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Checklist Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Checklist Type</div>
                                <div>{{ $checklist->type }}</div>
                                
                                <div class="text-sm text-gray-500">Template</div>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $checklist->is_template ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $checklist->is_template ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-500">Number of Items</div>
                                <div>{{ $checklist->items->count() }}</div>
                                
                                <div class="text-sm text-gray-500">Created At</div>
                                <div>{{ $checklist->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Status</div>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $checklist->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $checklist->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-500">Number of Sections</div>
                                <div>{{ count($checklist->sections) }}</div>
                                
                                <div class="text-sm text-gray-500">Times Used</div>
                                <div>{{ $checklist->responses->count() }}</div>
                                
                                <div class="text-sm text-gray-500">Last Updated</div>
                                <div>{{ $checklist->updated_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Description</div>
                        <div class="mt-1">{{ $checklist->description ?? 'No description provided' }}</div>
                    </div>
                </div>
            </div>

            <!-- Checklist Items -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Checklist Items</h3>
                    </div>
                    
                    @if($checklist->items->isNotEmpty())
                        @foreach($checklist->sections as $section)
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-2 border-b pb-2">{{ $section }}</h4>
                                
                                <div class="space-y-4">
                                    @foreach($checklist->items->where('section', $section) as $item)
                                        <div class="bg-gray-50 p-4 rounded">
                                            <div class="flex justify-between">
                                                <h5 class="font-medium">{{ $item->item_name }}</h5>
                                                <div>
                                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $item->type }}</span>
                                                    @if($item->required)
                                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full ml-1">Required</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($item->description)
                                                <p class="text-sm text-gray-600 mt-2">{{ $item->description }}</p>
                                            @endif
                                            
                                            @if($item->type === 'Rating' && !empty($item->options))
                                                <div class="mt-2">
                                                    <div class="text-xs text-gray-500">Rating Options:</div>
                                                    <div class="flex space-x-2 mt-1">
                                                        @foreach($item->options as $option)
                                                            <span class="px-2 py-1 bg-gray-200 rounded text-xs">{{ $option }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">No items added to this checklist yet.</p>
                        <div class="mt-4">
                            <a href="{{ route('checklists.edit', $checklist) }}" class="text-blue-600 hover:text-blue-900">
                                Add items to this checklist
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Responses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Responses</h3>
                        <a href="{{ route('checklists.create-response', $checklist) }}" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            New Response
                        </a>
                    </div>
                    
                    @if($responses->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($responses as $response)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('units.show', $response->unit) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $response->unit->property->name }} - {{ $response->unit->unit_number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($response->tenant)
                                                <a href="{{ route('tenants.show', $response->tenant) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $response->tenant->first_name }} {{ $response->tenant->last_name }}
                                                </a>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $response->completed_by }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $response->completed_at ? $response->completed_at->format('M d, Y') : $response->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($response->status === 'Draft') bg-yellow-100 text-yellow-800
                                                @elseif($response->status === 'Completed') bg-green-100 text-green-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ $response->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('checklist-responses.show', $response) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            @if($response->status !== 'Reviewed')
                                                <a href="{{ route('checklist-responses.edit', $response) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $responses->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No responses recorded for this checklist yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>