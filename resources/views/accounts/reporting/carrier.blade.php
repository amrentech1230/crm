@php $i = 1; @endphp
@foreach($totalRevenueloadcarrier as $index => $LoadCarrier)
@php
$finalRate = $LoadCarrier->total_revenue - $LoadCarrier->revenue_difference;
@endphp
<tr>
    <td class="dynamic-data">{{ ($totalRevenueloadcarrier->currentPage() - 1) * $totalRevenueloadcarrier->perPage() + $index + 1 }}</td>
    <td class="dynamic-data">{{ $LoadCarrier->load_carrier }}</td>
    <td class="dynamic-data">{{ $LoadCarrier->load_count }}</td>
    <td class="dynamic-data">{{ $LoadCarrier->total_revenue }}</td>
    <td class="dynamic-data">{{ $LoadCarrier->revenue_difference }}</td>
    <td class="dynamic-data">{{ $finalRate }}</td>
    <td class="dynamic-data">-</td>
    <td class="dynamic-data">-</td>
    <td class="dynamic-data">-</td>
</tr>
@endforeach

