<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>
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
        
        /* Menjaga input tetap putih dan border bersih */
        .form-control {
            background-color: white;
            border: 1px solid #ccc;
        }

        /* Mengubah teks label menjadi putih agar kontras */
        .form-label {
            color: #000000;
        }
        .btn-secondary, .btn-primary {
            background-color: #FFD54F;
            color: #000000; /* Dark green text color for contrast */
            border: none;
        }

        /* Hover effect for buttons */
        .btn-secondary:hover, .btn-primary:hover {
            background-color: #DEF9C4; /* Light green hover effect */
            color: #333; /* Darker text color on hover */
        }
    </style>
</head>
<body>
    @include('layouts.sidebar') <!-- Menyertakan sidebar -->
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
    
    
    <!-- Konten utama dengan margin kiri agar tidak tertindih sidebar -->
    <div class="container mt-5 mb-5" style="margin-left: 280px; max-width: 900px; min-height: 700px;">
        <h2 class="mb-4">Customer / Create Customer</h2>
        
        <!-- Formulir dengan posisi relatif dan padding bawah tambahan -->
        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data" 
              class="border p-4 rounded" 
              style="background-color: #9CA986; min-height: 450px; position: relative; padding-bottom: 100px;">
            @csrf
            <div class="mb-3">
                <label for="nama_customer" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_customer" name="nama_customer" placeholder="Enter Customer Name" required>
            </div>
            <div class="mb-3">
                <label for="email_customer" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_customer" name="email_customer" placeholder="Enter Email" required>
                @if ($errors->has('email_customer'))
                    <div class="text-danger">{{ $errors->first('email_customer') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="nohp_customer" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="nohp_customer" name="nohp_customer" placeholder="Enter Phone Number" required>
                @if ($errors->has('nohp_customer'))
                    <div class="text-danger">{{ $errors->first('nohp_customer') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="customer_img" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="customer_img" name="customer_img" accept="image/*">
            </div>
            
            <!-- Menambahkan div absolute untuk menempatkan tombol di bagian bawah -->
            <div class="d-flex justify-content-between" >
                <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Customer</button>
            </div>
        </form>
    </div>
</body>
</html>
