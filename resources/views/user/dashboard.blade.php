<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('DCMTRD') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Issuers -->
                <x-dashboard-card
                    title="Issuers"
                    icon="office-building"
                    :count="$issuersCount"
                    :href="route('issuers-info.index')"
                    color="bg-blue-100"
                />

                <!-- Bonds -->
                <x-dashboard-card
                    title="Bonds"
                    icon="banknotes"
                    :count="$bondsCount"
                    :href="route('bonds-info.index')"
                    color="bg-blue-100"
                />

                <!-- Rating Movements -->
                <x-dashboard-card
                    title="Rating Movements"
                    icon="trending-up"
                    :count="$ratingMovementsCount"
                    :href="route('rating-movements-info.index')"
                    color="bg-blue-100"
                />

                <!-- Payment Schedules -->
                <x-dashboard-card
                    title="Payment Schedules"
                    icon="currency-dollar"
                    :count="$paymentSchedulesCount"
                    :href="route('payment-schedules-info.index')"
                    color="bg-blue-100"
                />

                <!-- Redemptions -->
                <x-dashboard-card
                    title="Redemptions"
                    icon="arrow-path"
                    :count="$redemptionsCount"
                    :href="route('redemptions-info.index')"
                    color="bg-blue-100"
                />

                <!-- Call Schedules -->
                <x-dashboard-card
                    title="Call Schedules"
                    icon="phone-outgoing"
                    :count="$callSchedulesCount"
                    :href="route('call-schedules-info.index')"
                    color="bg-blue-100"
                />

                <!-- Lockout Periods -->
                <x-dashboard-card
                    title="Lockout Periods"
                    icon="lock-closed"
                    :count="$lockoutPeriodsCount"
                    :href="route('lockout-periods-info.index')"
                    color="bg-blue-100"
                />

                <!-- Trading Activities -->
                <x-dashboard-card
                    title="Trading Activities"
                    icon="chart-bar"
                    :count="$tradingActivitiesCount"
                    :href="route('trading-activities-info.index')"
                    color="bg-blue-100"
                />

                <!-- Announcements -->
                <x-dashboard-card
                    title="Announcements"
                    icon="megaphone"
                    :count="$announcementsCount"
                    :href="route('announcements-info.index')"
                    color="bg-blue-100"
                />

                <!-- Facility Information -->
                <x-dashboard-card
                    title="Facility Information"
                    icon="information-circle"
                    :count="$facilityInformationsCount"
                    :href="route('facility-informations-info.index')"
                    color="bg-blue-100"
                />

                <!-- Related Documents & Financials -->
                <x-dashboard-card
                    title="Related Documents & Financials"
                    icon="folder-open"
                    :count="$relatedDocumentsCount"
                    :href="route('related-documents-info.index')"
                    color="bg-blue-100"
                />

                <!-- Charts -->
                <x-dashboard-card
                    title="Charts"
                    icon="presentation-chart-line"
                    :count="$chartsCount"
                    :href="route('charts-info.index')"
                    color="bg-blue-100"
                />
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Real Estate Investment Trusts (REITs)') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
            </div>
        </div>
    </div>
</x-app-layout>
