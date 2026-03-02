@php $grandTotal = 0; @endphp
@if(count($products) > 0)
    @foreach($products as $product)
        @php 
            $total = $product['quantity'] * $product['price'];
            $grandTotal += $total;
        @endphp
        <tr>
            <td>{{ $product['product_name'] }}</td>
            <td>{{ $product['quantity'] }}</td>
            <td>{{ number_format($product['price'], 2) }}</td>
            <td>{{ $product['submitted_at'] }}</td>
            <td>{{ number_format($total, 2) }}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $product['id'] }}">Edit</button>
            </td>
        </tr>
    @endforeach
    <tr class="table-info shadow-sm">
        <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
        <td colspan="2"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
    </tr>
@else
    <tr>
        <td colspan="6" class="text-center">No data available.</td>
    </tr>
@endif