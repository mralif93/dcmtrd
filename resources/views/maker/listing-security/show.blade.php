<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ url()->previous() }}"
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
                            <dt class="text-gray-500">Status</dt>
                            <dd>
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($security->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif ($security->status === 'Returned') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $security->status }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    {{-- Action buttons --}}
                    <div class="flex flex-col mt-8 space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                        {{-- Withdraw Request --}}
                        <form method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Withdraw Request
                            </button>
                        </form>

                        {{-- Return Request --}}
                        <form  method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                Return Request
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-6 text-center text-gray-500">
                        No security document request found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
