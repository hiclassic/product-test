<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Product Skill Test - Professional Version</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { background-color: #f4f7f6; }
        .card { border-radius: 10px; border: none; }
        .table-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow p-4 mb-5">
            <h3 id="formHeader" class="mb-4">Add New Product</h3>
            <form id="productForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" id="product_name" class="form-control" placeholder="e.g. Laptop" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Quantity in Stock</label>
                        <input type="number" id="quantity" class="form-control" placeholder="0" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Price per Item</label>
                        <input type="number" step="0.01" id="price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" id="submitBtn" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-container">
            <h3 class="mb-4">Submitted Data</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Datetime Submitted</th>
                            <th>Total Value</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @include('partials.product_rows', ['products' => $products])
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get(`/products/${id}/edit`, function(data) {
                $('#product_name').val(data.product_name);
                $('#quantity').val(data.quantity);
                $('#price').val(data.price);
                
             
                $('#productForm').attr('data-mode', 'edit');
                $('#productForm').attr('data-id', id);
                $('#formHeader').text('Update Product');
                $('#submitBtn').text('Update Product').removeClass('btn-primary').addClass('btn-success');
                
              
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            
            let mode = $(this).attr('data-mode');
            let id = $(this).attr('data-id');
            let url = (mode === 'edit') ? "{{ route('products.update') }}" : "{{ route('products.store') }}";
            
            let formData = {
                id: id,
                product_name: $('#product_name').val(),
                quantity: $('#quantity').val(),
                price: $('#price').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                success: function(response) {
                    alert(response.success);
                    
                    updateTable(response.data);
                    
                    
                    resetForm();
                },
                error: function(xhr) {
                    alert("Something went wrong! Please check your input.");
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
                    <td>${parseFloat(product.price).toFixed(2)}</td>
                    <td>${product.submitted_at}</td>
                    <td>${totalValue.toFixed(2)}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${product.id}">Edit</button>
                    </td>
                </tr>`;
            });
            
            html += `<tr class="table-info fw-bold">
                <td colspan="4" class="text-end">Sum Total:</td>
                <td colspan="2">${grandTotal.toFixed(2)}</td>
            </tr>`;
            
            $('#productTableBody').html(html);
        }

        
        function resetForm() {
            $('#productForm')[0].reset();
            $('#productForm').removeAttr('data-mode').removeAttr('data-id');
            $('#formHeader').text('Add New Product');
            $('#submitBtn').text('Submit').removeClass('btn-success').addClass('btn-primary');
        }
    </script>
</body>
</html>