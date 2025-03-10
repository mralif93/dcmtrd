<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ __('Trustee Fees Report') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 mt-8 bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-800 min-w-max">
                        <thead class="text-gray-700 bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left">Month</th>
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Issuer</th>
                                <th class="px-4 py-3 text-left">Description</th>
                                <th class="px-4 py-3 text-left">Fees (RM)</th>
                                <th class="px-4 py-3 text-left">Anniversary Date</th>
                                <th class="px-4 py-3 text-left">Memo To FAD</th>
                                <th class="px-4 py-3 text-left">Invoice No</th>
                                <th class="px-4 py-3 text-left">Date Letter to Issuer</th>
                                <th class="px-4 py-3 text-left">1st Reminder</th>
                                <th class="px-4 py-3 text-left">2nd Reminder</th>
                                <th class="px-4 py-3 text-left">3rd Reminder</th>
                                <th class="px-4 py-3 text-left">Payment Received</th>
                                <th class="px-4 py-3 text-left">TT/Cheque No</th>
                                <th class="px-4 py-3 text-left">Memo Receipt to FAD</th>
                                <th class="px-4 py-3 text-left">Receipt to Issuer</th>
                                <th class="px-4 py-3 text-left">Receipt No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (range(1, 5) as $index)
                            <tr class="transition border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ now()->format('F') }}</td>
                                <td class="px-4 py-3">{{ now()->subDays($index)->format('d M Y') }}</td>
                                <td class="px-4 py-3">Issuer {{ $index }}</td>
                                <td class="px-4 py-3">Description {{ $index }}</td>
                                <td class="px-4 py-3 font-semibold text-green-600">RM {{ number_format(rand(1000, 5000), 2) }}</td>
                                <td class="px-4 py-3">{{ now()->addMonths($index)->format('d M Y') }}</td>
                                <td class="px-4 py-3">Memo {{ $index }}</td>
                                <td class="px-4 py-3">INV-{{ rand(1000, 9999) }}</td>
                                <td class="px-4 py-3">{{ now()->subDays($index * 2)->format('d M Y') }}</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">{{ rand(0, 1) ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-3">{{ rand(10000, 99999) }}</td>
                                <td class="px-4 py-3">Memo {{ $index }}</td>
                                <td class="px-4 py-3">Receipt {{ $index }}</td>
                                <td class="px-4 py-3">REC-{{ rand(1000, 9999) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
