<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Dashboard') }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('main') }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </x-slot>

    @if (Auth::user()->hasPermission('DCMTRD'))
        <div class="py-12">
            <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">

                @if (session('success'))
                    <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">
                        <!-- Search Form -->
                        <div class="p-6">
                            <form action="{{ route('issuer-search.index') }}" method="GET">
                                <div class="flex gap-2">
                                    <input type="text" name="search" value="{{ $searchTerm }}"
                                        placeholder="Search by title, category, or issuer..."
                                        class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">

                                    <button type="submit"
                                        class="px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                        Search
                                    </button>

                                    @if ($searchTerm)
                                        <a href="{{ route('issuer-search.index') }}"
                                            class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                                            Clear
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>


                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-300 rounded-lg shadow-sm">
                                <thead class="bg-gray-100 border-b border-gray-300">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-left text-gray-700">Issuer Short
                                            Name</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-left text-gray-700">Issuer Name
                                        </th>
                                        <th class="px-4 py-3 text-sm font-semibold text-left text-gray-700">Registration
                                            Number</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($issuers as $issuer)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $issuer->issuer_short_name }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                <a href="{{ route('issuer-search.show', $issuer) }}"
                                                    class="text-indigo-600 hover:underline">
                                                    {{ $issuer->issuer_name }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ $issuer->registration_number }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-sm text-center text-gray-500">No
                                                issuers found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>


                        @if ($issuers->hasPages())
                            <div class="p-6">
                                {{ $issuers->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- @if (Auth::user()->hasPermission('REITS'))
        <div class="hidden py-12 dashboard-section" id="reits-section" data-section="reits">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="pb-6">
                    <h2 class="text-xl font-bold leading-tight text-gray-800">
                        {{ __('Real Estate Investment Trusts (REITs)') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Portfolios -->
                    <x-dashboard-card title="Portfolios" icon="briefcase" :count="$portfoliosCount" :href="route('portfolios-info.index')"
                        color="bg-green-100" />

                    <!-- Properties -->
                    <x-dashboard-card title="Properties" icon="home" :count="$propertiesCount" :href="route('properties-info.index')"
                        color="bg-green-100" />

                    <!-- Tenants -->
                    <x-dashboard-card title="Tenants" icon="users" :count="$tenantsCount" :href="route('tenants-info.index')"
                        color="bg-green-100" />

                    <!-- Leases -->
                    <x-dashboard-card title="Leases" icon="document-text" :count="$leasesCount" :href="route('leases-info.index')"
                        color="bg-green-100" />

                    <!-- Checklists -->
                    <x-dashboard-card title="Checklists" icon="clipboard-check" :count="$checklistsCount" :href="route('checklists-info.index')"
                        color="bg-green-100" />

                    <!-- Financials -->
                    <x-dashboard-card title="Financials" icon="currency-dollar" :count="$financialsCount" :href="route('financials-info.index')"
                        color="bg-green-100" />

                    <!-- Site Visits -->
                    <x-dashboard-card title="Site Visits" icon="location-marker" :count="$siteVisitsCount" :href="route('site-visits-info.index')"
                        color="bg-green-100" />

                    <!-- Documentation Items -->
                    <x-dashboard-card title="Documentation Items" icon="document-duplicate" :count="$documentationItemsCount"
                        :href="route('documentation-items-info.index')" color="bg-green-100" />

                    <!-- Tenant Approvals -->
                    <x-dashboard-card title="Tenant Approvals" icon="shield-check" :count="$tenantApprovalsCount" :href="route('tenant-approvals-info.index')"
                        color="bg-green-100" />

                    <!-- Condition Checks -->
                    <x-dashboard-card title="Condition Checks" icon="clipboard-check" :count="$conditionChecksCount"
                        :href="route('condition-checks-info.index')" color="bg-green-100" />

                    <!-- Property Improvements -->
                    <x-dashboard-card title="Property Improvements" icon="home-modern" :count="$propertyImprovementsCount"
                        :href="route('property-improvements-info.index')" color="bg-green-100" />
                </div>
            </div>
        </div>
    @endif --}}

    {{-- @if (Auth::user()->hasPermission('LEGAL'))
        <div class="hidden py-12 dashboard-section" id="legal-section" data-section="legal">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="pb-6">
                    <h2 class="text-xl font-bold leading-tight text-gray-800">
                        {{ __('Legal Department') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Site Visits -->
                    <x-dashboard-card title="Site Visits" icon="location-marker" :count="$siteVisitsCount" :href="route('site-visits-info.index')"
                        color="bg-purple-100" />

                    <!-- Checklists -->
                    <x-dashboard-card title="Checklists" icon="clipboard-check" :count="$checklistsCount" :href="route('checklists-info.index')"
                        color="bg-purple-100" />
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->hasPermission('COMPLIANCE'))
        <div class="hidden py-12 dashboard-section" id="compliance-section" data-section="compliance">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="pb-6">
                    <h2 class="text-xl font-bold leading-tight text-gray-800">
                        {{ __('Compliance Management') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Site Visits -->
                    <x-dashboard-card title="Site Visits" icon="location-marker" :count="$siteVisitsCount" :href="route('site-visits-info.index')"
                        color="bg-red-100" />

                    <!-- Checklists -->
                    <x-dashboard-card title="Checklists" icon="clipboard-check" :count="$checklistsCount" :href="route('checklists-info.index')"
                        color="bg-red-100" />
                </div>
            </div>
        </div>
    @endif --}}

    <!-- If the user has no permissions, show a message -->
    @if (
        !Auth::user()->hasPermission('DCMTRD') &&
            !Auth::user()->hasPermission('REITS') &&
            !Auth::user()->hasPermission('LEGAL') &&
            !Auth::user()->hasPermission('COMPLIANCE'))
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('No Access') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('You do not have permission to access any modules.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- JavaScript for handling section display -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the section parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get('section');

            // Initially hide the default message (will show it if no valid section is found)
            const defaultMessage = document.getElementById('default-message');

            // Select all section elements
            const sections = document.querySelectorAll('.dashboard-section');

            // If a section parameter is present
            if (section) {
                // Find the target section
                const targetSection = document.querySelector(`[data-section="${section}"]`);

                if (targetSection) {
                    // Hide default message
                    if (defaultMessage) {
                        defaultMessage.classList.add('hidden');
                    }

                    // Show only the target section
                    targetSection.classList.remove('hidden');
                } else {
                    // If no valid section was found, show the default message
                    if (defaultMessage) {
                        defaultMessage.classList.remove('hidden');
                    }
                }
            } else {
                // If no section parameter, show the default message
                if (defaultMessage) {
                    defaultMessage.classList.remove('hidden');
                }
            }
        });
    </script>
</x-app-layout>
