<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Redemption') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Validation Issues ({{ $errors->count() }})</h3>
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
                <form action="{{ route('redemptions.update', $redemption) }}" method="POST" class="p-6">
                    @csrf @method('PUT')

                    <div class="space-y-6 pb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Row 1: Bond Selection -->
                            <div>
                                <label for="bond_id" class="block text-sm font-medium text-gray-700">Bond *</label>
                                <select name="bond_id" id="bond_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                            {{ $errors->has('bond_id') ? 'border-red-300' : '' }}">
                                    <option value="">Select Bond</option>
                                    @foreach($bonds as $bond)
                                        <option value="{{ $bond->id }}" 
                                            @selected(old('bond_id', $redemption->bond_id) == $bond->id)
                                            {{ $redemption->bond_id == $bond->id ? 'selected' : '' }}>
                                            {{ $bond->isin_code }} - {{ $bond->stock_code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bond_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Row 2: Last Call Date -->
                            <div>
                                <label for="last_call_date" class="block text-sm font-medium text-gray-700">Last Call Date *</label>
                                <input type="date" name="last_call_date" id="last_call_date" 
                                    value="{{ old('last_call_date', $redemption->last_call_date?->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                        {{ $errors->has('last_call_date') ? 'border-red-300' : '' }}">
                                @error('last_call_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Checkbox Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-200 pt-6">
                            <!-- Partial Redemption -->
                            <div class="relative flex items-start space-x-3">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="allow_partial_call" id="allow_partial_call" 
                                        value="1"
                                        @checked(old('allow_partial_call', $redemption->allow_partial_call))
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="allow_partial_call" class="font-medium text-gray-700">Partial Redemption</label>
                                    <p class="text-gray-500">Enable partial redemption of bond holdings</p>
                                    @error('allow_partial_call')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nearest Denomination -->
                            <div class="relative flex items-start space-x-3">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="redeem_nearest_denomination" id="redeem_nearest_denomination" 
                                        value="1"
                                        @checked(old('redeem_nearest_denomination', $redemption->redeem_nearest_denomination))
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="redeem_nearest_denomination" class="font-medium text-gray-700">Nearest Denomination</label>
                                    <p class="text-gray-500">Round to nearest denomination value</p>
                                    @error('redeem_nearest_denomination')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                            <a href="{{ route('redemptions.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Redemption
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>