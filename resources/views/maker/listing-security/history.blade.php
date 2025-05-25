<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Security Request History for: {{ $security->security_name }}
            </h2>
            <a href="{{ route('list-security-m.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @if ($history->isEmpty())
                        <p class="text-sm text-gray-600">No history found for this security.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">No.
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Date
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Purpose</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Status</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Withdrawn Date</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Returned Date</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Prepared By</th>
                                        <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($history as $index => $request)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ $request->request_date }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ $request->purpose }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                                @if ($request->status == 'Active')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                                        Active
                                                    </span>
                                                @elseif ($request->status == 'Draft')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                                        Draft
                                                    </span>
                                                @elseif ($request->status == 'Pending')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full">
                                                        Pending
                                                    </span>
                                                @elseif ($request->status == 'Completed')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                                        Completed
                                                    </span>
                                                @elseif ($request->status == 'Withdrawal')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                                        Withdrawal
                                                    </span>
                                                @elseif ($request->status == 'Return')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full">
                                                        Return
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded-full">
                                                        N/A
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ $request->withdrawal_date ? \Carbon\Carbon::parse($request->withdrawal_date)->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ $request->return_date ? \Carbon\Carbon::parse($request->return_date)->format('Y-m-d') : 'N/A' }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ $request->prepared_by }}</td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                @if ($request->status == 'Draft' && $request->prepared_by == auth()->user()->name)
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('maker.request-documents.edit', $request->id) }}"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                                        ✏️ Edit
                                                    </a>

                                                    <!-- Submit Button -->
                                                    <form method="POST"
                                                        action="{{ route('maker.request-documents.submit', $request->id) }}"
                                                        class="inline-block ml-2"
                                                        onsubmit="return confirm('Are you sure you want to submit this request?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-green-500 rounded hover:bg-green-600">
                                                            📝 Submit
                                                        </button>
                                                    </form>
                                                @elseif ($request->status == 'Pending')
                                                    <!-- Waiting Message -->
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-500 bg-gray-200 rounded">
                                                        ⏳ Waiting
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
