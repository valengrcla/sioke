<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #E8E8E8;
            margin: 0;
            overflow-x: hidden;
        }
        .container {
            margin-left: 280px; /* Sama dengan dashboard */
            padding: 20px;
            width: calc(100% - 280px);
            overflow-x: hidden;
        }
        .card-customer {
            background-color: #FFFF;
            border: 3px solid #697565;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card-customer img {
            border-radius: 50%;
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
        .btn-create {
            background-color: #FFD43B;
            color: white;
            font-weight: bold;
        }
        .btn-create:hover {
            background-color: #ffc107;
        }
    </style>
</head>
<body>
@include ('layouts.sidebar')
<div style="position: fixed; top: 0; right: 0; z-index: 1000; width: auto;">
    @include ('navbar')
</div>
<style>
    /* Reduce the size of the navbar */
    .navbar {
        padding: 0.3rem 0.5rem;
        font-size: 0.9rem; /* Adjust font size for a smaller look */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 0 0 0.5rem 0.5rem;
    }

    /* Adjust navbar items to fit the smaller size */
    .navbar-nav .nav-link {
        padding: 0.2rem 0.5rem;
    }

    /* Adjust the profile picture size */
    .navbar img {
        width: 25px;
        height: 25px;
        margin-right: 5px;
    }
    
</style>
<style>
    .mt-n1 {
        margin-top: 2rem;
    }
    /* Tambahkan kelas lain sesuai kebutuhan */
</style>
<div class="container mt-n1">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h1>Customer</h1>
        <button class="btn btn-create"><i class="fas fa-plus"></i> Create Customer</button>
    </div>

    <div class="input-group mb-4">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" placeholder="Search Customers">
    </div>

    <div class="row">
        @forelse ($customer as $Customer)
            <div class="col-md-3 mb-4">
                <div class="card-customer">
                    <img src="{{ asset('images/customer/' . $Customer->customer_img) }}" alt="" width="100">
                    <h5 class="mt-3">{{ $Customer->nama_customer }}</h5>
                    <p class="text-muted">{{ $Customer->email_customer }}</p>
                    <p>{{ $Customer->nohp_customer }}</p>
                    <p>Total Poin: {{ $Customer->totalpoin_customer }}</p>
                    <p>Date: {{ \Carbon\Carbon::parse($Customer->created_at)->format('d F Y') }}</p>
                    
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('customer.edit', $Customer->id_customer) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('customer.delete', $Customer->id_customer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger {{ session('user') && session('user')->role->nama_role === 'Owner' ? '' : 'd-none' }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Data Customer belum tersedia.</div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

</body>
</html>
