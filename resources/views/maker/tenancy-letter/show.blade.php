<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Buttons (Back, Edit and Print in one line) -->
                    <div class="print-controls mb-4 flex justify-end space-x-4">
                        <a href="{{ route('lease-m.show', $tenancyLetter->lease) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                        <table class="w-full" style="border-collapse: collapse;">
                            <!-- Header Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td>Your Ref. : {{ $tenancyLetter->your_reference ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Our Ref. : {{ $tenancyLetter->our_reference ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date : {{ $tenancyLetter->letter_date ? $tenancyLetter->letter_date->format('d F Y') : 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Sender Info Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td class="font-bold">{{ $tenancyLetter->recipient_company ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $tenancyLetter->recipient_address_line_1 ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $tenancyLetter->recipient_address_line_2 ?? 'N/A' }}</td>
                                        </tr>
                                        @if($tenancyLetter->recipient_address_line_3)
                                        <tr>
                                            <td>{{ $tenancyLetter->recipient_address_line_3 ?? 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>{{ $tenancyLetter->recipient_address_postcode ?? 'N/A' }} {{ $tenancyLetter->recipient_address_city ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $tenancyLetter->recipient_address_state ?? 'N/A' }}, {{ $tenancyLetter->recipient_address_country ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Attention Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td width="95"><span class="font-semibold">Attention to:</span></td>
                                            <td>{{ $tenancyLetter->attention_to_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>{{ $tenancyLetter->attention_to_position ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Greeting -->
                            <tr>
                                <td style="padding-bottom: 20px;">Dear Sir,</td>
                            </tr>
                            
                            <!-- Subject Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td class="font-bold" style="text-decoration: underline;">{{ $tenancyLetter->lease->tenant->property->portfolio->portfolio_name ?? 'N/A' }} REAL ESTATE INVESTMENT TRUST ("{{ $tenancyLetter->lease->tenant->property->portfolio->portfolio_name ?? 'N/A' }} REIT")</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold" style="text-decoration: underline;">{{ strtoupper($tenancyLetter->lease->tenancy_type) ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="w-full" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td width="140">Tenant</td>
                                                        <td>: {{ strtoupper($tenancyLetter->lease->tenant->name) ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="140" style="vertical-align: top;">Demised Premises</td>
                                                        <td>: {{ $tenancyLetter->lease->demised_premises ?? 'N/A' }} ({{ $tenancyLetter->lease->space ?? 'N/A' }} sq. ft.) ("Tenancy")</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Content Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="padding-bottom: 15px;">The above matter and your letter dated {{ $tenancyLetter->letter_offer_date ? $tenancyLetter->letter_offer_date->format('d F Y') : 'N/A' }} refer.</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px;">{{ $tenancyLetter->description_1 ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px;">{{ $tenancyLetter->description_2 ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Rental Table -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse; border: 1px solid #ccc;">
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 8px; text-align: center; width: 20%; background-color: #f2f2f2;">Year</th>
                                            <th style="border: 1px solid #ccc; padding: 8px; text-align: center; width: 80%; background-color: #f2f2f2;">Total Monthly Rental</th>
                                        </tr>
                                        @if($tenancyLetter->lease->monthly_gsto_year_1)
                                        <!-- lease base rate year 1 -->
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">1</td>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $tenancyLetter->lease->monthly_gsto_year_1 ?? 'N/A' }}% of Monthly Gross Sales Turnover</td>
                                        </tr>
                                        @endif
                                        @if($tenancyLetter->lease->monthly_gsto_year_2)
                                        <!-- lease base rate year 2 -->
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">2</td>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $tenancyLetter->lease->monthly_gsto_year_2 ?? 'N/A' }}% of Monthly Gross Sales Turnover</td>
                                        </tr>
                                        @endif
                                        @if($tenancyLetter->lease->monthly_gsto_year_3)
                                        <!-- lease base rate year 3 -->
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">3</td>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $tenancyLetter->lease->monthly_gsto_year_3 ?? 'N/A' }}% of Monthly Gross Sales Turnover</td>
                                        </tr>
                                        @endif
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Final Content Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="padding-bottom: 15px;">{{ $tenancyLetter->description_3 ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 30px;">Thank you.</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Signature Section -->
                            <tr>
                                <td>
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td>Yours faithfully</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">{{ strtoupper($tenancyLetter->trustee_name) ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 30px;"></td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">{{ strtoupper($tenancyLetter->approver_name) ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ucfirst($tenancyLetter->approver_position) ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ucfirst($tenancyLetter->approver_department) ?? 'N/A' }}</td>
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