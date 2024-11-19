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
        }
        .container {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            overflow-x: hidden;
        }
        .btn-create {
            background-color: #697565;
            color: white;
            font-size: 0.9rem; /* Reduced font size */
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
    /* Reduce the size of the navbar */
    .navbar {
        padding: 0.3rem 0.5rem;
        font-size: 1rem; /* Adjust font size for a smaller look */
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
        border-radius: 0 0 0.5rem 0.5rem;
        background-color: #fff; /* Add a background color */
        transition: top 0.3s; /* Transition for smooth hiding */
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

<script>
    let lastScrollTop = 0; // Variable to keep track of last scroll position
    const navbar = document.getElementById('navbar'); // Get the navbar element

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop; // Current scroll position

        if (scrollTop > lastScrollTop) {
            // Scrolling down
            navbar.style.top = "-60px"; // Hide the navbar (adjust -60px to the height of your navbar)
        } else {
            // Scrolling up
            navbar.style.top = "0"; // Show the navbar
        }
        lastScrollTop = scrollTop; // Update last scroll position
    });
</script>
<style>
    .mt-n1 {
        margin-top: 2rem;
    }
    /* Tambahkan kelas lain sesuai kebutuhan */
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

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Nota</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Pengguna</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $Sales)
                <tr>
                    <td>{{ $Sales->id_nota }}</td>
                    <td>{{ \Carbon\Carbon::parse($Sales->created_at)->format('d F Y') }}</td>
                    {{-- <td class="text-muted">{{ $Sales->customer->nama_customer }}</td> --}}
                    <td class="text-muted">
                        {{ $Sales->customer ? $Sales->customer->nama_customer : '(Without Member)' }}
                    </td> 
                    <td class="text-muted">{{ $Sales->pengguna->nama_pengguna }}</td>
                    {{-- <td>{{ $Sales->quantity }}</td> --}}
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
