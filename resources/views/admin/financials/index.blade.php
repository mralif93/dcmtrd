<x-app-layout>
    <div class="container mx-auto px-4 pt-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Financials List</h1>
            <p class="text-lg text-gray-600">Below is a list of all financial records.</p>
        </div>

        @if(session('success'))
            <div class="mb-4">
                <div class="bg-green-500 text-white p-4 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-semibold">Financial Records</h2>
                <div class="ml-auto">
                    <a href="{{ route('financials.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Financial Record
                    </a>
                </div>
            </div>

            <div class="relative overflow-x-auto h-[calc(100vh-150px)]">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th class="px-6 py-3">Bond</th>
                            <th class="px-6 py-3">Financial Year</th>
                            <th class="px-6 py-3">Revenue</th>
                            <th class="px-6 py-3">Expenses</th>
                            <th class="px-6 py-3">Net Income</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($financials as $financial)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $financial->bond->bond_sukuk_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $financial->financial_year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($financial->revenue, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($financial->expenses, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($financial->net_income, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('financials.show', $financial->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">View</a>
                                    <a href="{{ route('financials.edit', $financial->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">Edit</a>
                                    <form action="{{ route('financials.destroy', $financial->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>