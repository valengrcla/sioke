<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Poin Transaction</title>
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
        
        .btn-secondary {
            background-color: #E63946;
            color: #ffffff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #C5283D;
            color: #ffffff;
        }

        #add-product-button {
            margin-top: -10px;
            margin-left: 5px;
            color: #FFD54F;
        }

        .select2-container--default .select2-selection--single {
            height: 2.5rem; /* Sama dengan sales/create */
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 0.375rem 0.75rem;
            background-color: white;
        }

        .select2-container .select2-selection__arrow {
            transform: translateY(15%); /* Koreksi pergeseran vertikal */
            position: absolute;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #000 !important; /* Mengubah warna placeholder menjadi hitam */
            opacity: 1; /* Pastikan opacity penuh untuk teks placeholder */
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

    <div class="container mt-5 mb-5" style="margin-left: 280px; max-width: 900px;">
        <h2 class="mb-4">Redeem Points</h2>
        
        <form action="{{ route('poin.store') }}" method="POST" class="border p-4 rounded" style="background-color: #9CA986; position: relative;">
            @csrf
            <div class="mb-3">
                <label for="id_customer" class="form-label">Choose Customer</label>
                <select id="id_customer" name="id_customer" class="form-control select2-customer" required onchange="updatePoinCustomer()">
                    <option value="" disabled selected>Choose Customer</option>
                    @foreach ($customer as $customer)
                    <option value="{{ $customer->id_customer }}" data-poin="{{ $customer->totalpoin_customer }}">
                        {{ $customer->nama_customer }}
                    </option>
                    @endforeach
                </select>

                @if ($errors->has('id_customer'))
                    <div class="alert alert-danger">{{ $errors->first('id_customer') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="jumlah_poin" class="form-label">Customer Points</label>
                <input type="number" name="jumlah_poin" id="jumlah_poin" class="form-control" value="0" readonly>
            </div>

            <div id="product-section">
                <div class="mb-3 d-flex align-items-center">
                    <div style="flex: 1;">
                        <label for="product[0][id_product]" class="form-label">Choose Product</label>
                        <select name="product[0][id_product]" class="form-control select2-product" required onchange="calculateTotalPoin()">
                            <option value="" disabled selected>Choose Produk</option>
                            @foreach ($product as $product)
                                <option value="{{ $product->id_product }}" data-price="{{ $product->harga_poinproduct }}">{{ $product->nama_product }} - {{ $product->harga_poinproduct }} Poin</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="width: 70px; margin-left: 8px;">
                        <label for="product[0][quantity]" class="form-label">Quantity</label>
                        <input type="number" name="product[0][quantity]" class="form-control quantity" min="1" required value="0" onchange="calculateTotalPoin()">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="total_poin" class="form-label">Total Points</label>
                <input type="number" class="form-control" id="total_poin" name="total_poin" value="0" readonly>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('poin.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Redeem Points</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="fas fa-exclamation-triangle" style="color: #D32F2F;"></i> Warning
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for Choose Customer
            $('.select2-customer').select2({
                width: '100%', // Sama seperti sales/create
                placeholder: "Select a Customer",
                
            });

            // Initialize Select2 for Choose Product
            $('.select2-product').select2({
                width: '100%', // Sama seperti sales/create
                placeholder: "Select a Product",
                
            });

            // Style consistency for Select2
            $('.select2-container .select2-selection--single').css({
                height: '2.5rem',
                display: 'flex',
                alignItems: 'center',
                borderRadius: '0.375rem',
                paddingLeft: '10px'
            });
        });

        let productIndex = 1;

        function updatePoinCustomer() {
            const customerSelect = document.getElementById('id_customer');
            const selectedOption = customerSelect.options[customerSelect.selectedIndex];
            const totalPoinCustomer = selectedOption ? selectedOption.dataset.poin : 0;
            
            // Set total poin customer ke input
            document.getElementById('jumlah_poin').value = totalPoinCustomer;
        }

        function calculateTotalPoin() {
            let totalPoin = 0;
            const products = document.querySelectorAll('#product-section .mb-3');
            products.forEach(product => {
                const selectProduct = product.querySelector('select[name$="[id_product]"]');
                const quantityInput = product.querySelector('input[name$="[quantity]"]');

                 // Jika produk sudah dipilih, pastikan quantity minimal 1
                if (selectProduct.value) {
                    if (quantityInput.value === "0" || quantityInput.value === "") {
                        quantityInput.value = 1;
                    }
                } else {
                    // Jika belum ada produk, pastikan quantity tetap 0
                    quantityInput.value = 0;
                }

                // Pastikan elemen dan data-price ada
                if (!selectProduct || !quantityInput) return;

                const selectedOption = selectProduct.options[selectProduct.selectedIndex];
                // Periksa apakah ada opsi yang dipilih
                if (!selectedOption) return; // Jika tidak ada opsi yang dipilih, lewati perhitungan ini

                const productPrice = parseFloat(selectedOption.dataset.price) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                totalPoin += productPrice * quantity;
            });
            document.getElementById('total_poin').value = totalPoin;
        }

        document.querySelector('form').addEventListener('submit', function (event) {
            const jumlahPoin = parseInt(document.getElementById('jumlah_poin').value) || 0;
            const totalPoin = parseInt(document.getElementById('total_poin').value) || 0;
 
            if (jumlahPoin < totalPoin) {
                event.preventDefault();
                document.getElementById('errorMessage').textContent = 'Insufficient points available!';
                new bootstrap.Modal(document.getElementById('errorModal')).show();
            } 
        });

    </script>
</body>
</html>
