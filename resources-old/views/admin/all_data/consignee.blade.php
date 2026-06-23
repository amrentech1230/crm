@php
$i = 1;
@endphp
@foreach($consignee as $consigne)
<tr>
    <td>{{ $i++ }}</td>
    <td>{{ $consigne->consignee_name }}</td>
    <td>{{ $consigne->consignee_address }}</td>
    <td>{{ $consigne->consignee_telephone }}</td>
    <td>
        {{ \Carbon\Carbon::parse($consigne->created_at)->format('m-d-Y') }}
    </td>
    <td>@if($consigne->user){{ $consigne->user->name }} @endif</td>
    <td>@if($consigne->user){{ $consigne->user->team_lead }} @endif</td>
    <td>@if($consigne->user){{ $consigne->user->manager }} @endif</td>
    <td>{{ $consigne->consignee_status }}</td>
    <td>

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

