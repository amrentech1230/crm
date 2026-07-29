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
    @php
        // Determine data source: use bolData (edited) if available, otherwise fall back to load fields
        $hasBolData = !empty($bolData);

        // Load Number
        $pdfLoadNumber = $hasBolData ? ($bolData['load_number'] ?? $load->load_number) : $load->load_number;

        // BOL Number
        $pdfBolNumber = $hasBolData ? ($bolData['bol_number'] ?? ($load->load_workorder ?? '')) : ($load->load_workorder ?? '');

        // Ship Date
        if ($hasBolData) {
            $pdfShipDate = $bolData['ship_date'] ?? '';
        } else {
            $shipper_appointment = json_decode($load->load_shipper_appointment, true);
            $pdfShipDate = isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '';
        }

        // Delivery Date
        if ($hasBolData) {
            $pdfDeliveryDate = $bolData['delivery_date'] ?? '';
        } else {
            $consignee_appointment = json_decode($load->load_consignee_appointment, true);
            $pdfDeliveryDate = isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '';
        }

        // Shipper Text
        if ($hasBolData) {
            $pdfShipperText = $bolData['shipper'] ?? '';
        } else {
            $shippers = json_decode($load->load_shipperr, true);
            $shipperLocations = json_decode($load->load_shipper_location, true);
            $pdfShipperText = '';
            if($shippers && is_array($shippers)) {
                foreach($shippers as $index => $item) {
                    $pdfShipperText .= ($item['name'] ?? '') . "\n";
                    // Get location from load_shipper_location JSON
                    if($shipperLocations && isset($shipperLocations[$index]['location']) && !empty($shipperLocations[$index]['location'])) {
                        $pdfShipperText .= $shipperLocations[$index]['location'] . "\n";
                    } elseif(!empty($item['location'])) {
                        $pdfShipperText .= $item['location'] . "\n";
                    }
                    $pdfShipperText .= "\n";
                }
            }
            $pdfShipperText = trim($pdfShipperText);
        }

        // Consignee Text
        if ($hasBolData) {
            $pdfConsigneeText = $bolData['consignee'] ?? '';
        } else {
            $consignees = json_decode($load->load_consignee, true);
            $consigneeLocations = json_decode($load->load_consignee_location, true);
            $pdfConsigneeText = '';
            if($consignees && is_array($consignees)) {
                foreach($consignees as $index => $item) {
                    $pdfConsigneeText .= ($item['name'] ?? '') . "\n";
                    // Get location from load_consignee_location JSON
                    if($consigneeLocations && isset($consigneeLocations[$index]['location']) && !empty($consigneeLocations[$index]['location'])) {
                        $pdfConsigneeText .= $consigneeLocations[$index]['location'] . "\n";
                    } elseif(!empty($item['location'])) {
                        $pdfConsigneeText .= $item['location'] . "\n";
                    }
                    $pdfConsigneeText .= "\n";
                }
            }
            $pdfConsigneeText = trim($pdfConsigneeText);
        }

        // 3rd Party Billing
        $pdfThirdPartyBilling = $hasBolData ? ($bolData['third_party_billing'] ?? '') : '';

        // Transportation Company
        if ($hasBolData) {
            $pdfTransportation = $bolData['transportation_company'] ?? '';
        } else {
            $pdfTransportation = "MC #: " . ($load->load_mc_no ?? '') . "\nCarrier Name: " . ($load->load_carrier ?? '');
        }

        // Freight Items
        $pdfFreightItems = $hasBolData ? ($bolData['freight_items'] ?? []) : [];

        // Total Pieces
        $pdfTotalPieces = $hasBolData ? ($bolData['total_pieces'] ?? '1') : '1';

        // Total Weight
        $pdfTotalWeight = $hasBolData ? ($bolData['total_weight'] ?? '0.00') : '0.00';

        // Notes
        $pdfNotes = $hasBolData ? ($bolData['notes'] ?? '') : ($load->notes ?? '');

        // COD fields
        $pdfCodAmount = $hasBolData ? ($bolData['cod_amount'] ?? '$0.00') : '$0.00';
        $pdfCodFee = $hasBolData ? ($bolData['cod_fee'] ?? 'Collect') : 'Collect';
        $pdfDeclaredValue = $hasBolData ? ($bolData['declared_value'] ?? '$0.00') : '$0.00';

        // Signature fields
        $pdfShipperSignature = $hasBolData ? ($bolData['shipper_signature'] ?? '') : '';
        $pdfCarrierSignature = $hasBolData ? ($bolData['carrier_signature'] ?? '') : '';
        $pdfSignatureDate = $hasBolData ? ($bolData['signature_date'] ?? '') : '';
        $pdfPerShipper = $hasBolData ? ($bolData['per_shipper'] ?? '') : '';
        $pdfPerCarrier = $hasBolData ? ($bolData['per_carrier'] ?? '') : '';
        $pdfSignatureTime = $hasBolData ? ($bolData['signature_time'] ?? '') : '';
        $pdfConsigneeNameSign = $hasBolData ? ($bolData['consignee_name_sign'] ?? '') : '';
        $pdfConsigneeDateSign = $hasBolData ? ($bolData['consignee_date_sign'] ?? '') : '';
        $pdfConsigneeSignature = $hasBolData ? ($bolData['consignee_signature'] ?? '') : '';
        $pdfPiecesReceived = $hasBolData ? ($bolData['pieces_received'] ?? '') : '';
    @endphp

    <div class="bol-container">
        <!-- Top Section -->
        <table class="no-border" style="margin-bottom: 10px;">
            <tr>
                <td style="width: 65%; border: none;">
                    <div style="display: flex; align-items: flex-start; gap: 15px;">
                        <div>
                            @php
                                $logoUrl = 'https://geeshasolutions.com/wp-content/uploads/2024/07/cargo.png';
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
                            <td>{{ $pdfLoadNumber }}</td>
                        </tr>
                        <tr>
                            <th>BOL Number</th>
                            <td>{{ $pdfBolNumber }}</td>
                        </tr>
                        <tr>
                            <th>Ship Date</th>
                            <td>{{ $pdfShipDate }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Date</th>
                            <td>{{ $pdfDeliveryDate }}</td>
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
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0;">{{ $pdfShipperText }}</pre>
                </td>
                <td style="width: 50%;">
                    <h6>Consignee</h6>
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0;">{{ $pdfConsigneeText }}</pre>
                </td>
            </tr>
        </table>

        <!-- 3rd Party Billing & Transportation Company -->
        <table>
            <tr>
                <td style="width: 50%;">
                    <h6>3rd Party Billing</h6>
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0; min-height: 80px;">{{ $pdfThirdPartyBilling }}</pre>
                </td>
                <td style="width: 50%;">
                    <h6>Transportation Company</h6>
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0;">{{ $pdfTransportation }}</pre>
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
                @if(!empty($pdfFreightItems) && is_array($pdfFreightItems))
                    @foreach($pdfFreightItems as $item)
                    <tr>
                        <td>{{ $item['pieces'] ?? '' }}</td>
                        <td>{{ $item['description'] ?? '' }}</td>
                        <td>{{ $item['weight'] ?? '' }}</td>
                        <td>{{ $item['type'] ?? '' }}</td>
                        <td>{{ $item['nmfc'] ?? '' }}</td>
                        <td>{{ $item['hm'] ?? '' }}</td>
                        <td>{{ $item['class_val'] ?? '' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>#Unit 1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span class="fw-bold">Total Pieces</span><br>
                        {{ $pdfTotalPieces }}
                    </td>
                    <td colspan="2" class="text-center">
                        <span class="fw-bold">Total Weight</span><br>
                        {{ $pdfTotalWeight }}
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
                    <pre style="font-family: Arial, sans-serif; font-size: 12px; margin: 0; min-height: 100px;">{{ $pdfNotes }}</pre>
                </td>
                <td style="width: 30%; padding: 0;">
                    <table class="no-border">
                        <tr>
                            <td style="border: 1px solid #000;">
                                <span class="fw-bold">C.O.D. Amount:</span> {{ $pdfCodAmount }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">
                                <span class="fw-bold">C.O.D. Fee:</span> {{ $pdfCodFee }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">
                                <span class="fw-bold">Declared Value:</span> {{ $pdfDeclaredValue }}
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
                <td class="signature-box">{{ $pdfShipperSignature }}</td>
                <td class="signature-box">{{ $pdfCarrierSignature }}</td>
                <td class="signature-box">{{ $pdfSignatureDate }}</td>
            </tr>
            <tr>
                <th>Per</th>
                <th>Per</th>
                <th>Time</th>
                <td class="signature-box"></td>
            </tr>
            <tr>
                <td class="signature-box">{{ $pdfPerShipper }}</td>
                <td class="signature-box">{{ $pdfPerCarrier }}</td>
                <td class="signature-box">{{ $pdfSignatureTime }}</td>
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
                <td class="signature-box">{{ $pdfConsigneeNameSign }}</td>
                <td class="signature-box">{{ $pdfConsigneeDateSign }}</td>
                <td class="signature-box">{{ $pdfConsigneeSignature }}</td>
                <td class="signature-box">{{ $pdfPiecesReceived }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
