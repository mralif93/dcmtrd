<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Notification Details') }}
            </h2>
            <a href="{{ route('notification-a.index') }}"
                class="inline-flex items-center px-4 py-2 text-xs font-medium tracking-widest text-gray-700 uppercase bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Notifications
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Details</h3>
                        <p class="text-gray-600">This feature will be implemented to show individual notification details.</p>
                        <p class="text-gray-600 mt-2">For now, please use the notification index page to view all notifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
