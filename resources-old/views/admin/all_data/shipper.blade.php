
@php
$i = 1;
@endphp
@foreach($shipper as $fetches)
<tr>
    <td>{{ $i++ }}</td>
    <td>{{ $fetches->shipper_name }}</td>
    <td>{{ $fetches->shipper_address }}</td>
    <td>{{ $fetches->shipper_telephone }}</td>
    <td>
        {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
    </td>
    <td>{{ $fetches->user_name }}</td>
    <td>{{ $fetches->manager }}</td>
    <td>{{ $fetches->team_lead }}</td>
    <td>{{ $fetches->shipper_status }}</td>
    <td>
    <div class="d-flex justify-content-center">
        <form action="{{ route('shipper.destroy', $fetches->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipper?');" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" style="font-size: 17px;color:rgb(255, 255, 255);"></i></button>
</form>

    </div>
</td>
</tr>
@endforeach
