 @php $i = 1; @endphp
 @foreach($dashboard as $load)
 @php
 $shipper = json_decode($load->load_shipperr, true);
 $consignee = json_decode($load->load_consignee, true);
 $shipper_appointment = json_decode($load->load_shipper_appointment, true);
 $shipper_location = json_decode($load->load_shipper_location, true);
 $consignee_location = json_decode($load->load_consignee_location, true);
 $consignee_appointment = json_decode($load->load_consignee_appointment, true);
 @endphp

 <tr>
     <td class="dynamic-data">{{ $i++ }}</td>
     <td class="dynamic-data"><a href="{{ route('accounts.view_loads_detail', $load->id) }}"
             class="btn btn-primary btn-sm">
             <i class="fas fa-eye"></i>
         </a></td>
     <td class="dynamic-data">{{ $load->load_number }}</td>
     <td class="dynamic-data">
         @php
         $statusOptions = [
         'Open' => '#74d1f0',
         'Covered' => 'rgb(69 7 172 / 72%)',
         'On Route' => 'green',
         'Delivered' => '#7C2B1A',
         'Unloading' => 'gray',
         'Completed' => '#3597dc',
         'Invoiced' => '#3597dc',
         'Paid' => 'green',
         'Invoiced and Paid' => 'green'
         ];

         $statusColor = $statusOptions[$load->load_status] ?? '#000'; // Default color if status is not found
         @endphp

         @if($load->invoice_status == 'Paid' && $load->load_status == 'Delivered')
         <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
             Invoiced
         </span>
         @elseif($load->load_status == 'Delivered' && $load->invoice_status == 'Paid Record')
         <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
             Invoiced and Paid
         </span>
         @elseif($load->load_status == 'Completed' && empty($load->invoice_status))
         <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
             Completed
         </span>
         @elseif($load->load_status == 'Open' && empty($load->invoice_status))
         <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
             Open
         </span>
         @elseif($load->load_status == 'Unloading' && empty($load->invoice_status))
         <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
             Unloading
         </span>
         @else
         <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
             {{ $load->load_status }}
         </span>
         @endif
     </td>

     <td class="dynamic-data">{{ $load->load_carrier }}</td>
     <td class="dynamic-data">
         {{ \Carbon\Carbon::parse($load->created_at)->format('m/d/Y') }}
     </td>
     <td class="dynamic-data">@if($load->user) {{ $load->user->name }} @endif</td>
     <td class="dynamic-data">{{ $load->load_bill_to }}</td>
     <td class="dynamic-data">{{ isset($shipper[0]['name']) ? $shipper[0]['name'] : '' }}</td>
     <td class="dynamic-data">
         @if(isset($shipper_appointment[0]['appointment']))
         {{ \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m/d/Y') }}
         @else
         'Old Data'
         @endif
     </td>

     <td class="dynamic-data">
         {{ isset($shipper_location[0]['location']) ? $shipper_location[0]['location'] : 'No Location Entered' }}</td>
     <td class="dynamic-data">{{ isset($consignee[0]['name']) ? $consignee[0]['name'] : 'Old Data' }}</td>
     <td class="dynamic-data">
         @if (!empty($consignee_appointment))
         @php
         $lastAppointment = end($consignee_appointment)['appointment'] ?? null;
         @endphp
         {{ $lastAppointment ? \Carbon\Carbon::parse($lastAppointment)->format('m/d/Y') : '' }}
         @endif
     </td>


     <td class="dynamic-data">
         {{ isset($consignee_location[0]['location']) ? $consignee_location[0]['location'] : 'No Location Entered' }}
     </td>
     <td>{{ $load->cpr_check }}</td>
 </tr>
 @endforeach
