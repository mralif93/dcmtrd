<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales & Marketing Dashboard') }}
        </h2>
    </x-slot>

    @if(Auth::user()->hasPermission('SALES'))
    <div class="hidden py-12 dashboard-section" id="legal-section" data-section="legal">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Sales & Marketing Information</p>
        </div>
    </div>
    @endif
</x-app-layout>