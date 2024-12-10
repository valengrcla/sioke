<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #ECDFCC;
            margin: 0;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .container {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            overflow-x: hidden;
            overflow-y: hidden; 
        height: 100vh;
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
        <h1 style = "margin-top: -75px">Sales</h1>
        <div>
            <a href="{{ route('sales.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Create Sales</a>
        </div>
    </div>

    <form method="GET" action="{{ route('sales.index') }}">
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" name="search" placeholder="Search Sales" value="{{ request()->get('search') }}">
        </div>
    </form>

    <style>
        .table thead th {
            background-color: #697565; 
            color: white;
            font-weight: normal;
        }
    </style>

    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>ID Nota</th>
                <th>Date</th>
                <th>Customer</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $Sales)
                <tr>
                    <td>{{ $Sales->id_nota }}</td>
                    <td>{{ \Carbon\Carbon::parse($Sales->created_at)->format('d F Y') }}</td>
                    <td class="color: black;">
                        {{ $Sales->customer ? $Sales->customer->nama_customer : '(Without Member)' }}
                    </td> 
                    <td class="color: black;">{{ $Sales->pengguna->nama_pengguna }}</td>
                    <td>{{ number_format($Sales->total_harga, 2, ',', '.') }}</td>
                    <td>
                        <style>
                            .btn-info {
                                background-color: #677D6A !important; 
                                color: white;
                                border: none;
                            }
                            .btn-sm:hover {
                                background-color: #DEF9C4 !important; 
                            }
                        </style>
                        <a href="{{ route('sales.detail', $Sales->id_nota) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Sales Available!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
        {{ $sales->links('pagination::bootstrap-5') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
