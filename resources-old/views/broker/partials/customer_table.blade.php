@foreach($customers as $customer)
<tr>
    <td>
        <a href="#" data-bs-toggle="modal" data-bs-target="#">
            <i class="fas fa-edit"></i>
        </span>
    </td>

    <td>{{ $customer->customer_name }}</td>
    <td>{{ $customer->customer_address }} {{ $customer->customer_state }} {{ $customer->customer_city }} {{ $customer->customer_country }} {{ $customer->customer_zip }}</td>
    <td>{{ $customer->customer_telephone }}</td>
    <td>{{ $customer->created_at }}</td>
    <td>{{ $customer->user->name }}</td>
    <td>{{ $customer->user->teamLeaderInfo?->tl  }}</td>
    <td>{{ $customer->user->managerInfo?->manager }}</td>
    <td>{{ $customer->remaining_credit }}</td>
    <td>{{ $customer->customer_name }}</td>
    <td>{{ $customer->status }}</td>
    <td>{{ $customer->comment_notes }}</td>
</tr>
@endforeach
