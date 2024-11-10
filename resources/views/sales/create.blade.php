<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            font-family: 'Lusitana', serif;
        }
        .mb-3 {
            background-color: #9CA986;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 8px;
        }
        
        .form-control {
            background-color: white;
            border: 1px solid #ccc;
            padding: 0.375rem 0.75rem;
        }

        .form-label {
            color: #000000;
            margin-bottom: 2px;
        }
        
        .btn-secondary, .btn-primary {
            background-color: #FFD54F;
            color: #000000;
            border: none;
        }

        .btn-secondary:hover, .btn-primary:hover {
            background-color: #DEF9C4;
            color: #333;
        }

        #add-product-button {
            margin-top: -10px;
            margin-left: 5px;
            color: #FFD54F;
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')
    
    <div id="navbar" style="position: fixed; top: 0; right: 0; z-index: 1000; width: auto;">
        @include('navbar')
    </div>
    
    <style>
        .navbar {
            padding: 0.3rem 0.5rem;
            font-size: 1rem;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 0.5rem 0.5rem;
            background-color: #fff;
            transition: top 0.3s;
        }
    
        .navbar-nav .nav-link {
            padding: 0.2rem 0.5rem;
        }
    
        .navbar img {
            width: 25px;
            height: 25px;
            margin-right: 5px;
        }
    </style>
    
    <script>
        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');
    
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
            if (scrollTop > lastScrollTop) {
                navbar.style.top = "-60px";
            } else {
                navbar.style.top = "0";
            }
            lastScrollTop = scrollTop;
        });
    </script>
    
    <div class="container mt-5 mb-5" style="margin-left: 280px; max-width: 900px; min-height: 700px;">
        <h2 class="mb-4">Sales / Create Sales</h2>
        
        <form action="{{ route('sales.store') }}" method="POST" class="border p-4 rounded" style="background-color: #9CA986; min-height: 550px; position: relative; padding-bottom: 150px;">
            @csrf
            <div class="mb-3">
                <label for="id_pengguna" class="form-label">Choose Pengguna</label>
                <select id="id_pengguna" name="id_pengguna" class="form-control" required>
                    <option value="" disabled selected>Select a Pengguna</option>
                    @foreach($pengguna as $pengguna)
                        <option value="{{ $pengguna->id_pengguna }}">{{ $pengguna->nama_pengguna }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="id_customer" class="form-label">Choose Customer</label>
                <select id="id_customer" name="id_customer" class="form-control" required>
                    <option value="" disabled selected>Select a Customer</option>
                    @foreach($customer as $customer)
                        <option value="{{ $customer->id_customer }}">{{ $customer->nama_customer }}</option>
                    @endforeach
                </select>
            </div>

            <div id="product-section">
                <div class="mb-3 d-flex align-items-center">
                    <div style="flex: 1;">
                        <label for="product[0][id_product]" class="form-label">Choose Product</label>
                        <select name="product[0][id_product]" class="form-control" required>
                            <option value="" disabled selected>Select a Product</option>
                            @foreach($product as $Product)
                                <option value="{{ $Product->id_product }}">{{ $Product->nama_product }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="width: 70px; margin-left: 8px;">
                        <label for="product[0][quantity]" class="form-label">Quantity</label>
                        <input type="number" name="product[0][quantity]" class="form-control quantity-input" value="0" min="0">
                    </div>
                    <button type="button" class="btn btn-link text-danger remove-btn" onclick="removeProduct(this)" disabled>Remove</button>
                </div>
            </div>

            <button type="button" class="btn btn-link" id="add-product-button" onclick="addProduct()">Add Product</button>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_harga" name="total_harga" required>
            </div>
            <div class="mb-3">
                <label for="bayar" class="form-label">Bayar</label>
                <input type="number" class="form-control" id="bayar" name="bayar" required>
            </div>

            <div class="d-flex justify-content-between" style="position: absolute; bottom: 20px; left: 20px; right: 20px;">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Sales</button>
            </div>
        </form>
    </div>

    <script>
        let productIndex = 1;

        function addProduct() {
            const section = document.getElementById('product-section');
            const newProduct = document.createElement('div');
            newProduct.classList.add('mb-3', 'd-flex', 'align-items-center');
            newProduct.innerHTML = `
                <div style="flex: 1;">
                    <select name="product[${productIndex}][id_product]" class="form-control" required>
                        <option value="" disabled selected>Select a Product</option>
                        @foreach($product as $product)
                            <option value="{{ $product->id_product }}">{{ $product->nama_product }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="width: 70px; margin-left: 8px;">
                    <input type="number" name="product[${productIndex}][quantity]" class="form-control quantity-input" value="0" min="0">
                </div>
                <button type="button" class="btn btn-link text-danger remove-btn" onclick="removeProduct(this)">Remove</button>
            `;
            section.appendChild(newProduct);
            updateRemoveButtons();
            productIndex++;
        }

        function removeProduct(element) {
            element.parentElement.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const products = document.querySelectorAll('#product-section .mb-3');
            products.forEach((product, index) => {
                const removeButton = product.querySelector('.remove-btn');
                removeButton.disabled = products.length <= 1;
            });
        }
        
        document.getElementById('product-section').addEventListener('input', function(event) {
            if (event.target.classList.contains('quantity-input')) {
                updateTotalQuantity();
            }
        });

        function updateTotalQuantity() {
            let totalQuantity = 0;
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
              
                totalQuantity += parseInt(input.value) || 0;
            });
            document.getElementById('total_harga').value = totalQuantity; // Adjust logic as per pricing
        }
    </script>
</body>
</html>
