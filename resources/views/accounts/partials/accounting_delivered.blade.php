
@foreach($delivered as $i => $delivereds)
    @php
        $shipperAppointment = json_decode($delivereds->load_shipper_appointment, true);
        $firstAppointment = '';

        if (is_array($shipperAppointment) && !empty($shipperAppointment)) {
            reset($shipperAppointment);
            $firstItem = current($shipperAppointment);

            if (is_array($firstItem)) {
                if (isset($firstItem['date'])) {
                    $firstAppointment = $firstItem['date'];
                } else {
                    $firstAppointment = reset($firstItem);
                }
            } elseif (is_string($firstItem)) {
                $firstAppointment = $firstItem;
            }
        }

        $consigneeAppointment = json_decode($delivereds->load_consignee_appointment, true);
        $lastAppointment = '';

        if (is_array($consigneeAppointment) && !empty($consigneeAppointment)) {
            $lastItem = end($consigneeAppointment);

            if (is_array($lastItem)) {
                if (isset($lastItem['date'])) {
                    $lastAppointment = $lastItem['date'];
                } else {
                    $lastAppointment = reset($lastItem);
                }
            } elseif (is_string($lastItem)) {
                $lastAppointment = $lastItem;
            }
        }
    @endphp
    <tr>
       
        <td>{{ $delivereds->load_number }}</td>
     
    </tr>
@endforeach
    