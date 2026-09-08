@foreach($carrier_blocked as $carrier)
<tr>
    <td>{{$carrier->carrier_mc_ff_input}}</td>
    <td>{{$carrier->carrier_dot}}</td>
    <td>{{$carrier->carrier_name}}</td>
    <td>{{$carrier->user?->name}}</td>
    <td>{{$carrier->created_at}}</td>
    <td>{{$carrier->mc_check}}</td>
</tr>
@endforeach




