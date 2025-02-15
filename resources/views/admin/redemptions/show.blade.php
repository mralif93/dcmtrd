<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Redemption Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="mt-2 text-lg text-gray-600">{{ $redemption->bondInfo->isin_code }}</p>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('redemptions.edit', $redemption) }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('redemptions.destroy', $redemption) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
                                    onclick="return confirm('Delete this redemption configuration?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Core Information -->
                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Bond Information</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $redemption->bondInfo->isin_code }} ({{ $redemption->bondInfo->stock_code }})
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Call Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $redemption->last_call_date->format('d/m/Y') }}
                                </dd>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Partial Call</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        {{ $redemption->allow_partial_call ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $redemption->allow_partial_call ? 'Allowed' : 'Not Allowed' }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Redeem Nearest Denomination</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        {{ $redemption->redeem_nearest_denomination ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $redemption->redeem_nearest_denomination ? 'Yes' : 'No' }}
                                    </span>
                                </dd>
                            </div>
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
                                {{ $redemption->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $redemption->updated_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>