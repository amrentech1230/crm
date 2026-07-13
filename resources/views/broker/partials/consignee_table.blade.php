
@foreach($consignees as $consignee)
<tr>
    <td>
        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
            data-bs-target="#editConsigneeModal_{{ $consignee->id }}">
            <i class="fas fa-edit"></i>
        </button>
    </td>
    <td>{{ $consignee->consignee_name }}</td>
    <td>{{ $consignee->consignee_address }}</td>
    <td>{{ $consignee->consignee_telephone }}</td>
    <td>{{ $consignee->created_at->format('Y-m-d') }}</td>
    <td>{{ $consignee->user?->name }}</td>
    <td>{{ $consignee->user?->teamLeaderInfo?->tl }}</td>
    <td>{{ $consignee->user?->managerInfo?->manager }}</td>
    <td>{{ $consignee->consignee_status }}</td>
</tr>
@endforeach
