<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Disposal Installation') }}
            </h2>
            <a href="{{ route('checklist-m.index', $checklistDisposalInstallation->checklist->siteVisit->property) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checklist-disposal-installation-m.update', $checklistDisposalInstallation) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="checklist_id" value="{{ $checklistDisposalInstallation->checklist->id }}">

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Disposal Installation Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Component Name -->
                                <div class="col-span-2">
                                    <label for="component_name" class="block text-sm font-medium text-gray-500">Component Name</label>
                                    <input id="component_name" type="text" name="component_name" value="{{ old('component_name', $checklistDisposalInstallation->component_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('component_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Component Date -->
                                <div>
                                    <label for="component_date" class="block text-sm font-medium text-gray-500">Component Date</label>
                                    <input id="component_date" type="date" name="component_date" value="{{ old('component_date', $checklistDisposalInstallation->component_date ? $checklistDisposalInstallation->component_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('component_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Component Status -->
                                <div>
                                    <label for="component_status" class="block text-sm font-medium text-gray-500">Component Status</label>
                                    <select id="component_status" name="component_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select status</option>
                                        <option value="active" {{ old('component_status', $checklistDisposalInstallation->component_status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('component_status', $checklistDisposalInstallation->component_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="pending" {{ old('component_status', $checklistDisposalInstallation->component_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ old('component_status', $checklistDisposalInstallation->component_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('component_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Component Scope of Work -->
                                <div class="col-span-2">
                                    <label for="component_scope_of_work" class="block text-sm font-medium text-gray-500">Component Scope of Work</label>
                                    <textarea id="component_scope_of_work" name="component_scope_of_work" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('component_scope_of_work', $checklistDisposalInstallation->component_scope_of_work) }}</textarea>
                                    @error('component_scope_of_work')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="border-t border-gray-200 py-4 mt-6">
                                <div class="flex justify-end gap-4">
                                    <a href="{{ route('checklist-m.show', $checklistDisposalInstallation->checklist) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                        </svg>
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Update Installation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>