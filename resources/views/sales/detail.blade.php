<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sales</title>
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General page styles */
        body {
            font-family: 'Lusitana', sans-serif;
            background-color: #ECDFCC;
            margin: 0;
            overflow-x: hidden;
        }
 
        .content-wrapper {
            display: flex;
            justify-content: center;
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
        }
 
        .container {
            max-width: 900px;
            margin-top: 2rem;
            padding: 20px;
            background-color: #ffffff; /* Background color for main box */
            color: 697565; /* Text color for better contrast */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
 
        /* Navbar styling */
        .navbar {
            padding: 0.3rem 0.5rem;
            font-size: 1rem;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: top 0.3s;
        }
 
        /* Table styles */
        .table {
            margin-top: 1rem;
            background-color: #ffffff; /* Background color for inner tables */
            border-radius: 8px;
        }
        .table th, .table td {
            padding: 0.75rem;
            border: 1.5px solid #000000;
            color: 697565; /* Text color */
        }
        .table thead th {
            background-color: #697565;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
 
        /* Button styling */
        .btn-back {
            background-color: #697565; /* White background */
            color: #ffffff; /* Text color matching the main container */
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #DEF9C4;
            color: #333;
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')
 
    <div id="navbar" style="position: fixed; top: 0; right: 0; z-index: 1000; width: auto;">
        @include('navbar')
    </div><style>
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
        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            navbar.style.top = scrollTop > lastScrollTop ? "-60px" : "0";
            lastScrollTop = scrollTop;
        });
    </script>
 
    <div class="content-wrapper">
        <div class="container">
            <h1 class="text-center mb-4">Detail Sales</h1>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tr>
                        <th>ID Nota</th>
                        <!-- Access id_nota directly from the sales object -->
                        <td>{{ $sales->id_nota }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($sales->created_at)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $sales->customer->nama_customer }}</td>
                    </tr>
                    <tr>
                        <th>Pengguna</th>
                        <td>{{ $sales->pengguna->nama_pengguna }}</td>
                    </tr>
                    <tr>
                        <th>Product</th>
                        <td>
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Product</th>
                                        <th>Quantity</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop melalui 'detail_sales' yang sudah dimuat dari relasi -->
                                    @foreach($sales->detail_sales as $detail)
                                        <tr>
                                            <!-- Mengakses data nama produk melalui relasi 'product' -->
                                            <td>{{ $detail->product->nama_product }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ number_format($detail->harga, 2, ',', '.') }}</td>
                                            <td>{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>{{ number_format($sales->total_harga, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Pembayaran</th>
                        <td>{{ number_format($sales->total_pembayaran, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Kembalian</th>
                        <td>{{ number_format($sales->total_kembali, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div class="text-center">
                <a href="{{ route('sales.index') }}" class="btn btn-back mt-3">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 