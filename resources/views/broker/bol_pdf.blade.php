<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Of Lading - {{ $load->load_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333;
        }
        .bol-container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f3f3f3;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        h3 {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #111;
        }
        h6 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .logo {
            width: 120px;
            display: block;
        }
        .company-info {
            line-height: 1.3;
            font-size: 12px;
        }
        .company-info h3 {
            font-size: 28px;
            margin: 0 0 5px 0;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
        .table-grey th {
            background-color: #e9ecef !important;
        }
        .no-border {
            border: none !important;
        }
        .signature-box {
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="bol-container">
        <!-- Top Section -->
        <table class="no-border" style="margin-bottom: 10px;">
            <tr>
                <td style="width: 65%; border: none;">
                    <div style="display: flex; align-items: flex-start; gap: 15px;">
                        <div>
                            @php
                                $logoUrl = public_path('images/cargo.png');
                                $logoBase64 = base64_encode(file_get_contents($logoUrl));
                            @endphp
                            <img class="logo" src="data:image/png;base64,{{ $logoBase64 }}" alt="logo">
                        </div>
                        <div class="company-info">
                            <h3>CARGO CONVOY INC</h3>
                            <div>
                                7119 PENNSYLVANIA AVE,<br>
                                Upper Darby, PA, USA 19082
                            </div>
                            <div style="margin-top: 5px; font-weight: bold;">
                                Phone: 267-513-0420
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 35%; border: none;">
                    <table>
                        <tr>
                            <th>Load Number</th>
                            <td>{{ $load->load_number }}</td>
                        </tr>
                        <tr>
                            <th>BOL Number</th>
                            <td>{{ $load->load_workorder ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Ship Date</th>
                            @php
                                $shipper_appointment = json_decode($load->load_shipper_appointment, true);
                                $shipDate = isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '';
                            @endphp
                            <td>{{ $shipDate }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Date</th>
                            @php
                                $consignee_appointment = json_decode($load->load_consignee_appointment, true);
                                $deliveryDate = isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '';
                            @endphp
                            <td>{{ $deliveryDate }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Shipper & Consignee -->
        <table>
            <tr>
                <td style="width: 50%;">
                    <h6>Shipper</h6>
                    @php
                        $shippers = json_decode($load->load_shipperr, true);
                        $shipperText = '';
                        if($shippers && is_array($shippers)) {
                            foreach($shippers as $item) {
                                $shipperText .= ($item['name'] ?? '') . "\n";
                                if(!empty($item['location'])) {
                                    $shipperText .= $item['location'] . "\n";
                                }
                                $shipperText .= "\n";
                            }
                        }
                    @endphp
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0;">{{ trim($shipperText) }}</pre>
                </td>
                <td style="width: 50%;">
                    <h6>Consignee</h6>
                    @php
                        $consignees = json_decode($load->load_consignee, true);
                        $consigneeText = '';
                        if($consignees && is_array($consignees)) {
                            foreach($consignees as $item) {
                                $consigneeText .= ($item['name'] ?? '') . "\n";
                                if(!empty($item['location'])) {
                                    $consigneeText .= $item['location'] . "\n";
                                }
                                $consigneeText .= "\n";
                            }
                        }
                    @endphp
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0;">{{ trim($consigneeText) }}</pre>
                </td>
            </tr>
        </table>

        <!-- 3rd Party Billing & Transportation Company -->
        <table>
            <tr>
                <td style="width: 50%;">
                    <h6>3rd Party Billing</h6>
                    <!-- Assuming 3rd party billing info is not directly in $load for now -->
                    <div style="min-height: 80px;"></div>
                </td>
                <td style="width: 50%;">
                    <h6>Transportation Company</h6>
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0;">MC #: {{ $load->load_mc_no ?? '' }}
Carrier Name: {{ $load->load_carrier ?? '' }}</pre>
                </td>
            </tr>
        </table>

        <!-- Freight Table -->
        <table>
            <thead class="table-grey">
                <tr>
                    <th># of pieces</th>
                    <th>Description of the goods, marks, exceptions</th>
                    <th>Weight in LBS.</th>
                    <th>Type</th>
                    <th>NMFC</th>
                    <th>HM</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder for freight items. If freight data is stored in $load, iterate here. -->
                <tr>
                    <td>#Unit 1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                {{--
                @foreach(json_decode($load->freight_items, true) as $item)
                <tr>
                    <td>{{ $item['pieces'] ?? '' }}</td>
                    <td>{{ $item['description'] ?? '' }}</td>
                    <td>{{ $item['weight'] ?? '' }}</td>
                    <td>{{ $item['type'] ?? '' }}</td>
                    <td>{{ $item['nmfc'] ?? '' }}</td>
                    <td>{{ $item['hm'] ?? '' }}</td>
                    <td>{{ $item['class'] ?? '' }}</td>
                </tr>
                @endforeach
                --}}
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span class="fw-bold">Total Pieces</span><br>
                        <!-- Calculate total pieces if freight data is available -->
                        1
                    </td>
                    <td colspan="2" class="text-center">
                        <span class="fw-bold">Total Weight</span><br>
                        <!-- Calculate total weight if freight data is available -->
                        0.00
                    </td>
                    <td colspan="4" class="text-center">
                        <span class="fw-bold">Emergency Response Phone</span><br>
                        24/7 Dispatch Support
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Notes & COD -->
        <table>
            <tr>
                <td style="width: 70%;">
                    <h6 class="fw-bold">Notes:</h6>
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0; min-height: 100px;">{{ $load->notes ?? '' }}</pre>
                </td>
                <td style="width: 30%; padding: 0;">
                    <table class="no-border">
                        <tr>
                            <td style="border: 1px solid #000;">
                                <span class="fw-bold">C.O.D. Amount:</span> $0.00
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">
                                <span class="fw-bold">C.O.D. Fee:</span> Collect
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">
                                <span class="fw-bold">Declared Value:</span> $0.00
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 10px; border: 1px solid #000;">
                                If at consignor's risk, write or stamp here
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Signatures -->
        <table>
            <tr>
                <th style="width: 25%;">Shipper</th>
                <th style="width: 25%;">Carrier</th>
                <th style="width: 25%;">Date</th>
                <th style="width: 25%;" rowspan="2">Number Of Pieces Received</th>
            </tr>
            <tr>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
            </tr>
            <tr>
                <th>Per</th>
                <th>Per</th>
                <th>Time</th>
                <td class="signature-box"></td>
            </tr>
            <tr>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Consignee Name</th>
                <th>Date</th>
                <th>Signature</th>
                <th>Number Of Pieces Received</th>
            </tr>
            <tr>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
                <td class="signature-box"></td>
            </tr>
        </table>
    </div>
</body>
</html>