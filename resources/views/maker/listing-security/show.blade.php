<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('list-security-request-m.show') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 bg-green-100 border-l-4 border-green-500 rounded-md shadow-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="p-8 bg-white border border-gray-200 shadow-md rounded-xl">
                <h3 class="mb-6 text-2xl font-semibold text-gray-800">Security Document Request</h3>

                @if ($security)
                    <dl class="grid grid-cols-1 gap-6 text-sm sm:grid-cols-2">
                        <div class="flex flex-col">
                            <dt class="text-gray-500">Security</dt>
                            <dd class="font-medium text-gray-900">{{ $security->listSecurity->security_name }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-gray-500">Purpose</dt>
                            <dd class="font-medium text-gray-900">{{ $security->purpose }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-gray-500">Request Date</dt>
                            <dd class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($security->request_date)->format('Y-m-d') }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-gray-500">Request By (Legal Department)</dt>
                            <dd class="font-medium text-gray-900">{{ $security->prepared_by }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-gray-500">Status</dt>
                            <dd>
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($security->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif ($security->status === 'Returned') bg-blue-100 text-blue-800
                                    @elseif ($security->status === 'Withdrawal') bg-red-100 text-red-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $security->status }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:space-x-4">
                            <div class="flex flex-col">
                                <dt class="text-gray-500">Withdrawal Date</dt>
                                <dd class="font-medium text-gray-900">
                                    {{ $security->withdrawal_date ? \Carbon\Carbon::parse($security->withdrawal_date)->format('Y-m-d') : 'N/A' }}
                                </dd>
                            </div>

                            <div class="flex flex-col">
                                <dt class="text-gray-500">Return Date</dt>
                                <dd class="font-medium text-gray-900">
                                    {{ $security->return_date ? \Carbon\Carbon::parse($security->return_date)->format('Y-m-d') : 'N/A' }}
                                </dd>
                            </div>
                        </div>

                    </dl>
                @else
                    <div class="mt-6 text-center text-gray-500">
                        No security document request found.
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal --}}
        <div id="withdrawModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/50">
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">Schedule Document Dispatch</h2>
                <p class="mb-4 text-sm text-gray-600">
                    Please specify the date when the document should be sent to the Legal department.
                </p>

                <div class="mb-4">
                    <label for="withdrawDate" class="block mb-1 text-sm font-medium text-gray-700">Send Date</label>
                    <input type="date" id="withdrawDate" name="withdrawDate"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex justify-end space-x-3">
                    <button id="cancelModal"
                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button id="confirmWithdraw"
                        class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                        Send to Legal
                    </button>
                </div>
            </div>
        </div>

        {{-- Return Modal --}}
        <div id="returnModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/50">
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">Confirm Document Return</h2>
                <p class="mb-4 text-sm text-gray-600">
                    Please specify the date the document was received back from the Legal department.
                </p>

                <div class="mb-4">
                    <label for="returnDate" class="block mb-1 text-sm font-medium text-gray-700">Return Date</label>
                    <input type="date" id="returnDate" name="returnDate"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div class="flex justify-end space-x-3">
                    <button id="cancelReturnModal"
                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button id="confirmReturn"
                        class="px-4 py-2 text-sm text-white bg-yellow-600 rounded hover:bg-yellow-700">
                        Confirm Return
                    </button>
                </div>
            </div>
        </div>





    </div>

    <script>
        // Show the modal
        function openWithdrawModal() {
            const modal = document.getElementById('withdrawModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Hide the modal
        function closeWithdrawModal() {
            const modal = document.getElementById('withdrawModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Show the modal
        function openReturnModal() {
            const modal = document.getElementById('returnModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Hide the modal
        function closeReturnModal() {
            const modal = document.getElementById('returnModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Handle confirm button click
        function handleWithdraw() {
            console.log('Withdraw button clicked');
            const withdrawDate = document.getElementById('withdrawDate').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!withdrawDate) {
                alert('Please select a date.');
                return;
            }

            // Get the security ID from the Blade template
            const securityId = "{{ $security->id }}";

            fetch(`/maker/list-security/${securityId}/send-documents`, { // Using the security ID in the URL
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        withdraw_date: withdrawDate,
                    }),
                })
                .then(response => {
                    // Check for response status
                    if (response.ok) {
                        return response.json(); // Parse the JSON
                    } else {
                        return response.text().then(text => {
                            throw new Error(text); // If not JSON, throw an error with the response text
                        });
                    }
                })
                .then(data => {
                    console.log('Success:', data);
                    location.reload(); // Or redirect
                })
                .catch(error => {
                    alert(error.message);
                });

        }

        // Handle confirm button click
        function handleReturn() {
            console.log('Return button clicked');
            const returnDate = document.getElementById('returnDate').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!returnDate) {
                alert('Please select a date.');
                return;
            }

            // Get the security ID from the Blade template
            const securityId = "{{ $security->id }}";

            fetch(`/maker/list-security/${securityId}/return-documents`, { // Using the security ID in the URL
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        return_date: returnDate,
                    }),
                })
                .then(response => {
                    // Check for response status
                    if (response.ok) {
                        return response.json(); // Parse the JSON
                    } else {
                        return response.text().then(text => {
                            throw new Error(text); // If not JSON, throw an error with the response text
                        });
                    }
                })
                .then(data => {
                    console.log('Success:', data);
                    location.reload(); // Or redirect
                })
                .catch(error => {
                    alert(error.message);
                });

        }

        // Attach event listeners
        document.getElementById('withdrawButton').addEventListener('click', openWithdrawModal);
        document.getElementById('returnButton').addEventListener('click', openReturnModal);
        document.getElementById('cancelModal').addEventListener('click', closeWithdrawModal);
        document.getElementById('cancelReturnModal').addEventListener('click', closeReturnModal);
        document.getElementById('confirmWithdraw').addEventListener('click', handleWithdraw);
        document.getElementById('confirmReturn').addEventListener('click', handleReturn);
    </script>





</x-app-layout>
