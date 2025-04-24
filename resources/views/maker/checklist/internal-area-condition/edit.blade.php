<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Internal Area Conditions') }}
            </h2>
            <a href="{{ route('checklist-m.index', $checklistInternalAreaCondition->checklist->siteVisit->property) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
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

                    <form method="POST" action="{{ route('checklist-internal-area-condition-m.update', $checklistInternalAreaCondition) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="checklist_id" value="{{ $checklistInternalAreaCondition->checklist_id }}">

                        <!-- Checklist Information -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Checklist Information</h3>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Property: <span class="font-normal">{{ $checklistInternalAreaCondition->checklist->siteVisit->property->name ?? 'N/A' }}</span></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Site Visit Date: <span class="font-normal">{{ $checklistInternalAreaCondition->checklist->siteVisit->date_visit ? $checklistInternalAreaCondition->checklist->siteVisit->date_visit->format('d/m/Y') : 'N/A' }}</span></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Trustee: <span class="font-normal">{{ $checklistInternalAreaCondition->checklist->siteVisit->trustee ?? 'N/A' }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Internal Area Condition Section -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Internal Area Conditions</h3>
                            
                            <!-- Doors and Windows -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Doors and Windows</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_door_window_satisfied_yes" name="is_door_window_satisfied" type="radio" value="1" {{ old('is_door_window_satisfied', $checklistInternalAreaCondition->is_door_window_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_door_window_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_door_window_satisfied_no" name="is_door_window_satisfied" type="radio" value="0" {{ old('is_door_window_satisfied', $checklistInternalAreaCondition->is_door_window_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_door_window_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="door_window_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="door_window_remarks" name="door_window_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('door_window_remarks', $checklistInternalAreaCondition->door_window_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Staircase -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Staircase</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_staircase_satisfied_yes" name="is_staircase_satisfied" type="radio" value="1" {{ old('is_staircase_satisfied', $checklistInternalAreaCondition->is_staircase_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_staircase_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_staircase_satisfied_no" name="is_staircase_satisfied" type="radio" value="0" {{ old('is_staircase_satisfied', $checklistInternalAreaCondition->is_staircase_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_staircase_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="staircase_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="staircase_remarks" name="staircase_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('staircase_remarks', $checklistInternalAreaCondition->staircase_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Toilet -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Toilet</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_toilet_satisfied_yes" name="is_toilet_satisfied" type="radio" value="1" {{ old('is_toilet_satisfied', $checklistInternalAreaCondition->is_toilet_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_toilet_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_toilet_satisfied_no" name="is_toilet_satisfied" type="radio" value="0" {{ old('is_toilet_satisfied', $checklistInternalAreaCondition->is_toilet_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_toilet_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="toilet_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="toilet_remarks" name="toilet_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('toilet_remarks', $checklistInternalAreaCondition->toilet_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Ceiling -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Ceiling</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_ceiling_satisfied_yes" name="is_ceiling_satisfied" type="radio" value="1" {{ old('is_ceiling_satisfied', $checklistInternalAreaCondition->is_ceiling_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_ceiling_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_ceiling_satisfied_no" name="is_ceiling_satisfied" type="radio" value="0" {{ old('is_ceiling_satisfied', $checklistInternalAreaCondition->is_ceiling_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_ceiling_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="ceiling_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="ceiling_remarks" name="ceiling_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('ceiling_remarks', $checklistInternalAreaCondition->ceiling_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Wall -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Wall</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_wall_satisfied_yes" name="is_wall_satisfied" type="radio" value="1" {{ old('is_wall_satisfied', $checklistInternalAreaCondition->is_wall_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_wall_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_wall_satisfied_no" name="is_wall_satisfied" type="radio" value="0" {{ old('is_wall_satisfied', $checklistInternalAreaCondition->is_wall_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_wall_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="wall_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="wall_remarks" name="wall_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('wall_remarks', $checklistInternalAreaCondition->wall_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Water Seeping -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Water Seeping</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_water_seeping_satisfied_yes" name="is_water_seeping_satisfied" type="radio" value="1" {{ old('is_water_seeping_satisfied', $checklistInternalAreaCondition->is_water_seeping_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_water_seeping_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_water_seeping_satisfied_no" name="is_water_seeping_satisfied" type="radio" value="0" {{ old('is_water_seeping_satisfied', $checklistInternalAreaCondition->is_water_seeping_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_water_seeping_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="water_seeping_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="water_seeping_remarks" name="water_seeping_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('water_seeping_remarks', $checklistInternalAreaCondition->water_seeping_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Loading Bay -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Loading Bay</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_loading_bay_satisfied_yes" name="is_loading_bay_satisfied" type="radio" value="1" {{ old('is_loading_bay_satisfied', $checklistInternalAreaCondition->is_loading_bay_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_loading_bay_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_loading_bay_satisfied_no" name="is_loading_bay_satisfied" type="radio" value="0" {{ old('is_loading_bay_satisfied', $checklistInternalAreaCondition->is_loading_bay_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_loading_bay_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="loading_bay_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="loading_bay_remarks" name="loading_bay_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('loading_bay_remarks', $checklistInternalAreaCondition->loading_bay_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Basement Car Park -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Basement Car Park</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_basement_car_park_satisfied_yes" name="is_basement_car_park_satisfied" type="radio" value="1" {{ old('is_basement_car_park_satisfied', $checklistInternalAreaCondition->is_basement_car_park_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_basement_car_park_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_basement_car_park_satisfied_no" name="is_basement_car_park_satisfied" type="radio" value="0" {{ old('is_basement_car_park_satisfied', $checklistInternalAreaCondition->is_basement_car_park_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_basement_car_park_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="basement_car_park_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="basement_car_park_remarks" name="basement_car_park_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('basement_car_park_remarks', $checklistInternalAreaCondition->basement_car_park_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Additional Internal Remarks -->
                            <div class="mb-6">
                                <label for="internal_remarks" class="block text-sm font-medium text-gray-700">Additional Internal Remarks</label>
                                <textarea id="internal_remarks" name="internal_remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('internal_remarks', $checklistInternalAreaCondition->internal_remarks) }}</textarea>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('checklist-m.index', $checklistInternalAreaCondition->checklist->siteVisit->property) }}" 
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
                                    Update Internal Area Condition
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>