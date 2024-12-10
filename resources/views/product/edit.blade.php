<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
        }
        .form-control {
            background-color: white;
            border: 1px solid #ccc;
        }
        .form-label {
            color: #000000;
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
        <h2 class="mb-4">Product / Edit Product</h2>
        
        <form action="{{ route('product.update', $product->id_product) }}" method="POST" enctype="multipart/form-data" 
              class="border p-4 rounded" 
              style="background-color: #9CA986; min-height: 400px; position: relative; padding-bottom: 20px;">
            @csrf
            @method('PUT')

            <!-- Nama Product -->
            <div class="mb-3">
                <label for="nama_product" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="nama_product" name="nama_product" placeholder="Masukkan Nama Product" value="{{ $product->nama_product }}" required>
                @if ($errors->has('nama_product'))
                    <div class="text-danger">{{ $errors->first('nama_product') }}</div>
                @endif
            </div>

            <!-- Harga Product -->
            <div class="mb-3">
                <label for="harga_product" class="form-label">Price</label>
                <input type="text" class="form-control" id="harga_product" name="harga_product" placeholder="Masukkan Harga Product" value="{{ $product->harga_product }}" required>
                @if ($errors->has('harga_product'))
                    <div class="text-danger">{{ $errors->first('harga_product') }}</div>
                @endif
            </div>

            <!-- Harga Poin Product -->
            <div class="mb-3">
                <label for="harga_poinproduct" class="form-label">Point Price</label>
                <input type="text" class="form-control" id="harga_poinproduct" name="harga_poinproduct" placeholder="Masukkan Harga Poin Product" value="{{ $product->harga_poinproduct }}" required>
                @if ($errors->has('harga_poinproduct'))
                    <div class="text-danger">{{ $errors->first('harga_poinproduct') }}</div>
                @endif
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <label for="product_img" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="product_img" name="product_img" accept="image/*">
                @if ($product->product_img)
                    <img src="{{ asset('images/product/' . $product->product_img) }}" alt="Current Image" class="mt-2" width="100">
                @endif
            </div>

            <div class="d-flex justify-content-between" >
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Edit Product</button>
            </div>
        </form>
    </div>
</body>
</html>
