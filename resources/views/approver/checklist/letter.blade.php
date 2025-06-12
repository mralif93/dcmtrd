<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Print and Back Buttons -->
                    <div class="print-controls mb-4 flex justify-between">
                        <a href="{{ route('checklist-a.index', $checklist->siteVisit->property) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-arrow-left mr-2"></i> Back
                        </a>
                        <button id="printButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-print mr-2"></i> Print Checklist
                        </button>
                    </div>
                    
                    <!-- Document Content -->
                    <div id="printableArea" class="bg-white document">
                        <table class="w-full" style="border-collapse: collapse;">
                            <!-- Header -->
                            <tr>
                                <td style="text-align: right; padding-bottom: 15px;">
                                    <span style="font-weight: bold;">Annexure 1</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; padding-bottom: 20px;">
                                    <span style="font-weight: bold;">SITE VISIT CHECKLIST</span>
                                </td>
                            </tr>
                            
                            <!-- Property Info -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="padding-bottom: 5px;">Property: <strong>{{ $checklist->siteVisit->property->name ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">Property Address: <strong>{{ $checklist->siteVisit->property->getFullAddressAttribute() ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">Date of Site Visit: <strong>
                                                @if(isset($checklist->siteVisit->date_visit))
                                                    {{ $checklist->siteVisit->date_visit instanceof \Carbon\Carbon 
                                                        ? $checklist->siteVisit->date_visit->format('d/m/Y') 
                                                        : date('d/m/Y', strtotime($checklist->siteVisit->date_visit)) }}
                                                @else
                                                    N/A
                                                @endif
                                            </strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">Time of Visit: <strong>
                                                @if(isset($checklist->siteVisit->time_visit))
                                                    {{ $checklist->siteVisit->time_visit instanceof \Carbon\Carbon 
                                                        ? $checklist->siteVisit->time_visit->format('h:i A') 
                                                        : date('h:i A', strtotime($checklist->siteVisit->time_visit)) }}
                                                @else
                                                    N/A
                                                @endif
                                            </strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">Representative from:</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">1) Trustee: <strong>{{ $checklist->siteVisit->trustee ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">2) Manager: <strong>{{ $checklist->siteVisit->manager ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">3) Maintenance Manager: <strong>{{ $checklist->siteVisit->maintenance_manager ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px;">4) Building Manager: <strong>{{ $checklist->siteVisit->building_manager ?? 'N/A' }}</strong></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Section 1: Legal Documentation -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse; border: 1px solid #ccc;">
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 7%;">No.</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 38%;">Items</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 30%;">Validity/Expiry Date</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 25%;">Location</th>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center; font-weight: bold;">1.0</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; font-weight: bold;">Legal Documentation</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.1</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Title</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->title_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->title_location ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.2</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Trust Deed/ Restated Trust Deed/Deed</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->trust_deed_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->trust_deed_location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.3</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Sale and Purchase Agreement</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->sale_purchase_agreement_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->sale_purchase_agreement_location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.4</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Lease Agreement</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->lease_agreement_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->lease_agreement_location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.5</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Agreement to Lease</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->agreement_to_lease_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->agreement_to_lease_location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.6</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Maintenance Manager Agreement/Property Maintenance Agreement (Fire Injection Maintenance Management Agreement)</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->maintenance_agreement_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->maintenance_agreement_location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.7</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Development Agreement</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->development_agreement_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->development_agreement_location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1.8</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Others</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->others_ref ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->legalDocumentation->others_location ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Tenant List Table -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse; border: 1px solid #ccc;">
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center; font-weight: bold;">2.0</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; font-weight: bold;" colspan="4">Tenancy Agreement</td>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 7%;">No.</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 38%;">List of Tenant (Name & Property)</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 20%;">Date of Approval</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 20%;">Commencement Tenancy</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 15%;">Expiry</th>
                                        </tr>
                                        @if (isset($checklist->tenants) && $checklist->tenants->count() > 0)
                                            <!-- Tenants -->
                                            @foreach ($checklist->tenants as $tenant)
                                                <tr>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $loop->iteration }}.</td>
                                                    <td style="border: 1px solid #ccc; padding: 5px;">{{ $tenant->name ?? 'N/A' }} ({{ $tenant->property->name ?? 'N/A' }})</td>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                                                        @if(isset($tenant->approval_date))
                                                            {{ $tenant->approval_date instanceof \Carbon\Carbon 
                                                                ? $tenant->approval_date->format('d/m/Y') 
                                                                : date('d/m/Y', strtotime($tenant->approval_date)) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                                                        @if(isset($tenant->commencement_date))
                                                            {{ $tenant->commencement_date instanceof \Carbon\Carbon 
                                                                ? $tenant->commencement_date->format('d/m/Y') 
                                                                : date('d/m/Y', strtotime($tenant->commencement_date)) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                                                        @if(isset($tenant->expiry_date))
                                                            {{ $tenant->expiry_date instanceof \Carbon\Carbon 
                                                                ? $tenant->expiry_date->format('d/m/Y') 
                                                                : date('d/m/Y', strtotime($tenant->expiry_date)) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <!-- If no tenants -->
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">1</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;" colspan="4">Nil</td>
                                        </tr>
                                        @endif
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Notes -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <p style="font-style: italic; font-size: 9px;">*Note:</p>
                                    <p style="font-style: italic; font-size: 9px; margin-left: 20px;">i. Item 1.0 to be filled up by Legal Department ("LD") before conducting the site visit</p>
                                    <p style="font-style: italic; font-size: 9px; margin-left: 20px;">ii. Item 2.0 enclosed on Approval of New Tenancy/Renewal of Tenancy issued by Operation Department ("OD"). The list to be filled up by OD and to be verified by LD (LD to response not later than three (3) working days from the receipt of the checklist)</p>
                                </td>
                            </tr>
                            
                            <!-- Condition Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse; border: 1px solid #ccc;">
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 7%;">No.</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 38%;">Items</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 15%;" colspan="2">Condition</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 40%;">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2;"></th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2;"></th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 10%;">Satisfied</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 10%;">Not Satisfied</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2;"></th>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center; font-weight: bold;">3.0</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; font-weight: bold;">External Area</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.1</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">General Cleanliness</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_general_cleanliness_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_general_cleanliness_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->general_cleanliness_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.2</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Fencing & Main Gate</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_fencing_gate_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_fencing_gate_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->fencing_gate_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.3</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">External Facade</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_external_facade_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_external_facade_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->external_facade_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.4</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Car park</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_car_park_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_car_park_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->car_park_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.5</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Land settlement</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_land_settlement_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_land_settlement_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->land_settlement_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.6</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Rooftop</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_rooftop_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_rooftop_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->rooftop_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">3.7</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Drainage</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_drainage_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->externalAreaCondition->is_drainage_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->externalAreaCondition->drainage_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center; font-weight: bold;">4.0</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; font-weight: bold;">Internal Area</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.1</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Door & window</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_door_window_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_door_window_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->door_window_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.2</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Staircase</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_staircase_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_staircase_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->staircase_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.3</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Toilet</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_toilet_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_toilet_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->toilet_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.4</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Ceiling</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_ceiling_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_ceiling_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->ceiling_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.5</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Wall</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_wall_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_wall_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->wall_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.6</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Water Seeping/Leaking</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_water_seeping_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_water_seeping_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->water_seeping_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.7</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Loading Bay</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_loading_bay_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_loading_bay_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->loading_bay_remarks ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">4.8</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Basement Car Park</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_basement_car_park_satisfied ? '/' : '' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->internalAreaCondition->is_basement_car_park_satisfied ? '' : '/' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">{{ $checklist->internalAreaCondition->basement_car_park_remarks ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Property Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse; border: 1px solid #ccc;">
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 7%;">No.</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 38%;">Items</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 15%;">Date of Approval</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 25%;">Scope of Work</th>
                                            <th style="border: 1px solid #ccc; padding: 5px; text-align: center; background-color: #f2f2f2; width: 15%;">Status</th>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center; font-weight: bold;">5.0</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; font-weight: bold;">Property</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">5.1</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Development/Expansion</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ optional($checklist->propertyDevelopment)->development_date ? $checklist->propertyDevelopment->development_date->format('d/m/Y') : 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->propertyDevelopment->development_scope_of_work ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->propertyDevelopment->development_status ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">5.2</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Renovation</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ optional($checklist->propertyDevelopment)->renovation_date ? $checklist->propertyDevelopment->renovation_date->format('d/m/Y') : 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->propertyDevelopment->renovation_scope_of_work ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->propertyDevelopment->renovation_status ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">5.3</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">External Repainting</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ optional($checklist->propertyDevelopment)->external_repainting_date ? $checklist->propertyDevelopment->external_repainting_date->format('d/m/Y') : 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->propertyDevelopment->external_repainting_scope_of_work ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">{{ $checklist->propertyDevelopment->external_repainting_status ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">5.4</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Disposal/Installation/Replacement:</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                            <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                        </tr>
                                        @if ($checklist->disposalInstallation->count() > 0)
                                            @foreach ($checklist->disposalInstallation as $key => $disposal)
                                                <tr>
                                                    <td style="border: 1px solid #ccc; padding: 5px;"></td>
                                                    <td style="border: 1px solid #ccc; padding: 5px;">
                                                        {{ chr(97 + $key) }}) {{ $disposal->component_name ?? 'N/A' }}
                                                    </td>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                                                        {{ $disposal->component_date ? $disposal->component_date->format('d/m/Y') : 'N/A' }}
                                                    </td>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                                                        {{ $disposal->component_scope_of_work ?? 'N/A' }}
                                                    </td>
                                                    <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                                                        {{ ucfirst($disposal->component_status) ?? 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 5px; text-align: center;">5.5</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;">Other proposals/approvals</td>
                                            <td style="border: 1px solid #ccc; padding: 5px;" colspan="3">{{ $checklist->propertyDevelopment->others_proposals_approvals_scope_of_work ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Signatures -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 50%; padding-bottom: 10px;">Prepared by:</td>
                                            <td style="width: 50%; padding-bottom: 10px;">Confirmed by:</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 60px;">{{ $checklist->prepared_by ?? 'N/A' }}</td>
                                            <td style="padding-top: 60px;">{{ $checklist->verified_by ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date: 
                                                @if(isset($checklist->created_at))
                                                    {{ $checklist->created_at instanceof \Carbon\Carbon 
                                                        ? $checklist->created_at->format('d/m/Y') 
                                                        : date('d/m/Y', strtotime($checklist->created_at)) }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>Date: 
                                                @if(isset($checklist->approval_datetime))
                                                    {{ $checklist->approval_datetime instanceof \Carbon\Carbon 
                                                        ? $checklist->approval_datetime->format('d/m/Y') 
                                                        : date('d/m/Y', strtotime($checklist->approval_datetime)) }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Import Roboto font */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        
        /* Document styling */
        .document {
            margin: 0 auto;
            background: white;
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
            line-height: 1.5;
            padding: 30px;
        }
        
        table {
            width: 100%;
        }
        
        td {
            vertical-align: top;
        }
        
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }
            
            #printableArea, #printableArea * {
                visibility: visible;
            }
            
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            .print-controls {
                display: none;
            }
            
            /* A4 size for printing */
            @page {
                size: A4 portrait;
                margin: 0.5cm;
            }
        }
    </style>
    
    <!-- Add Font Awesome for the print icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Print JavaScript Function -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('printButton').addEventListener('click', function() {
                window.print();
            });
        });
    </script>
</x-app-layout>
