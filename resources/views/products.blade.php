<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Product Skill Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4 mb-5">
            <h3>Add New Product</h3>
            <form id="productForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Quantity in Stock</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Price per Item</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card shadow p-4">
            <h3>Submitted Data</h3>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Datetime Submitted</th>
                        <th>Total Value</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @include('partials.product_rows', ['products' => $products])
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            let formData = {
                product_name: $('#product_name').val(),
                quantity: $('#quantity').val(),
                price: $('#price').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    alert(response.success);
                    updateTable(response.data);
                    $('#productForm')[0].reset();
                }
            });
        });

        function updateTable(products) {
            let html = '';
            let grandTotal = 0;
            products.forEach(product => {
                let totalValue = product.quantity * product.price;
                grandTotal += totalValue;
                html += `<tr>
                    <td>${product.product_name}</td>
                    <td>${product.quantity}</td>
                    <td>${product.price}</td>
                    <td>${product.submitted_at}</td>
                    <td>${totalValue.toFixed(2)}</td>
                </tr>`;
            });
            html += `<tr class="table-info font-weight-bold">
                <td colspan="4 text-end"><strong>Sum Total:</strong></td>
                <td><strong>${grandTotal.toFixed(2)}</strong></td>
            </tr>`;
            $('#productTableBody').html(html);
        }
    </script>
</body>
</html>