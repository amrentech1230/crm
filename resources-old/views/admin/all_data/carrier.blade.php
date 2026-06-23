@php
$i = 1;
@endphp
@foreach($external as $fetches)
<tr id="carrier-row-{{ $fetches->id }}">
    <td>{{ $i++ }}</td>
    <td>{{ ucwords($fetches->carrier_name) }}</td>
    <td>{{ $fetches->carrier_mc_ff_input }}</td>
    <td>{{ $fetches->carrier_dot}}</td>
    <td>{{ $fetches->carrier_address }}</td>
    <td>{{ $fetches->carrier_telephone }}</td>
    <td>
        {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
    </td>
    <td>@if($fetches->user){{ ucwords($fetches->user->name) }}@endif</td>
    <td>@if($fetches->user){{ ucwords($fetches->user->team_lead) }}@endif</td>
    <td>@if($fetches->user){{ ucwords($fetches->user->manager) }}@endif</td>
    <td>@if($fetches->user){{ ucwords($fetches->carrier_status) }}@endif</td>
    <td>
        <div class="d-flex justify-content-center">
              <form action="{{route('carrier.destroy', $fetches->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipper?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" style="font-size: 17px;color:rgb(255, 255, 255);"></i></button>
            </form>
        </div>
    </td>
</tr>
@endforeach

