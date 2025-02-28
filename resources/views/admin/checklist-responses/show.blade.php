<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Response Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('checklist-responses.edit', $checklistResponse) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Response
                </a>
                <a href="{{ route('checklist-responses.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
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

            <!-- Response Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="text-2xl font-bold">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($checklistResponse->status == 'Draft') bg-yellow-100 text-yellow-800
                                @elseif($checklistResponse->status == 'Completed') bg-green-100 text-green-800
                                @elseif($checklistResponse->status == 'Reviewed') bg-blue-100 text-blue-800
                                @endif">
                                {{ $checklistResponse->status }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Completed By</div>
                        <div class="text-2xl font-bold">{{ $checklistResponse->completed_by }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Completed At</div>
                        <div class="text-2xl font-bold">
                            {{ $checklistResponse->completed_at ? $checklistResponse->completed_at->format('M d, Y H:i') : 'N/A' }}
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Reviewed By</div>
                        <div class="text-2xl font-bold">{{ $checklistResponse->reviewer ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Response Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Response Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Checklist</div>
                                <div>{{ $checklistResponse->checklist->name ?? 'N/A' }}</div>
                                
                                <div class="text-sm text-gray-500">Unit</div>
                                <div>{{ $checklistResponse->unit->name ?? 'N/A' }}</div>
                                
                                <div class="text-sm text-gray-500">Tenant</div>
                                <div>{{ $checklistResponse->tenant->name ?? 'N/A' }}</div>
                                
                                <div class="text-sm text-gray-500">Created At</div>
                                <div>{{ $checklistResponse->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Status</div>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($checklistResponse->status == 'Draft') bg-yellow-100 text-yellow-800
                                        @elseif($checklistResponse->status == 'Completed') bg-green-100 text-green-800
                                        @elseif($checklistResponse->status == 'Reviewed') bg-blue-100 text-blue-800
                                        @endif">
                                        {{ $checklistResponse->status }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-500">Completed By</div>
                                <div>{{ $checklistResponse->completed_by }}</div>
                                
                                <div class="text-sm text-gray-500">Completed At</div>
                                <div>{{ $checklistResponse->completed_at ? $checklistResponse->completed_at->format('M d, Y H:i') : 'N/A' }}</div>
                                
                                <div class="text-sm text-gray-500">Reviewed At</div>
                                <div>{{ $checklistResponse->reviewed_at ? $checklistResponse->reviewed_at->format('M d, Y H:i') : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($checklistResponse->notes)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Notes</div>
                        <div class="mt-1 p-4 bg-gray-50 rounded">{{ $checklistResponse->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Response Data -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Response Data</h3>
                    
                    <div class="space-y-4">
                        @php
                            $responseData = json_decode($checklistResponse->response_data, true);
                        @endphp
                        
                        @forelse($responseData as $itemId => $response)
                            <div class="border rounded p-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="col-span-2">
                                        <div class="text-sm text-gray-500">Question ID</div>
                                        <div>{{ $itemId }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Response</div>
                                        <div>
                                            @if(is_bool($response))
                                                {{ $response ? 'Yes' : 'No' }}
                                            @elseif($response === 'yes' || $response === 'no')
                                                {{ ucfirst($response) }}
                                            @else
                                                {{ $response }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-4 bg-gray-50 rounded">
                                No response data available
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Images -->
            @if($checklistResponse->images)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Images</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @php
                            $images = json_decode($checklistResponse->images, true);
                        @endphp
                        
                        @foreach($images as $image)
                            <div class="border rounded p-2">
                                <img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['name'] }}" class="w-full h-48 object-cover object-center">
                                <div class="mt-2 text-sm text-center truncate">{{ $image['name'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Attachments -->
            @if($checklistResponse->attachments)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Attachments</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $attachments = json_decode($checklistResponse->attachments, true);
                                @endphp
                                
                                @foreach($attachments as $attachment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attachment['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attachment['type'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-900">Download</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>