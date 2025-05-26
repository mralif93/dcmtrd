<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit External Area Conditions') }}
            </h2>
            <a href="{{ route('checklist-m.index', $checklistExternalAreaCondition->checklist->siteVisit->property) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
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

                    <form method="POST" action="{{ route('checklist-external-area-condition-m.update', $checklistExternalAreaCondition) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="checklist_id" value="{{ $checklistExternalAreaCondition->checklist_id }}">

                        <!-- Checklist Information -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Checklist Information</h3>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Property: <span class="font-normal">{{ $checklistExternalAreaCondition->checklist->siteVisit->property->name ?? 'N/A' }}</span></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Site Visit Date: <span class="font-normal">{{ $checklistExternalAreaCondition->checklist->siteVisit->date_visit ? $checklistExternalAreaCondition->checklist->siteVisit->date_visit->format('d/m/Y') : 'N/A' }}</span></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Trustee: <span class="font-normal">{{ $checklistExternalAreaCondition->checklist->siteVisit->trustee ?? 'N/A' }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- External Area Condition Section -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">External Area Conditions</h3>
                            
                            <!-- General Cleanliness -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">General Cleanliness</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_general_cleanliness_satisfied_yes" name="is_general_cleanliness_satisfied" type="radio" value="1" {{ old('is_general_cleanliness_satisfied', $checklistExternalAreaCondition->is_general_cleanliness_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_general_cleanliness_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_general_cleanliness_satisfied_no" name="is_general_cleanliness_satisfied" type="radio" value="0" {{ old('is_general_cleanliness_satisfied', $checklistExternalAreaCondition->is_general_cleanliness_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_general_cleanliness_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="general_cleanliness_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="general_cleanliness_remarks" name="general_cleanliness_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('general_cleanliness_remarks', $checklistExternalAreaCondition->general_cleanliness_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Fencing and Gate -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Fencing and Gate</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_fencing_gate_satisfied_yes" name="is_fencing_gate_satisfied" type="radio" value="1" {{ old('is_fencing_gate_satisfied', $checklistExternalAreaCondition->is_fencing_gate_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_fencing_gate_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_fencing_gate_satisfied_no" name="is_fencing_gate_satisfied" type="radio" value="0" {{ old('is_fencing_gate_satisfied', $checklistExternalAreaCondition->is_fencing_gate_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_fencing_gate_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="fencing_gate_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="fencing_gate_remarks" name="fencing_gate_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('fencing_gate_remarks', $checklistExternalAreaCondition->fencing_gate_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- External Facade -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">External Facade</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_external_facade_satisfied_yes" name="is_external_facade_satisfied" type="radio" value="1" {{ old('is_external_facade_satisfied', $checklistExternalAreaCondition->is_external_facade_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_external_facade_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_external_facade_satisfied_no" name="is_external_facade_satisfied" type="radio" value="0" {{ old('is_external_facade_satisfied', $checklistExternalAreaCondition->is_external_facade_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_external_facade_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="external_facade_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="external_facade_remarks" name="external_facade_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('external_facade_remarks', $checklistExternalAreaCondition->external_facade_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Car Park -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Car Park</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_car_park_satisfied_yes" name="is_car_park_satisfied" type="radio" value="1" {{ old('is_car_park_satisfied', $checklistExternalAreaCondition->is_car_park_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_car_park_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_car_park_satisfied_no" name="is_car_park_satisfied" type="radio" value="0" {{ old('is_car_park_satisfied', $checklistExternalAreaCondition->is_car_park_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_car_park_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="car_park_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="car_park_remarks" name="car_park_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('car_park_remarks', $checklistExternalAreaCondition->car_park_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Land Settlement -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Land Settlement</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_land_settlement_satisfied_yes" name="is_land_settlement_satisfied" type="radio" value="1" {{ old('is_land_settlement_satisfied', $checklistExternalAreaCondition->is_land_settlement_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_land_settlement_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_land_settlement_satisfied_no" name="is_land_settlement_satisfied" type="radio" value="0" {{ old('is_land_settlement_satisfied', $checklistExternalAreaCondition->is_land_settlement_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_land_settlement_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="land_settlement_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="land_settlement_remarks" name="land_settlement_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('land_settlement_remarks', $checklistExternalAreaCondition->land_settlement_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Rooftop -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Rooftop</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_rooftop_satisfied_yes" name="is_rooftop_satisfied" type="radio" value="1" {{ old('is_rooftop_satisfied', $checklistExternalAreaCondition->is_rooftop_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_rooftop_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_rooftop_satisfied_no" name="is_rooftop_satisfied" type="radio" value="0" {{ old('is_rooftop_satisfied', $checklistExternalAreaCondition->is_rooftop_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_rooftop_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="rooftop_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="rooftop_remarks" name="rooftop_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('rooftop_remarks', $checklistExternalAreaCondition->rooftop_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Drainage -->
                            <div class="mb-6 border-b pb-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700 md:w-1/3">Drainage</label>
                                    <div class="flex items-center space-x-4 mt-1 md:mt-0">
                                        <div class="flex items-center">
                                            <input id="is_drainage_satisfied_yes" name="is_drainage_satisfied" type="radio" value="1" {{ old('is_drainage_satisfied', $checklistExternalAreaCondition->is_drainage_satisfied) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_drainage_satisfied_yes" class="ml-2 block text-sm text-gray-700">Satisfactory</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="is_drainage_satisfied_no" name="is_drainage_satisfied" type="radio" value="0" {{ old('is_drainage_satisfied', $checklistExternalAreaCondition->is_drainage_satisfied) === false ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="is_drainage_satisfied_no" class="ml-2 block text-sm text-gray-700">Unsatisfactory</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="drainage_remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="drainage_remarks" name="drainage_remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('drainage_remarks', $checklistExternalAreaCondition->drainage_remarks) }}</textarea>
                                </div>
                            </div>

                            <!-- Additional External Remarks -->
                            <div class="mb-6">
                                <label for="external_remarks" class="block text-sm font-medium text-gray-700">External Remarks</label>
                                <textarea id="external_remarks" name="external_remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('external_remarks', $checklistExternalAreaCondition->external_remarks) }}</textarea>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('checklist-m.show', $checklistExternalAreaCondition->checklist) }}" 
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
                                    Update External Area Condition
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>