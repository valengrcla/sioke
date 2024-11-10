<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Pastikan Font Awesome tersedia -->
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #ECDFCC;
            margin: 0;
            overflow-x: hidden;
        }
        .container {
            margin-left: 280px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
            width: calc(100% - 280px);
            overflow-x: hidden;
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

        .table thead th {
            background-color: #697565;
            color: white;
            font-weight: normal;
        }

        /* Styling navbar agar serupa dengan sales */
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

        /* Styling untuk sidebar agar serupa dengan sales */
        .mt-n1 {
            margin-top: 2rem;
        }
        
        .input-group .form-control {
            height: 38px;
        }

        .input-group-text {
            background-color: #697565;
            color: white;
        }

        /* Tabel lebih konsisten */
        .table {
            background-color: #fff;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')

    <!-- Navbar -->
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

    <div class="container mt-n1">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h1 style="margin-top: -75px;">Report</h1>
            <div>
                <!-- Filter Form -->
                <form method="GET" action="{{ route('report.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-5">
                            <!-- Jika tidak ada tanggal_awal, input tetap kosong -->
                            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-md-5">
                            <!-- Jika tidak ada tanggal_akhir, input tetap kosong -->
                            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-create">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search Report">
        </div>

        @if(isset($report) && count($report) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Nota</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Menu</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report as $data)
                        <tr>
                            <td>{{ $data->id_nota }}</td>
                            <td>{{ $data->tanggalPenjualan }}</td>
                            <td>{{ $data->nama_customer }}</td>
                            <td>{{ $data->namaMenu }}</td>
                            <td>{{ $data->totalQuantity }}</td>
                            <td>{{ $data->total_harga }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total Transaksi</strong></td>
                        <td>{{ $totalTransaksi }}</td>
                    </tr>
                </tfoot>
            </table>
            <a href="{{ route('report.export', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}" class="btn btn-create">Export to Excel</a>
        @else
            <p>No data available for the selected date range.</p>
        @endif
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
