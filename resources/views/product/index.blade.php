<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #E8E8E8;
            margin: 0;
            overflow-x: hidden;
            /* overflow-y: hidden; */
        }
        .container {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            /* overflow-x: hidden; */
            overflow-y: hidden;
        }
        .card-product {
            background-color: #FFFF;
            border: 3px solid #697565;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px;
            height: 250px; 
            position: relative;
        }
        .button-container {
            position: absolute; 
            bottom: 10px; 
            right: 10px; 
            display: flex;
            gap: 5px; 
        }
        .card-product img {
            border-radius: 10%;
            width: 125px;
            height: 135px;
            object-fit: cover;
        }
        .btn-create {
            background-color: #697565;
            color: white;
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }
        .btn-create:hover {
            background-color: #DEF9C4;
        }
        h5 {
            font-size: 0.9rem;
        }
        p {
            font-size: 0.9rem;
            margin: 0.2rem 0;
        }
        .btn-sm {
            padding: 0.3rem 0.5rem;
        }
        .input-group-text {
            background-color: #697565;
            color: white;
        }
    </style>
</head>
<body>
@include ('layouts.sidebar')
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
<style>
    .mt-n1 {
        margin-top: 2rem;
    }
</style>
<div class="container mt-n1">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h1 style = "margin-top: -75px">Products</h1>
        <div>
            <a href="{{ route('product.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Create Product</a>
        </div>
    </div>

    <form method="GET" action="{{ route('product.index') }}">
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" name="search" value="{{ request()->query('search') }}" class="form-control" placeholder="Search Products">
        </div>
    </form>

    <div class="row">
        @forelse ($product as $Product)
            <div class="col-lg-2 col-md-3 mb-4 mx-3">
                <div class="card-product">
                    <img src="{{ asset('images/product/' . $Product->product_img) }}" alt="">
                    <h5 class="mt-1 mb-2 text-muted fw-bold">{{ $Product->nama_product }}</h5>
                    <p class="text-muted text-start">Rp{{ number_format($Product->harga_product, 2) }}</p>
                    <p class="text-start"> {{ $Product->harga_poinproduct }} points</p>
                    {{-- <p class="text-start">Date: {{ \Carbon\Carbon::parse($Product->created_at)->format('d F Y') }}</p> --}}
                    
                    <div class="button-container">
                        <a href="{{ route('product.edit', $Product->id_product) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('product.delete', $Product->id_product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger delete-btn {{ session('user') && session('user')->role->nama_role === 'Owner' ? '' : 'd-none' }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">No Products Available!</div>
            </div>
        @endforelse
    </div>
    {{-- <div class="d-flex justify-content-center mt-4">
        {{ $product->links('pagination::bootstrap-5') }}
    </div> --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Are you sure to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                width: '320px',  
                heightAuto: false,  
                customClass: {
                    popup: 'small-popup' 
                },
                padding: '15px',  
                backdrop: 'rgba(0, 0, 0, 0.4)',  
                didOpen: () => {
                    
                    const title = Swal.getTitle();
                    const icon = Swal.getIcon();
                    const actions = Swal.getActions();

                    title.style.fontSize = '1.3rem';  
                    icon.style.width = '50px';  
                    icon.style.height = '50px';  
                    actions.querySelectorAll('button').forEach(button => {
                        button.style.fontSize = '1rem';  
                        button.style.padding = '5px 15px';  
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = button.closest('form');
                    form.submit();
                }
            });
        });
    });
</script>

{{-- <style>
    .swal2-popup.small-popup {
        height: 200px; /* Tinggi pop-up lebih kecil */
        width: 320px;
        font-size: 0.9rem; /* Mengatur ukuran teks lebih kecil */
        padding-bottom: 20px;
    }
    .swal2-title {
        font-size: 1.3rem; /* Ukuran judul lebih kecil */
        margin-bottom: 10px;
    }
    .swal2-icon {
        width: 50px; /* Ukuran ikon lebih kecil */
        height: 50px;
        margin: 10px auto;
    }
    .swal2-actions button {
        font-size: 1rem; /* Ukuran font tombol lebih kecil */
        padding: 5px 15px; /* Padding tombol lebih kecil */
        border-radius: 5px; /* Membulatkan tombol sedikit */
    }
</style> --}}

<script>
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "SUCCESS",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "FAILED!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

</body>
</html>
