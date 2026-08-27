<!DOCTYPE html>
<html lang="">

<head>
    <title>CUSTOMER RATE & LOAD CONFIRMATION {{ $load->load_number }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
</head>
<style>
    /* body {
        font-family: 'Poppins', sans-serif;
    } */
.rate-load-confirmation{
    width: 100%;
    margin-left: -25px !important;
}
    .detail {
        padding: 10px;
        margin: 17px 15px;
        border-radius: 7px;
        background: #f7f7f7;
        border: 1px solid #cccc;
        width: 100%;
    }
    .disspatch {
    position: absolute;
    right: 0;
    top: 55px;
}
    h3 {
        text-align: center;
        color: #749c09;
        font-size: 15px;
        margin: 0;
    }
    .content {
        padding: 0 30px;
    }


.form{
    margin-bottom:20px;
}

p {
    font-size: 14px;
    margin: 2px;
}
li{
    list-style:none;
}
.rate{
    margin-left: 19px;
}
.rate h4{
    margin:unset;
    margin-bottom:10px;
}
.info td{
    border:1px solid #000;
}
.form table tr{
   float:left;
}
.form table tr td{
    padding: 0 10px;
}
.notes{
    overflow-y: scroll;
    width:100%;
    font-size: 14px;
}
</style>

<body>
  <section class="rate-load-confirmation">
                <h3>CUSTOMER RATE & LOAD CONFIRMATION</h3>
                        <div class="direction">
                            <div class="logo" style="text-align:center; width: 30%;">
                                @php
                                    $logoUrl = 'https://geeshasolutions.com/wp-content/uploads/2024/07/cargo.png';
                                    $logoBase64 = base64_encode(file_get_contents($logoUrl));
                                @endphp

                                <img style="width: 40%;" src="data:image/png;base64,{{ $logoBase64 }}" alt="logo">
                            </div>
                            
                        </div>
                        <div class="direction">
                            <div class="rate" style="width:30%;" >
                                <p>
                                    Rosemont Business Campus<br>
                                    919 Conestoga Road Bldg 3 Suite<br>
                                    215 Bryn Mawr, PA 19010<br>
                                    (267) 513-0604
                                </p>
                                </div>
                            </div>
                            <div class="disspatch">
                                <table class="info" style="margin-top:20px;margin-bottom:30px;margin-left:20px;">
                                    <tr>
                                        <td style="width:65% !important">
                                            <p><b>Dispatcher:</b>@if($load->user){{ $load->user->name }}@endif</p>
                                        </td>
                                        <td style="width:35% !important">
                                            
                                            <p><b>Load #:</b>{{ $load->load_number }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:65% !important">
                                          <p><b>Phone #:</b>@if($load->user){{ $load->user->emergency_contact }}@endif</p>
                                            
                                        </td>
                                        <td style="width:35% !important">
                                          <p><b>W/O:</b>{{ $load->load_workorder }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:65% !important">
                                           <p><b>Email:</b>@if($load->user){{ $load->user->email }}@endif</p>
                                            <!-- <p><b>C.r/f #:</b>{{ $load->customer_refrence_number }}</p> -->
                                        </td>
                                         
                                        @php
                                            $shipper_appointment = json_decode($load->load_shipper_appointment, true);
                                            if ($shipper_appointment) {
                                                end($shipper_appointment); // move the internal pointer to the last element
                                                $lastKey = key($shipper_appointment); // get the key of the last element
                                                $lastAppointment = $shipper_appointment[$lastKey];
                                            } else {
                                                $lastAppointment = null;
                                            }
                                        @endphp
                                        
                                        <td style="width:35% !important">
                                        <p><b>Ship Date:</b> {{ isset($lastAppointment['appointment']) ? \Carbon\Carbon::parse($lastAppointment['appointment'])->format('m/d/Y') : '-' }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:65% !important">
                                           <p><b>C.r/f #:</b>{{ $load->customer_refrence_number }}</p>
                                        </td>
                                        <td style="width:35% !important">
                                            <p><b>Today's Date:</b> {{ now()->setTimezone('America/New_York')->format('m-d-Y') }}

                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                
                        <div class="detail" style="width: 100%;">
                            <table style="width:100%">
                                <thead>
                                    <tr>
                                        <th><b>Customer:</b></th>
                                        <th><b>Phone:</b></th>
                                        <th><b>Equipment:</b></th>
                                        <th><b>Agreed Amount:</b></th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td style="text-align:center;">
                                        <p>{{ $load->load_bill_to }}</p>
                                    </td>
                                    <td style="text-align:center;">
                                        <p>{{ $load->customer?->customer_telephone }}</p>
                                    </td>
                                    <td style="text-align:center;">
                                        <p>{{ $load->load_equipment_type }}</p>
                                    </td>
                                    <td style="text-align:center;">
                                        <p>${{ $load->shipper_load_final_rate }}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
         
                        @php
                        $counter = 1;
                        $shipper = json_decode($load->load_shipperr, true);
                        $shipper_qty = json_decode($load->load_shipper_qty, true);
                        $shipper_weight = json_decode($load->load_shipper_weight, true);
                        $shipper_discription = json_decode($load->load_shipper_discription, true);
                        $shipper_type = json_decode($load->load_shipper_commodity_type, true);
                        $shipper_notes = json_decode($load->load_shipper_shipping_notes, true);
                        $shipper_contact = json_decode($load->load_shipper_contact, true);
                        $shipper_location = json_decode($load->load_shipper_location, true);
                        $shipper_appointmet = json_decode($load->load_shipper_appointment, true);
                        $shipper_commodity = json_decode($load->load_shipper_commodity, true);
                        $shipper_value = json_decode($load->load_shipper_value, true);
                        $shipper_contact_number = json_decode($load->load_shipper_contact, true);
                        $sipper_po_number = json_decode($load->load_shipper_po_numbers, true);
                        $shipper_appointment_date = json_decode($load->load_shipper_appointment, true);
                        $carbon_date = isset($shipper_appointment_date['appointment']) ? Carbon::parse($shipper_appointment_date['appointment']) : null;
                        $formatted_date = $carbon_date ? $carbon_date->format('Y-m-d H:i') : 'N/A';
                        $shipperContact = json_decode($load->load_shipper_contact, true) ?? [];
                        $shipperLocation = json_decode($load->load_shipper_location, true) ?? [];
                        $shipperNotes = json_decode($load->load_shipper_shipping_notes, true) ?? [];
                        $shipperType = json_decode($load->load_shipper_commodity_type, true) ?? [];
                        $shipperPoNumber = json_decode($load->load_shipper_po_numbers, true) ?? [];
                        $shipperWeight = json_decode($load->load_shipper_weight, true) ?? [];
                        $shipperQty = json_decode($load->load_shipper_qty, true) ?? [];
                        

                        
                        @endphp
                        
                        @php
                        $counter = 1;
                        @endphp
                        
                        @foreach ($shipper as $key => $shipper)
                    <div class="detail" style="width: 100%;">
                        <h3>Shipper {{ $counter++ }}</h3>
                        <table style="width:100%">
                            <tr>
                                <td style="width:65% !important">
                                    <p><b>Name:</b> {{ isset($shipper['name']) ? $shipper['name'] : '' }}</p>
                                </td>
                                <td style="width:35% !important">
                                    <p><b>Type:</b> {{ isset($shipperType[$key]['commodity_type']) ? $shipperType[$key]['commodity_type'] : ($shipperType[$key]['type'] ?? '') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:65% !important">
                                   <p><b>Contact:</b> {{ $shipperContact[$key]['shipping_contact'] ?? $shipperContact[$key]['contact'] ?? '' }}</p>
                                </td>
                                <td style="width:35% !important">
                                <p><b>PO Numbers :</b> {{ isset($shipperPoNumber[$key]['shipping_po_numbers']) ? $shipperPoNumber[$key]['shipping_po_numbers'] : $shipperPoNumber[$key]['po_number'] ?? '' }}</p> 
                                </td>
                            </tr>
                            <tr>
                                <td style="width:35% !important">
                                <p><b>Shipping Address:</b> {{ $shipperLocation[$key]['location'] ?? '' }}"</p> 
                                </td>
                                <td style="width:65% !important">
                                    <p><b>Weight:</b> {{ isset($shipperWeight[$key]['shipper_weight']) ? $shipperWeight[$key]['shipper_weight'] : ($shipperWeight[$key]['weight'] ?? '') }} lbs</p>
                                </td>
                            </tr>
                            <tr>
                               <td style="width:35% !important">
                                    <p><b>Description</b> {{ isset($shipper_discription[$key]['description']) ? $shipper_discription[$key]['description'] : '' }}</p>
                                </td>
                                <td style="width:65% !important">
                                <p><b>Quantity:</b> {{ isset($shipperQty[$key]['shipper_qty']) ? $shipperQty[$key]['shipper_qty'] : ($shipperQty[$key]['qty'] ?? '') }}</p>
                                </td>
                                
                            </tr>
                            <tr>
                               <td style="width:35% !important">
                                    <p><b>Shipping Note:</b> {{ isset($shipperNotes[$key]['shipping_notes']) ? $shipperNotes[$key]['shipping_notes'] : $shipperNotes[$key]['notes'] ?? '' }}</p>
                                </td>
                                <td style="width:65% !important">
                                <p><b>Date:</b>{{ isset($shipper_appointmet[$key]['appointment']) ? \Carbon\Carbon::parse($shipper_appointmet[$key]['appointment'])->format('m-d-Y') : '' }}</p>
                                </td>
                                
                            </tr>
                            <tr>
                               <td style="width:35% !important">
                                    <p><b>Commodity:</b> {{ isset($shipper_commodity[$key]['commodity']) ? $shipper_commodity[$key]['commodity'] : $shipper_commodity[$key]['commodity_name'] }}</p>
                                </td>
                                
                            </tr>
                        </table>
                    </div>
                            @endforeach
                            @php
                             $consignees = json_decode($load->load_consignee, true); // Decode JSON string for consignee names
                             $consignees_qty = json_decode($load->load_consignee_qty, true); // Decode JSON string for consignee quantities
                             $consignees_weight = json_decode($load->load_consignee_weight, true); // Decode JSON string for consignee weights
                             $consignees_delivery_notes = json_decode($load->load_consignee_delivery_notes, true); // Decode JSON string for consignee delivery notes
                             $consignees_type = json_decode($load->load_consignee_type, true); // Decode JSON string for consignee types
                             $consignees_notes = json_decode($load->load_consigneer_notes, true); // Decode JSON string for consignee notes
                             $consignees_contact = json_decode($load->load_consignee_contact, true); // Decode JSON string for consignee contact info
                             $load_consignee_po_numbers = json_decode($load->load_consignee_po_numbers, true);
                             $consignee_appointment = json_decode($load->load_consignee_appointment, true);
                             $consignees_notes = json_decode($load->load_consigneer_notes, true); // Decode JSON string for consignee notes
                             $consignees_contact = json_decode($load->load_consigneer_contact, true);
                             $consigneesLocation = json_decode($load->load_consignee_location, true);
                             $consigneesDiscription = json_decode($load->load_consignee_discription, true);
                             $consigneecommodity = json_decode($load->load_consignee_commodity,true);
                             @endphp
                             @php
                             $counter = 1;
                             @endphp
                             @foreach ($consignees as $key => $consignee)
                <div class="detail" style="width: 100%;">
                <h3>Consignee {{ $counter++ }}</h3>
                    <table style="width:100%">
                        <tr>
                            <td style="width:65% !important">
                                <p><b>Name:</b>{{ $consignee['name'] }}</p>
                            </td>
                            <td style="width:35% !important">
                                <p><b>Type:</b>{{ isset($consignees_type[$key]['consignee_type']) ? $consignees_type[$key]['consignee_type'] : '' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:65% !important">
                            <p><b>Contact:</b> {{ isset($consignees_contact[$key]['consignee_contact']) ? $consignees_contact[$key]['consignee_contact'] : '' }}</p>
                            <!-- <p><b>Quantity:</b>{{ isset($consignees_qty[$key]['consignee_qty']) ? $consignees_qty[$key]['consignee_qty'] : '' }}</p> -->
                            </td>
                            <td style="width:35% !important">
                            <!-- <p><b>Date:</b>{{ isset($consignee_appointment[$key]['appointment']) ? date('m-d-Y', strtotime($consignee_appointment[$key]['appointment'])) : '' }}</p> -->
                            <p><b>PO Numbers:</b> {{ isset($load_consignee_po_numbers[$key]['consignee_po_number']) ? $load_consignee_po_numbers[$key]['consignee_po_number'] : '' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:65% !important">
                                <p><b>Consignee Address:</b> {{ isset($consigneesLocation[$key]['location']) ? $consigneesLocation[$key]['location'] : '' }}</p>
                                <!-- <p><b>Weight:</b>{{ isset($consignees_weight[$key]['consignee_weight']) ? $consignees_weight[$key]['consignee_weight'] : '' }} lbs</p> -->
                            </td>
                            @if(isset($load->load_consigneer_notes))
                            <td style="width:35% !important">
                            <!-- <p><b>PO Numbers:</b> {{ isset($load_consignee_po_numbers[$key]['consignee_po_number']) ? $load_consignee_po_numbers[$key]['consignee_po_number'] : '' }}</p> -->
                           <p><b>Weight:</b>{{ isset($consignees_weight[$key]['consignee_weight']) ? $consignees_weight[$key]['consignee_weight'] : '' }} lbs</p>
                            </td>
                            @else
                               <p>No consignee notes available.</p>
                            @endif
                        </tr>
                        <tr>
                            <td>
                                <p><b>Description:</b>{{ isset($consigneesDiscription[$key]['description']) ? $consigneesDiscription[$key]['description'] : '' }}</p>
                            </td>
                            <td>
                            <p><b>Quantity:</b>{{ isset($consignees_qty[$key]['consignee_qty']) ? $consignees_qty[$key]['consignee_qty'] : '' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><b>Consignee Note:</b>{{ isset($consignees_notes[$key]['load_consignee_notes']) ? $consignees_notes[$key]['load_consignee_notes'] : '' }}</p>
                            </td>
                            <td>
                            <p><b>Date:</b>{{ isset($consignee_appointment[$key]['appointment']) ? date('m-d-Y', strtotime($consignee_appointment[$key]['appointment'])) : '' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:35% !important">
                                <p><b>Commodity:</b> {{ isset($consigneecommodity[$key]['consignee_commodity']) ? $consigneecommodity[$key]['consignee_commodity'] : '' }}</p>
                            </td>
                            
                        </tr>
                    </table>
                </div>
                @endforeach

        <div class="content">
                        <h6 style="font-weight: 700;font-size: 18px;margin: 0;">Dispatch Notes</h6>
                        <p>**Signee certifies that this contract can be honered without exceeding the driver's hour
                            of service Limitations.**</p>
                        <h6 style="font-weight: 700;font-size: 18px;margin: 0;">Most Important</h6>
                        <p>1. Complaints about hours of service will not be considered valid unless the carrier or
                            driver calls our
                            account payable at (267-710-1411) at the time of the perceived coercion. </p>
                        <p>2. Service failures resulting from failure to disclose hours of service limitations will
                            result in
                            significant fines.</p>
                        <p>3. Fines resulting from government enforcement of anti-coercion rules will be paid by the
                            carrier.</p>
                        <p>4. Carrier must Call in for Check Calls Every day + loaded and unloaded.</p>
                        <p>5. All invoices must be emailed to info@cargoconvoy.co along with proof of delivery,
                            bill of lading,
                            and signed rate confirmation.</p>
                        <p>6. Read the Standard Terms and Conditions below.</p>
                        <h6 style="font-weight: 700;font-size: 18px;margin: 0;">Standard Terms and Conditions</h6>
                        <p>1. Carrier (Dispatcher/Driver) agrees to physically inspect and note all damages/all
                            defects at pickup or
                            delivery location on the bill of lading (BOL).</p>
                        <p>2. Carrier is responsible for all damages/defects to the load secured during transit.</p>
                        <p>3. Carrier must submit photographs of all damages noted on the BOL.</p>
                        <P>4. Carrier is responsible for any damage to the seal/packing over the load. The
                            seal/packing needs to be
                            kept intact until the load is delivered.</P>
                        <p>5. Carrier is responsible for correct loading, counting of pallets, and must check weight
                            on each axle at
                            the time of loading.</p>
                        <p>6. Carrier is responsible for hauling legal weight and load security. Carrier is
                            responsible to make
                            immediate protest, prior to transport, of any alleged weight overage or security
                            concerns, else carrier
                            will be accountable for the same.</p>
                        <p>7. All requests to reschedule an appointment must be made to the broker one day prior to
                            pick or
                            delivery.</p>
                        <p>8. Failure to reschedule and for any missed appointment to pick up or delivery may result
                            in a fee of
                            $150.00 Per Day or could result in cancellation of the listed pick up or delivery.</p>
                        <P>9. Cargoconvoy does not pay detention/TONU on loads (unless specified).
                            Detention/TONU will
                            be paid only if the customer approves it.</P>
                        <p>10. Double brokered loads will not be paid.</p>
                        <p>11. Carrier to bill the Broker who is solely responsible for freight charges.</p>
                        <P>12. Carrier assumes responsibility for shipment requiring tarps whether noted on Rate
                            Confirmation.</P>
                        <p>13. Carrier is responsible for maintaining continuous/appropriate temperature in case of
                            Reefer loads.</p>
                        <p>14. Carrier assumes full value responsibility for the shipment not to be limited by
                            insurance capacity or
                            previous agreement.</p>
                        <P>15. By transporting this shipment, the Carrier agrees to the above Terms and Conditions,
                            and this
                            agreement shall be deemed to be in Full Force and Effective even if unsigned.</P>
                        <p>16.POD is to be shared with in 48 hours of delivery, or it can lead to $100 deduction.</p>
                        <b>Please sign both pages of Confirmation & Terms and Conditions and reply</b>
                        <!-- <p><b>Carrier Pay:</b>${{ $load->load_carrier_fee }}, FSC Rate:%{{ $load->load_billing_fsc_rate }} ., <b>TOTAL:$625.00 USD $</b></p> -->
                        <!-- <p><b> Final Customer Charges:</b> ${{ $load->load_shipper_rate }} FSC Rate {{ $load->load_fsc_rate }}% <b>TOTAL : {{ $load->shipper_load_final_rate }} </b></p> -->
                         <!-- <p><b>Carrier Pay:</b>${{ $load->load_carrier_fee }}, FSC Rate:%{{ $load->load_billing_fsc_rate }} ., <b>TOTAL:$625.00 USD $</b></p> -->
@php
    $otherCharges = json_decode($load->shipper_load_other_charge, true);
@endphp
<p>
    <b>Final Customer Charges:</b> ${{ $load->load_shipper_rate }} , 
    @if($load->load_fsc_rate)


    FSC Rate : {{ $load->load_fsc_rate }}% ,
@endif
    @if ($otherCharges)
        @foreach ($otherCharges as $charge)
           
                {{ $charge['type'] }}: ${{ $charge['amount'] }},
        @endforeach
    @endif
    <b>= TOTAL: ${{ $load->shipper_load_final_rate }}</b>
</p>


                    </div>
                    <div class="form" style="width:100%; padding-top:30px;">
            <table style="width:100%; padding: 0 10px;">
                <tr>
                    <td><b>Accepted By:</b><hr></td>
                    <td><b>Date:</b><hr></td>
                </tr>
                <tr>
                <td><b>Signature:</b><hr></td>
                <td><b>Trailer #:</b><hr></td>
                </tr>
                <tr>
                    <td><b>Driver Name:</b><hr></td>
                    <td><b>Cell #:</b><hr></td>
                </tr>
                <tr>
                    <td><b>Truck #:</b><hr></td>
            </table>
        </div>
  </section>
</body>
</html>