@php
$i = 1;
@endphp
@foreach($consignee as $consigne)
<tr>
    <td class="hide_blur_privacy">{{ $i++ }}</td>
    <td class="hide_blur_privacy">{{ $consigne->consignee_name }}</td>
    <td class="hide_blur_privacy">{{ $consigne->consignee_address }}</td>
    <td class="hide_blur_privacy">{{ $consigne->consignee_telephone }}</td>
    <td class="hide_blur_privacy">
        {{ \Carbon\Carbon::parse($consigne->created_at)->format('m-d-Y') }}
    </td>
    <td class="hide_blur_privacy">@if($consigne->user){{ $consigne->user->name }} @endif</td>
    <td class="hide_blur_privacy">@if($consigne->user){{ $consigne->user->teamLeaderInfo?->tl }} @endif</td>
    <td class="hide_blur_privacy">@if($consigne->user){{ $consigne->user->managerInfo?->manager }} @endif</td>
    <td class="hide_blur_privacy">{{ $consigne->consignee_status }}</td>
    <td class="hide_blur_privacy">

        <div class="d-flex justify-content-center">
            <form action="{{route('consignee.destroy', $consigne->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipper?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" style="font-size: 17px;color:rgb(255, 255, 255);"></i></button>
            </form>

        </div>
    </td>

</tr>
@endforeach

