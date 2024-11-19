<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
 
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
        .no-spinner::-webkit-outer-spin-button,
        .no-spinner::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
 
        .no-spinner {
            -moz-appearance: textfield; /* Untuk Firefox */
        }
        
        .modal-dialog {
            position: fixed; /* Pastikan modal tetap di tempat meskipun halaman discroll */
            top: 30%; /* Atur posisi modal ke atas sedikit (sesuaikan nilai ini) */
            left: 40%;
            transform: translateX(-50%); /* Menjaga modal tetap terpusat secara horizontal */
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto;
        }

        .modal-content {
            margin-top: 0; /* Adjust this value to shift the modal down */
        }
        
    </style>
</head>
<body>
    @include('layouts.sidebar')
   
    <div id="navbar" style="position: fixed; top: 0; right: 0; z-index: 1000; width: auto;">
        @include('navbar')
    </div>
   
    <div class="container mt-5 mb-5" style="margin-left: 280px; max-width: 900px; min-height: 700px;">
        <h2 class="mb-4">Sales / Create Sales</h2>
       
        <form action="{{ route('sales.store') }}" method="POST" class="border p-4 rounded" style="background-color: #9CA986; min-height: 550px; position: relative; padding-bottom: 150px;">
            @csrf
            <div class="mb-3">
                <label for="id_pengguna" class="form-label">Choose Pengguna</label>
                <select id="id_pengguna" name="id_pengguna" class="form-control select2" required>
                    <option value="" disabled selected>Select a Pengguna</option>
                    @foreach($pengguna as $pengguna)
                        <option value="{{ $pengguna->id_pengguna }}">{{ $pengguna->nama_pengguna }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="id_customer" class="form-label">Choose Customer</label>
                <select id="id_customer" name="id_customer" class="form-control select2">
                    {{-- <option value="" disabled selected>Select a Customer</option> --}}
                    {{-- <option value="tanpa_member" selected>Tanpa Member</option> <!-- Default "Tanpa Member" --> --}}
                    <option value="" selected>(Without Member)</option> <!-- Default kosong untuk transaksi tanpa member -->
                    @foreach($customer as $customer)
                        <option value="{{ $customer->id_customer }}">{{ $customer->nama_customer }}</option>
                    @endforeach
                </select>
            </div>
 
            <div id="product-section">
                <div class="mb-3 d-flex align-items-center product-item">
                    <div style="flex: 1;">
                        <label for="product[0][id_product]" class="form-label">Choose Product</label>
                        <select name="product[0][id_product]" class="form-control product-select" required onchange="updateTotalPrice()">
                            <option value="" disabled selected>Select a Product</option>
                            @foreach($product as $Product)
                                <option value="{{ $Product->id_product }}" data-price="{{ $Product->harga_product }}">{{ $Product->nama_product }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="width: 70px; margin-left: 8px;">
                        <label for="product[0][quantity]" class="form-label">Quantity</label>
                        <input type="number" name="product[0][quantity]" class="form-control quantity-input" value="0" min="0" onchange="checkQuantity(this)">
                    </div>
                    <button type="button" class="btn btn-link text-danger remove-btn" onclick="removeProduct(this)" disabled>Remove</button>
                </div>
            </div>
 
            <button type="button" class="btn btn-link" id="add-product-button" onclick="addProduct()">Add Product</button>
 
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="text" class="form-control" id="total_harga_display" readonly>
                <input type="hidden" id="total_harga" name="total_harga">
            </div>
            <div class="mb-3">
                <label for="bayar" class="form-label">Bayar</label>
                <input type="number" class="form-control no-spinner" id="bayar" name="bayar" required>
                {{-- @error('bayar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror --}}
            </div>
 
            <div class="mb-3">
                <label for="total_kembali" class="form-label">Kembalian</label>
                <input type="text" class="form-control" id="total_kembali" readonly>
            </div>
 
            <div class="d-flex justify-content-between">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Sales</button>
            </div>
        </form>
    </div>

     <!-- Modal for error alert -->
     <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for product warning -->
    <div class="modal fade" id="productErrorModal" tabindex="-1" aria-labelledby="productErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productErrorModalLabel">
                        <i class="fas fa-exclamation-triangle" style="color: #D32F2F;"></i> Warning
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="productErrorMessage">At least one product must be selected.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
        $('.select2').select2({
            width: '100%' // Pastikan lebar menyesuaikan
        });
         // Atur tinggi select2 melalui CSS setelah inisialisasi
        $('.select2-container .select2-selection--single').css({
            height: '2.5rem', // Sesuaikan tinggi di sini
            display: 'flex',
            'align-items': 'center'
        });
        // Turunkan posisi simbol dropdown
        $('.select2-container .select2-selection--single .select2-selection__arrow').css({
            'margin-top': '5px' // Sesuaikan nilai ini untuk menurunkan simbol
        });
    });

    // Handle form submission and validation for "bayar" input
    $("form").on("submit", function(event) {
            let bayar = parseFloat($('#bayar').val());
            let totalHarga = parseFloat($('#total_harga').val());

            if (bayar < totalHarga) {
                event.preventDefault(); // Prevent form submission
                $('#errorMessage').text('Jumlah bayar tidak boleh kurang dari total harga!');
                $('#errorModal').modal('show'); // Show the error modal
            }
    });
 
    let productIndex = 1;
 
    // Tambahkan produk baru
    function addProduct() {
        const section = document.getElementById('product-section');
        const newProduct = document.createElement('div');
        newProduct.classList.add('mb-3', 'd-flex', 'align-items-center', 'product-item');
        newProduct.innerHTML = `
            <div style="flex: 1;">
                <label for="product[${productIndex}][id_product]" class="form-label">Choose Product</label>
                <select name="product[${productIndex}][id_product]" class="form-control product-select" required onchange="updateTotalPrice()">
                    <option value="" disabled selected>Select a Product</option>
                    @foreach($product as $product)
                        <option value="{{ $product->id_product }}" data-price="{{ $product->harga_product }}">{{ $product->nama_product }}</option>
                    @endforeach
                </select>
            </div>
            <div style="width: 70px; margin-left: 8px;">
                <label for="product[${productIndex}][quantity]" class="form-label">Quantity</label>
                <input type="number" name="product[${productIndex}][quantity]" class="form-control quantity-input" value="0" min="0" onchange="checkQuantity(this)">
            </div>
            <button type="button" class="btn btn-link text-danger remove-btn" onclick="removeProduct(this)">Remove</button>
        `;
        section.appendChild(newProduct);
        productIndex++;
 
        // Perbarui status tombol Remove
        updateRemoveButtons();
    }
 
    // Fungsi untuk memeriksa quantity dan menghapus produk jika quantity 0
    function checkQuantity(inputElement) {
        const quantity = parseInt(inputElement.value) || 0;
        const productItem = inputElement.closest('.product-item');
        const productSelect = productItem.querySelector('.product-select');

        if (quantity === 0 && productSelect.value) {
            // Jika quantity 0 dan produk telah dipilih, hapus item
            removeProduct(productItem.querySelector('.remove-btn'));
        } else {
            // Jika tidak, perbarui total harga
            updateTotalPrice();
        }
    }
 
    // Hapus produk
    function removeProduct(removeButton) {
        const productSection = document.getElementById('product-section');
        const productItems = productSection.querySelectorAll('.product-item');

        // Pastikan minimal ada satu produk yang tersisa
        if (productItems.length > 1) {
            removeButton.parentElement.remove();
            updateTotalPrice();
            updateRemoveButtons();
        } else {
            // alert("At least one product must be selected.");
            $('#productErrorModal').modal('show');
            const lastProductItem = productItems[0];
            const quantityInput = lastProductItem.querySelector('.quantity-input');
            quantityInput.value = 1; // Set quantity kembali menjadi 1
            updateTotalPrice(); // Perbarui total harga
        }
    }
 
    // Perbarui status tombol Remove
    function updateRemoveButtons() {
        const products = document.querySelectorAll('#product-section .product-item');
        products.forEach((product, index) => {
            const removeButton = product.querySelector('.remove-btn');
            removeButton.disabled = products.length <= 1;
        });
    }

    
    // Hitung total harga
    function updateTotalPrice() {
        let totalPrice = 0;
        const productItems = document.querySelectorAll('.product-item');
 
        productItems.forEach(item => {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
 
            const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex]?.getAttribute('data-price') || 0);
             // Jika produk sudah dipilih, pastikan quantity minimal 1
            if (productSelect.value) {
                if (quantityInput.value === "0" || quantityInput.value === "") {
                    quantityInput.value = 1;
                }
            } else {
                // Jika belum ada produk, pastikan quantity tetap 0
                quantityInput.value = 0;
            }
            
            const quantity = parseInt(quantityInput.value) || 0;
 
            totalPrice += productPrice * quantity;
        });
 
        document.getElementById('total_harga_display').value = totalPrice.toFixed(2);
        document.getElementById('total_harga').value = totalPrice;
    }
 
    document.getElementById('bayar').addEventListener('input', function() {
            const totalHarga = parseFloat(document.getElementById('total_harga').value) || 0;
            const bayar = parseFloat(this.value) || 0;
           
            const totalKembali = bayar - totalHarga;
           
            // Tampilkan total kembali
            document.getElementById('total_kembali').value = totalKembali.toFixed(2);
        });
 
    // Pastikan kondisi awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        updateRemoveButtons();
    });
    </script>
</body>
</html>