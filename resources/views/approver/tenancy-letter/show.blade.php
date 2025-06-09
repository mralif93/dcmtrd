<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Buttons (Back, Edit and Print in one line) -->
                    <div class="print-controls mb-4 flex justify-end space-x-4">
                        <a href="{{ route('lease-a.show', $tenancyLetter->lease) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-arrow-left mr-2"></i> Back to Lease
                        </a>
                        <a href="{{ route('tenancy-letter-m.edit', $tenancyLetter) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-edit mr-2"></i> Edit Document
                        </a>
                        <button id="printButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-print mr-2"></i> Print Document
                        </button>
                    </div>
                    
                    <!-- Document Content -->
                    <div id="printableArea" class="bg-white document">
                        <!-- Space for ART Letter Head -->
                        <div style="height: 80px; margin-bottom: 10px;">
                            <!-- ART Letter Head will be here -->
                        </div>
                        
                        <!-- Reference Section -->
                        <div style="margin-bottom: 20px;">
                            <table class="w-full" style="border-collapse: collapse;">
                                <tr>
                                    <td width="80">Your Ref.</td>
                                    <td width="10">:</td>
                                    <td>{{ $tenancyLetter->your_reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Our Ref.</td>
                                    <td>:</td>
                                    <td>{{ $tenancyLetter->our_reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>:</td>
                                    <td>{{ $tenancyLetter->letter_date ? $tenancyLetter->letter_date->format('d F Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Recipient Info Section -->
                        <div style="margin-bottom: 20px;">
                            <div class="font-bold">{{ strtoupper($tenancyLetter->recipient_company) ?? 'N/A' }}</div>
                            <div>{{ $tenancyLetter->recipient_address_line_1 ?? 'N/A' }}</div>
                            <div>{{ $tenancyLetter->recipient_address_line_2 ?? 'N/A' }}</div>
                            @if($tenancyLetter->recipient_address_line_3)
                                <div>{{ $tenancyLetter->recipient_address_line_3 }}</div>
                            @endif
                            <div>{{ $tenancyLetter->recipient_address_postcode ?? 'N/A' }} {{ $tenancyLetter->recipient_address_city ?? 'N/A' }}</div>
                            <div>{{ $tenancyLetter->recipient_address_state ?? 'N/A' }}, {{ $tenancyLetter->recipient_address_country ?? 'N/A' }}</div>
                        </div>
                        
                        <!-- Greeting -->
                        <div style="margin-bottom: 20px;">Dear Sir,</div>
                        
                        <!-- Subject Section -->
                        <div style="margin-bottom: 20px;">
                            <div class="font-bold" style="text-decoration: underline;">{{ strtoupper($tenancyLetter->lease->tenant->property->portfolio->portfolio_name) ?? 'N/A' }} REAL ESTATE INVESTMENT TRUST ("{{ strtoupper($tenancyLetter->lease->tenant->property->portfolio->portfolio_name) ?? 'N/A' }} REIT")</div>
                            <div class="font-bold" style="text-decoration: underline;">{{ strtoupper($tenancyLetter->lease->tenancy_type) ?? 'N/A' }}</div>
                        </div>
                        
                        <!-- Main Content -->
                        <div style="margin-bottom: 20px;">
                            <div>The above matter refers.</div>
                            <div style="margin-top: 15px;">We, AmanahRaya Trustees Berhad, as Trustee to {{ $tenancyLetter->lease->tenant->property->portfolio->portfolio_name ?? 'N/A' }} REIT hereby approve of the above-mentioned Demised Premises with following details:</div>
                        </div>
                        
                        <!-- Details Table -->
                        <div style="margin-bottom: 20px;">
                            <table class="w-full" style="border-collapse: collapse;">
                                <tr>
                                    <td width="150" style="padding: 5px 0;">Tenant</td>
                                    <td width="10">:</td>
                                    <td style="padding: 5px 0;">{{ strtoupper($tenancyLetter->lease->tenant->name) ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0;">Demised Details</td>
                                    <td>:</td>
                                    <td style="padding: 5px 0;">{{ $tenancyLetter->lease->demised_premises ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0;">Permitted Use</td>
                                    <td>:</td>
                                    <td style="padding: 5px 0;">{{ $tenancyLetter->lease->permitted_use ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0;">Lettable Floor Area (sq. ft)</td>
                                    <td>:</td>
                                    <td style="padding: 5px 0;">{{ $tenancyLetter->lease->space ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0; vertical-align: top;">Rental</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td style="padding: 5px 0;">
                                        @if($tenancyLetter->lease->monthly_gsto_year_1)
                                            Year 1 - Base Rent of RM {{ number_format($tenancyLetter->lease->base_rate_year_1, 2) }} per square foot per month or {{ $tenancyLetter->lease->monthly_gsto_year_1 }}% of monthly GSTO, {{ $tenancyLetter->lease->remarks_year_1 }}<br>
                                        @endif
                                        @if($tenancyLetter->lease->monthly_gsto_year_2)
                                            Year 2 - Base Rent of RM {{ number_format($tenancyLetter->lease->base_rate_year_2, 2) }} per square foot per month or {{ $tenancyLetter->lease->monthly_gsto_year_2 }}% of monthly GSTO, {{ $tenancyLetter->lease->remarks_year_2 }}<br>
                                        @endif
                                        @if($tenancyLetter->lease->monthly_gsto_year_3)
                                            Year 3 - Base Rent of RM {{ number_format($tenancyLetter->lease->base_rate_year_3, 2) }} per square foot per month or {{ $tenancyLetter->lease->monthly_gsto_year_3 }}% of monthly GSTO, {{ $tenancyLetter->lease->remarks_year_3 }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0;">Letter of Offer</td>
                                    <td>:</td>
                                    <td style="padding: 5px 0;">{{ $tenancyLetter->letter_offer_date ? $tenancyLetter->letter_offer_date->format('d F Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0;">Supplemental Letter of Offer</td>
                                    <td>:</td>
                                    <td style="padding: 5px 0;">{{ $tenancyLetter->supplemental_letter_offer_date ? $tenancyLetter->supplemental_letter_offer_date->format('d F Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Final Content -->
                        <div style="margin-bottom: 30px;">
                            <div>The above approval is subject to the terms and conditions specified in the Letter of Offer dated and Supplemental Letter of Offer mentioned above.</div>
                            <div style="margin-top: 15px;">Thank you.</div>
                        </div>
                        
                        <!-- Signature Section -->
                        <div>
                            <div>Yours faithfully</div>
                            <div class="font-bold">AMANAHRATA TRUSTEES BERHAD</div>
                            <div style="height: 60px;"></div>
                            <div class="font-bold">{{ strtoupper($tenancyLetter->approver_name) ?? 'N/A' }}</div>
                            <div>{{ ucfirst($tenancyLetter->approver_position) ?? 'N/A' }}</div>
                            <div>{{ ucfirst($tenancyLetter->approver_department) ?? 'N/A' }}</div>
                        </div>
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
            line-height: 1.4;
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
    
    <!-- Add Font Awesome for the icons -->
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
