@foreach($customerApprovalFormBroker as $customerApprovalFormBroker)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $customerApprovalFormBroker->agent_name }}</td>
    <td>{{ $customerApprovalFormBroker->agent_email }}</td>
    <td>{{ $customerApprovalFormBroker->customer_email }}</td>
    <td>{{ $customerApprovalFormBroker->company_name }}</td>
    <td>{{ $customerApprovalFormBroker->address }}</td>
    <td>{{ $customerApprovalFormBroker->country }}</td>
    <td>{{ $customerApprovalFormBroker->state }}</td>
    <td>{{ $customerApprovalFormBroker->city }}</td>
    <td>{{ $customerApprovalFormBroker->zip_code }}</td>
    <td>{{ $customerApprovalFormBroker->dispatcher_first_name }}</td>
    <td>{{ $customerApprovalFormBroker->dispatcher_last_name }}</td>
    <td>{{ $customerApprovalFormBroker->phone_number }}</td>
    <td>{{ $customerApprovalFormBroker->requested_credit_limit }}</td>
    <td>    {{ $customerApprovalFormBroker->created_at
                                                ? $customerApprovalFormBroker->created_at->timezone('America/New_York')->format('m-d-Y h:i A')
                                                : '-' }}</td>
</tr>
@endforeach