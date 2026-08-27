@php
$i = 1;
@endphp
@foreach($external as $fetches)
<tr id="carrier-row-{{ $fetches->id }}">
    <td class="hide_blur_privacy">{{ $i++ }}</td>
    <td class="hide_blur_privacy">{{ ucwords($fetches->carrier_name) }}</td>
    <td class="hide_blur_privacy">{{ $fetches->carrier_mc_ff_input }}</td>
    <td class="hide_blur_privacy">{{ $fetches->carrier_dot}}</td>
    <td class="hide_blur_privacy">{{ $fetches->carrier_address }}</td>
    <td class="hide_blur_privacy">{{ $fetches->carrier_telephone }}</td>
    <td class="hide_blur_privacy">
        {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
    </td>
    <td class="hide_blur_privacy">@if($fetches->user){{ ucwords($fetches->user->name) }}@endif</td>
    <td class="hide_blur_privacy">@if($fetches->user){{ ucwords($fetches->user->teamLeaderInfo?->tl) }}@endif</td>
    <td class="hide_blur_privacy">@if($fetches->user){{ ucwords($fetches->user->managerInfo?->manager) }}@endif</td>
    <td class="hide_blur_privacy">@if($fetches->user){{ ucwords($fetches->carrier_status) }}@endif</td>
    <td class="hide_blur_privacy">
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

