<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (Auth::user()->permission == 'DCMTRD')
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between pb-6">
                    <h2 class="text-xl font-bold leading-tight text-gray-800">
                        {{ __('Debt Capital Market Trust (DCMT)') }}
                    </h2>

                </div>

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

                    <!-- Issuers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Issuer Short Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Issuer Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Registration Number
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($issuers as $issuer)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $issuer->issuer_short_name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                            <a href="{{ route('issuer-search.show', $issuer) }}">
                                                {{ $issuer->issuer_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $issuer->registration_number }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                            No issuers found
                                        </td>
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
    @endif

    @if (Auth::user()->permission == 'REITS')
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="pb-6">
                    <h2 class="text-xl font-bold leading-tight text-gray-800">
                        {{ __('Real Estate Investment Trusts (REITs)') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Portfolios -->
                    <x-dashboard-card title="Portfolios" icon="briefcase" :count="$portfoliosCount" :href="route('portfolios-info.index')"
                        color="bg-blue-100" />

                    <!-- Properties -->
                    <x-dashboard-card title="Properties" icon="home" :count="$propertiesCount" :href="route('properties-info.index')"
                        color="bg-blue-100" />

                    <!-- Tenants -->
                    <x-dashboard-card title="Tenants" icon="users" :count="$tenantsCount" :href="route('tenants-info.index')"
                        color="bg-blue-100" />

                    <!-- Leases -->
                    <x-dashboard-card title="Leases" icon="document-text" :count="$leasesCount" :href="route('leases-info.index')"
                        color="bg-blue-100" />

                    <!-- Checklists -->
                    <x-dashboard-card title="Checklists" icon="clipboard-check" :count="$checklistsCount" :href="route('checklists-info.index')"
                        color="bg-blue-100" />

                    <!-- Financials -->
                    <x-dashboard-card title="Financials" icon="currency-dollar" :count="$financialsCount" :href="route('financials-info.index')"
                        color="bg-blue-100" />

                    <!-- Site Visits -->
                    <x-dashboard-card title="Site Visits" icon="location-marker" :count="$siteVisitsCount" :href="route('site-visits-info.index')"
                        color="bg-blue-100" />

                    <!-- Documentation Items -->
                    <x-dashboard-card title="Documentation Items" icon="document-duplicate" :count="$documentationItemsCount"
                        :href="route('documentation-items-info.index')" color="bg-blue-100" />

                    <!-- Tenant Approvals -->
                    <x-dashboard-card title="Tenant Approvals" icon="shield-check" :count="$tenantApprovalsCount" :href="route('tenant-approvals-info.index')"
                        color="bg-blue-100" />

                    <!-- Condition Checks -->
                    <x-dashboard-card title="Condition Checks" icon="clipboard-check" :count="$conditionChecksCount"
                        :href="route('condition-checks-info.index')" color="bg-blue-100" />

                    <!-- Property Improvements -->
                    <x-dashboard-card title="Property Improvements" icon="home-modern" :count="$propertyImprovementsCount"
                        :href="route('property-improvements-info.index')" color="bg-blue-100" />
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
