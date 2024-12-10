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
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            overflow-x: hidden;
        }
        .btn-create {
            background-color: #697565;
            color: white;
            font-size: 0.9rem;
            padding: 0.4rem 1rem;
            white-space: nowrap;
        }
        .btn-create:hover {
            background-color: #DEF9C4;
        }
        .table thead th {
            background-color: #697565;
            color: white;
            font-weight: normal;
        }
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
        .table {
            background-color: #fff;
            border-radius: 0.5rem;
        }
        .form-control-search {
            /* flex: 0 0 auto; */
            width: 1150px; 
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
                // Scrolling down
                navbar.style.top = "-60px"; 
            } else {
                // Scrolling up
                navbar.style.top = "0"; 
            }
            lastScrollTop = scrollTop; 
        });
    </script>

    <div class="container mt-n1">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div style="margin-top: -50px;">
                <h1>Report</h1>
                <h5>Total Transaksi: {{ $totalTransaksi }}</h5>
            </div>
            
            <div>
                <!-- Filter Form -->
                <form method="GET" action="{{ route('report.index') }}" class="mb-6 d-flex align-items-center gap-2">
                    <!-- Tombol Export -->
                    <a href="{{ route('report.export', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir'), 'search' => request('search')]) }}" class="btn btn-create">Export to Excel</a>
            
                    <!-- Input tanggal awal -->
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            
                    <!-- Input tanggal akhir -->
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            
                    <!-- Tombol Filter -->
                    <button type="submit" class="btn btn-create">Filter</button>
                </form>
            </div>
        </div>

        <form method="GET" action="{{ route('report.index') }}">
            <div class="input-group mb-4">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" name="search" placeholder="Search Report" value="{{ request('search') }}">
                <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
            </div>
        </form>        

        @if(isset($report) && count($report) > 0)
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
                    @foreach($report as $data)
                        <tr>
                            <td>{{ $data->id_nota }}</td>
                            <td>{{ $data->tanggalPenjualan }}</td>
                            <td>{{ $data->nama_customer ?: 'Without Member' }}</td>
                            <td class="color: black;">{{ $data->nama_pengguna }}</td>
                            <td>{{ $data->total_harga }}</td>
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
                                <a href="{{ route('sales.detail', $data->id_nota) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No data available for the selected date range!</p>
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
