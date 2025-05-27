<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Internal Area Condition') }}
            </h2>
            <a href="{{ route('checklist-internal-area-conditions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
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

                    <form method="POST" action="{{ route('checklist-internal-area-conditions.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Internal Area Condition Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Checklist Selection -->
                                <div class="col-span-2">
                                    <label for="checklist_id" class="block text-sm font-medium text-gray-500">Checklist</label>
                                    <select id="checklist_id" name="checklist_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a checklist</option>
                                        @foreach($checklists as $checklist)
                                            <option value="{{ $checklist->id }}" {{ old('checklist_id') == $checklist->id ? 'selected' : '' }}>
                                                Checklist #{{ $checklist->id }} - {{ $checklist->property->name ?? 'Unknown Property' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('checklist_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Door/Window Condition -->
                                <div>
                                    <label for="is_door_window_satisfied" class="block text-sm font-medium text-gray-500">Door/Window Condition</label>
                                    <select id="is_door_window_satisfied" name="is_door_window_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_door_window_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_door_window_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_door_window_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Door/Window Remarks -->
                                <div>
                                    <label for="door_window_remarks" class="block text-sm font-medium text-gray-500">Door/Window Remarks</label>
                                    <textarea id="door_window_remarks" name="door_window_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('door_window_remarks') }}</textarea>
                                    @error('door_window_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Staircase Condition -->
                                <div>
                                    <label for="is_staircase_satisfied" class="block text-sm font-medium text-gray-500">Staircase Condition</label>
                                    <select id="is_staircase_satisfied" name="is_staircase_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_staircase_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_staircase_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_staircase_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Staircase Remarks -->
                                <div>
                                    <label for="staircase_remarks" class="block text-sm font-medium text-gray-500">Staircase Remarks</label>
                                    <textarea id="staircase_remarks" name="staircase_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('staircase_remarks') }}</textarea>
                                    @error('staircase_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Toilet Condition -->
                                <div>
                                    <label for="is_toilet_satisfied" class="block text-sm font-medium text-gray-500">Toilet Condition</label>
                                    <select id="is_toilet_satisfied" name="is_toilet_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_toilet_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_toilet_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_toilet_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Toilet Remarks -->
                                <div>
                                    <label for="toilet_remarks" class="block text-sm font-medium text-gray-500">Toilet Remarks</label>
                                    <textarea id="toilet_remarks" name="toilet_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('toilet_remarks') }}</textarea>
                                    @error('toilet_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ceiling Condition -->
                                <div>
                                    <label for="is_ceiling_satisfied" class="block text-sm font-medium text-gray-500">Ceiling Condition</label>
                                    <select id="is_ceiling_satisfied" name="is_ceiling_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_ceiling_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_ceiling_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_ceiling_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ceiling Remarks -->
                                <div>
                                    <label for="ceiling_remarks" class="block text-sm font-medium text-gray-500">Ceiling Remarks</label>
                                    <textarea id="ceiling_remarks" name="ceiling_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('ceiling_remarks') }}</textarea>
                                    @error('ceiling_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Wall Condition -->
                                <div>
                                    <label for="is_wall_satisfied" class="block text-sm font-medium text-gray-500">Wall Condition</label>
                                    <select id="is_wall_satisfied" name="is_wall_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_wall_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_wall_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_wall_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Wall Remarks -->
                                <div>
                                    <label for="wall_remarks" class="block text-sm font-medium text-gray-500">Wall Remarks</label>
                                    <textarea id="wall_remarks" name="wall_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('wall_remarks') }}</textarea>
                                    @error('wall_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Water Seeping Condition -->
                                <div>
                                    <label for="is_water_seeping_satisfied" class="block text-sm font-medium text-gray-500">Water Seeping Condition</label>
                                    <select id="is_water_seeping_satisfied" name="is_water_seeping_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_water_seeping_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_water_seeping_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_water_seeping_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Water Seeping Remarks -->
                                <div>
                                    <label for="water_seeping_remarks" class="block text-sm font-medium text-gray-500">Water Seeping Remarks</label>
                                    <textarea id="water_seeping_remarks" name="water_seeping_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('water_seeping_remarks') }}</textarea>
                                    @error('water_seeping_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Loading Bay Condition -->
                                <div>
                                    <label for="is_loading_bay_satisfied" class="block text-sm font-medium text-gray-500">Loading Bay Condition</label>
                                    <select id="is_loading_bay_satisfied" name="is_loading_bay_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_loading_bay_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_loading_bay_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_loading_bay_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Loading Bay Remarks -->
                                <div>
                                    <label for="loading_bay_remarks" class="block text-sm font-medium text-gray-500">Loading Bay Remarks</label>
                                    <textarea id="loading_bay_remarks" name="loading_bay_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('loading_bay_remarks') }}</textarea>
                                    @error('loading_bay_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Basement/Car Park Condition -->
                                <div>
                                    <label for="is_basement_car_park_satisfied" class="block text-sm font-medium text-gray-500">Basement/Car Park Condition</label>
                                    <select id="is_basement_car_park_satisfied" name="is_basement_car_park_satisfied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select condition</option>
                                        <option value="1" {{ old('is_basement_car_park_satisfied') == '1' ? 'selected' : '' }}>Satisfied</option>
                                        <option value="0" {{ old('is_basement_car_park_satisfied') == '0' ? 'selected' : '' }}>Not Satisfied</option>
                                    </select>
                                    @error('is_basement_car_park_satisfied')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Basement/Car Park Remarks -->
                                <div>
                                    <label for="basement_car_park_remarks" class="block text-sm font-medium text-gray-500">Basement/Car Park Remarks</label>
                                    <textarea id="basement_car_park_remarks" name="basement_car_park_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('basement_car_park_remarks') }}</textarea>
                                    @error('basement_car_park_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Internal Remarks -->
                                <div class="col-span-2">
                                    <label for="internal_remarks" class="block text-sm font-medium text-gray-500">Internal Remarks</label>
                                    <textarea id="internal_remarks" name="internal_remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('internal_remarks') }}</textarea>
                                    @error('internal_remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('checklist-internal-area-conditions.index') }}" 
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
                                    Save Condition
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>