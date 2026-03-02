@php $grandTotal = 0; @endphp
@foreach($products as $product)
    @php 
        $total = $product['quantity'] * $product['price'];
        $grandTotal += $total;
    @endphp
    <tr>
        <td>{{ $product['product_name'] }}</td>
        <td>{{ $product['quantity'] }}</td>
        <td>{{ $product['price'] }}</td>
        <td>{{ $product['submitted_at'] }}</td>
        <td>{{ number_format($total, 2) }}</td>
    </tr>
@endforeach
<tr class="table-info">
    <td colspan="4" class="text-end"><strong>Sum Total:</strong></td>
    <td><strong>{{ number_format($grandTotal, 2) }}</strong></td>
</tr>