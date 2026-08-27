
    @foreach($open as $i => $opens)
    @php
    $shipperAppointment = json_decode($opens->load_shipper_appointment, true);
    $firstAppointment = '';

    if (is_array($shipperAppointment) && !empty($shipperAppointment)) {
    reset($shipperAppointment);
    $firstItem = current($shipperAppointment);

    if (is_array($firstItem)) {
    // If first item is an array, get the first string value or a key like 'date'
    if (isset($firstItem['date'])) {
    $firstAppointment = $firstItem['date'];
    } else {
    // fallback: get first value of the array
    $firstAppointment = reset($firstItem);
    }
    } elseif (is_string($firstItem)) {
    // If first item is a string directly
    $firstAppointment = $firstItem;
    }
    }
    @endphp

    @php
    $consigneeAppointment = json_decode($opens->load_consignee_appointment, true);
    $lastAppointment = '';

    if (is_array($consigneeAppointment) && !empty($consigneeAppointment)) {
    $lastItem = end($consigneeAppointment);

    if (is_array($lastItem)) {
    // If last item is an array, try to get 'date' key or first value
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
        <td>{{ $opens->load_number }}</td>
		<td>
            <a class="btn btn-primary btn-sm" onclick="openUploadWindow('{{route('load.edit', $opens->id)}}')"><i class=" fas fa-edit"></i></a>
            <a href="{{ route('accounts.view_loads_detail', $opens->id) }}" class="btn btn-primary btn-sm" title="logs"> <i class="fas fa-eye"></i></a>
        </td>
        <td>{{ $opens->load_workorder }}</td>
        <td>{{ $opens->load_bill_to }}</td>
        <td>{{ $opens->shipper_load_final_rate }}</td>
        <td>{{ optional($opens->user)->name }}</td>
        <td>{{ \Carbon\Carbon::parse($opens->created_at)->format('m-d-Y') }}</td>
        <td>{{ $firstAppointment ? \Carbon\Carbon::parse($firstAppointment)->format('m-d-Y') : '' }}</td>
        <td>{{ $lastAppointment ? \Carbon\Carbon::parse($lastAppointment)->format('m-d-Y') : '' }}</td>
        <td>{{ $opens->carrier?->carrier_name }}</td>
        <td>{{ $opens->load_final_carrier_fee }}</td>
        <td class="text-success">{{ $opens->load_status }}</td>
    </tr>
    @endforeach
