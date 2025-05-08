<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit ADI Holder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with
                                your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">ADI Holder Information</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Edit the details of the ADI Holder. Ensure that all required fields are completed accurately.
                    </p>
                </div>

                <form method="POST"  action="{{ route('adi-holder-m.update') }}" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="facility_id" value="{{ $adiHolders->first()->facility_information_id }}">

                    <div class="pb-6 space-y-6 border-b border-gray-200">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Authorized Depositary Institution (ADI)
                            Holder</h3>

                        <!-- ADI Holder Name input -->
                        <div>
                            <label for="adi_holder_name" class="block text-sm font-medium text-gray-700">ADI Holder
                                *</label>
                            <input type="text" name="adi_holder_name" id="adi_holder_name"
                                value="{{ old('adi_holder_name', $adiHolders->first()->adi_holder ?? '') }}" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        @foreach ($adiHolders as $adiHolder)
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="adi_holder_ids[]" value="{{ $adiHolder->id }}">
                                <label class="block text-sm font-medium text-gray-700">Stock Code *</label>
                                <input type="text" name="stock_codes[]"
                                    value="{{ old('stock_codes.' . $loop->index, $adiHolder->stock_code) }}"
                                    placeholder="Stock Code" required
                                    class="w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label class="block text-sm font-medium text-gray-700">Nominal Value *</label>
                                <input type="number" name="nominal_values[]"
                                    value="{{ old('nominal_values.' . $loop->index, $adiHolder->nominal_value) }}"
                                    placeholder="Nominal Value" required
                                    class="w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                {{-- <button type="button" onclick="this.parentNode.remove()"
                                    class="text-sm text-red-600 hover:text-red-800">
                                    Remove
                                </button> --}}
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end gap-4 pt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Update ADI Holder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
