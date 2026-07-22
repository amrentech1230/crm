
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
        <td>{{ $i + 1 }}</td>
        <td>{{ $delivereds->load_number }}</td>
        <td>
            <a class="btn btn-primary btn-sm" onclick="openUploadWindow('{{ route('load.edit', $delivereds->id) }}')"><i class="fas fa-edit"></i></a>
            <a href="{{ route('accounts.view_loads_detail', $delivereds->id) }}" class="btn btn-primary btn-sm" title="logs"><i class="fas fa-eye"></i></a>
        </td>
        <td>{{ $delivereds->load_workorder }}</td>
        <td>{{ $delivereds->customer?->customer_name }}</td>
        <td>{{ $delivereds->shipper_load_final_rate }}</td>
        <td>{{ $delivereds->user ? $delivereds->user->name : '' }}</td>
        <td>{{ \Carbon\Carbon::parse($delivereds->created_at)->format('m-d-Y') }}</td>
        <td>{{ $firstAppointment ? \Carbon\Carbon::parse($firstAppointment)->format('m-d-Y') : '' }}</td>
        <td>{{ $lastAppointment ? \Carbon\Carbon::parse($lastAppointment)->format('m-d-Y') : '' }}</td>
        <td>{{ $delivereds->carrier?->carrier_name }}</td>
        <td>{{ $delivereds->load_final_carrier_fee }}</td>
        <td class="text-success">{{ $delivereds->load_status }}</td>
    </tr>
@endforeach
    