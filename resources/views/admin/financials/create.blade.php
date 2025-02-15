<x-app-layout>
    <div class="container mx-auto px-4 pt-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Add New Financial Record</h1>
            <p class="text-lg text-gray-600">Fill in the details below to add a new financial record.</p>
        </div>

        @if($errors->any())
            <div class="mb-4">
                <div class="bg-red-500 text-white p-4 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('financials.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="financial_year" class="block text-sm font-medium text-gray-700">Financial Year</label>
                    <input type="number" name="financial_year" id="financial_year" value="{{ old('financial_year') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" />
                </div>

                <div class="mb-4">
                    <label for="revenue" class="block text-sm font-medium text-gray-700">Revenue</label>
                    <input type="number" step="0.01" name="revenue" id="revenue" value="{{ old('revenue') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" />
                </div>

                <div class="mb-4">
                    <label for="expenses" class="block text-sm font-medium text-gray-700">Expenses</label>
                    <input type="number" step="0.01" name="expenses" id="expenses" value="{{ old('expenses') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" />
                </div>

                <div class="mb-4">
                    <label for="net_income" class="block text-sm font-medium text-gray-700">Net Income</label>
                    <input type="number" step="0.01" name="net_income" id="net_income" value="{{ old('net_income') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" />
                </div>

                <div class="mb-4">
                    <label for="bond_id" class="block text-sm font-medium text-gray-700">Related Bond</label>
                    <select name="bond_id" id="bond_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                        <option value="">Select a Bond</option>
                        @foreach($bonds as $bond)
                            <option value="{{ $bond->id }}" {{ old('bond_id') == $bond->id ? 'selected' : '' }}>{{ $bond->bond_sukuk_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add Financial Record
                    </button>
                    <a href="{{ route('financials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none transition ease-in-out duration-150 ml-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>