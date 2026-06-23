
@php
$i = 1;
@endphp
@foreach($shipper as $fetches)
<tr>
    <td class="hide_blur_privacy">{{ $i++ }}</td>
    <td class="hide_blur_privacy">{{ $fetches->shipper_name }}</td>
    <td class="hide_blur_privacy">{{ $fetches->shipper_address }}</td>
    <td class="hide_blur_privacy">{{ $fetches->shipper_telephone }}</td>
    <td class="hide_blur_privacy">
        {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
    </td>
    <td class="hide_blur_privacy">{{ $fetches->user_name }}</td>
    <td class="hide_blur_privacy">{{ $fetches->user->teamLeaderInfo?->tl }}</td>
    <td class="hide_blur_privacy">{{ $fetches->user->managerInfo?->manager }}</td>
    <td class="hide_blur_privacy">{{ $fetches->shipper_status }}</td>
    <td class="hide_blur_privacy">
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
