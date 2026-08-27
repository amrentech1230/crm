
@foreach ($customersData as $index => $customer)
@php
        $customerAging = \App\Models\Load::where('customer_id', $customer->id)
            ->where('invoice_status', 'Paid')
            ->sum('shipper_load_final_rate');

        $last30Days = \App\Models\Load::where('customer_id', $customer->id)
            ->where('invoice_status', 'Paid')
            ->whereRaw('STR_TO_DATE(invoice_date, "%Y-%m-%d") BETWEEN ? AND ?', [
                now()->subDays(30)->toDateString(),
                now()->toDateString()
            ])->sum('shipper_load_final_rate');
    @endphp
                                    <tr>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ ($customersData->currentPage() - 1) * $customersData->perPage() + $index + 1 }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            <a href="javascript:void(0)" data-customer-id="{{ $customer->id  }}" data-bs-toggle="modal" data-bs-target="#customerDetailsModal">
                                                {{ $customer->customer_name }}
                                            </a>
                                        </td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer->user?->teamLeaderInfo?->tl ?? 'N/A' }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer->user?->managerInfo?->manager ?? 'N/A' }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer->user?->officedata?->office_name ?? 'N/A' }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer->user?->name ?? 'N/A' }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;"><a href="javascript:void(0)" data-customer-id="{{ $customer->id  }}" data-toggle="modal" data-target="#customerDetailsModal">{{ number_format($customerAging, 2) }}</a></td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;"><a href="javascript:void(0)" data-customer-id="{{ $customer->id }}" data-toggle="modal" data-target="#thirtydaysaging">{{ number_format($last30Days, 2) }}</a></td>
                                    </tr>
                                    @endforeach