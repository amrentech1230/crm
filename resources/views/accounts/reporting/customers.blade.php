@forelse($totalRevenueCustomer as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->customer_name }}</td>
                <td>
                    <span class="badge bg-success">
                        {{ $row->status }}
                    </span>
                </td>
                <td>${{ number_format($row->total_revenue, 2) }}</td>
                <td>${{ number_format($row->total_carrier_cost, 2) }}</td>
                <td>
                    <strong class="text-success">
                        ${{ number_format($row->margin, 2) }}
                    </strong>
                </td>
                <td>{{ $row->load_count }}</td>
                <td>{{ $row->open_load_count }}</td>
                <td>{{ $row->delivered_load_count }}</td>
                <!-- <td>{{ $row->completed_load_count }}</td> -->
                <td>
                    {{ $row->remaining_credit_logs ?? '—' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center">
                    No records found
                </td>
            </tr>
        @endforelse