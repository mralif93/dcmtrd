<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rating Movement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">Updating movement for {{ $ratingMovement->bond->isin_code }}</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('rating-movements.update', $ratingMovement) }}" method="POST" class="space-y-8 p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Core Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="bond_id" class="block text-sm font-medium text-gray-700">Bond *</label>
                                    <select name="bond_id" id="bond_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select a Bond</option>
                                        @foreach($bonds as $bond)
                                            <option value="{{ $bond->id }}" @selected(old('bond_id', $ratingMovement->bond_id) == $bond->id)>
                                                {{ $bond->isin_code }} - {{ $bond->bond_sukuk_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="rating_agency" class="block text-sm font-medium text-gray-700">Agency *</label>
                                    <select name="rating_agency" id="rating_agency" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Rating Agency</option>
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency }}" @selected(old('rating_agency', $ratingMovement->rating_agency) == $agency)>
                                                {{ $agency }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="effective_date" class="block text-sm font-medium text-gray-700">Effective Date *</label>
                                    <input type="date" name="effective_date" id="effective_date" 
                                        value="{{ old('effective_date', $ratingMovement->effective_date?->format('Y-m-d')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="rating_tenure" class="block text-sm font-medium text-gray-700">Rating Tenure *</label>
                                    <input type="text" name="rating_tenure" id="rating_tenure" 
                                        value="{{ old('rating_tenure', $ratingMovement->rating_tenure) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="e.g., 5 years">
                                </div>
                            </div>
                        </div>

                        <!-- Rating Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Rating Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating *</label>
                                    <input type="text" name="rating" id="rating" 
                                        value="{{ old('rating', $ratingMovement->rating) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="e.g., AA+">
                                </div>

                                <div>
                                    <label for="rating_action" class="block text-sm font-medium text-gray-700">Action *</label>
                                    <select name="rating_action" id="rating_action" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach($ratingActions as $action)
                                            <option value="{{ $action }}" @selected(old('rating_action', $ratingMovement->rating_action) == $action)>
                                                {{ $action }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="rating_outlook" class="block text-sm font-medium text-gray-700">Outlook *</label>
                                    <select name="rating_outlook" id="rating_outlook" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach($outlooks as $outlook)
                                            <option value="{{ $outlook }}" @selected(old('rating_outlook', $ratingMovement->rating_outlook) == $outlook)>
                                                {{ $outlook }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="rating_watch" class="block text-sm font-medium text-gray-700">Watch</label>
                                    <select name="rating_watch" id="rating_watch"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">None</option>
                                        <option value="Positive" @selected(old('rating_watch', $ratingMovement->rating_watch) == 'Positive')>Positive</option>
                                        <option value="Negative" @selected(old('rating_watch', $ratingMovement->rating_watch) == 'Negative')>Negative</option>
                                        <option value="Evolving" @selected(old('rating_watch', $ratingMovement->rating_watch) == 'Evolving')>Evolving</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('rating-movements.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Rating Movement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>