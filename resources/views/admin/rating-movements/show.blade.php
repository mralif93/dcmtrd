<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rating Movement Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="border-t border-gray-200">
                    <dl class="space-y-6 px-4 py-5 sm:p-6">
                        <!-- Row 1: Bond -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Bond Information</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ratingMovement->bond->bond_sukuk_name }} - {{ $ratingMovement->bond->isin_code }}
                            </dd>
                        </div>

                        <!-- Row 2: Rating Agency & Rating Tenure -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rating Agency</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ratingMovement->rating_agency }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rating Tenure</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ratingMovement->rating_tenure }}</dd>
                            </div>
                        </div>

                        <!-- Row 3: Effective Date & Rating -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Effective Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $ratingMovement->effective_date->format('d M Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rating</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                        {{ $ratingMovement->rating }}
                                    </span>
                                </dd>
                            </div>
                        </div>

                        <!-- Row 4: Rating Action & Rating Outlook -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rating Action</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        {{ $ratingMovement->rating_action === 'Upgrade' ? 'bg-green-100 text-green-800' : 
                                        ($ratingMovement->rating_action === 'Downgrade' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $ratingMovement->rating_action }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rating Outlook</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        {{ $ratingMovement->rating_outlook === 'Positive' ? 'bg-green-100 text-green-800' : 
                                        ($ratingMovement->rating_outlook === 'Negative' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $ratingMovement->rating_outlook }}
                                    </span>
                                </dd>
                            </div>
                        </div>

                        <!-- Row 5: Rating Watch -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Rating Watch</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($ratingMovement->rating_watch)
                                <span class="px-2 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                    {{ $ratingMovement->rating_watch }}
                                </span>
                                @else
                                <span class="text-gray-500">N/A</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ratingMovement->created_at->format('d/m/Y h:i A') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ratingMovement->updated_at->format('d/m/Y h:i A') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('rating-movements.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('rating-movements.edit', $ratingMovement) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Rating
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>