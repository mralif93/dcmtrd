<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Print Button -->
                    <div class="print-controls mb-4 flex justify-end">
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
                                            <td>Your Ref. : DRMSB/AL-SALĀM REIT/KomtarJBCC/1124</td>
                                        </tr>
                                        <tr>
                                            <td>Our Ref. : ART/RU/TENANCY/ALSM/2024-108</td>
                                        </tr>
                                        <tr>
                                            <td>Date : {{  date('d F Y') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Sender Info Section -->
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <table class="w-full" style="border-collapse: collapse;">
                                        <tr>
                                            <td class="font-bold">DAMANSARA REIT MANAGERS SDN BERHAD</td>
                                        </tr>
                                        <tr>
                                            <td>Unit 1-19-02, Level 19</td>
                                        </tr>
                                        <tr>
                                            <td>Block 1, V SQUARE</td>
                                        </tr>
                                        <tr>
                                            <td>Jalan Utara</td>
                                        </tr>
                                        <tr>
                                            <td>46200 Petaling Jaya</td>
                                        </tr>
                                        <tr>
                                            <td>Selangor Darul Ehsan</td>
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
                                            <td>ENCIK HAMIM BIN MOHAMAD</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Manager, Legal Department</td>
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
                                            <td class="font-bold" style="text-decoration: underline;">{{ strtoupper($lease->tenant->property->portfolio->portfolio_name) ?? 'N/A' }} REAL ESTATE INVESTMENT TRUST ("{{ $lease->tenant->property->portfolio->portfolio_name ?? 'N/A' }} REIT")</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold" style="text-decoration: underline;">{{ strtoupper($lease->tenancy_type) }} TENANCY</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="w-full" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td width="140">Tenant</td>
                                                        <td>: {{ $lease->tenant->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="140" style="vertical-align: top;">Demised Premises</td>
                                                        <td>: {{ $lease->demised_premises ?? 'N/A' }} ({{ $lease->space ?? 'N/A' }} sq. ft.) ("Tenancy")</td>
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
                                            <td style="padding-bottom: 15px;">The above matter and your letter dated {{ $lease->created_at->format('d F Y') }} refer.</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px;">We, AmanahRaya Trustees Berhad, as Trustee to {{ $lease->tenant->property->portfolio->portfolio_name ?? 'N/A' }} REIT hereby approve the New Tenancy of the above-mentioned Demised Premises.</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 15px;">The Demised Premises is to be used exclusively for the retail sale of ladies, men and children apparels and other related accessories under the trade name of F.O.S only for the rental as follows:</td>
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
                                        @if($lease->base_rate_year_1)
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">1</td>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $lease->monthly_gsto_year_1 }}% of Monthly Gross Sales Turnover</td>
                                        </tr>
                                        @endif
                                        @if($lease->base_rate_year_2)
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">2</td>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $lease->monthly_gsto_year_1 }}% of Monthly Gross Sales Turnover</td>
                                        </tr>
                                        @endif
                                        @if($lease->base_rate_year_3)
                                        <tr>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">3</td>
                                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $lease->monthly_gsto_year_1 }}% of Monthly Gross Sales Turnover</td>
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
                                            <td style="padding-bottom: 15px;">The above approval is subject to the terms and conditions specified in the Letter of Offer dated {{ $lease->start_date ? $lease->start_date->format('d F Y') : 'N/A' }} and Supplemental Letter of Offer dated {{ $lease->end_date ? $lease->end_date->format('d F Y') : 'N/A' }}.</td>
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
                                            <td class="font-bold">AMANAHRAYA TRUSTEES BERHAD</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 30px;"></td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">{{ $lease->prepared_by ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $lease->prepared_by_position ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Debt Capital Market & Trusts and REITs Department</td>
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