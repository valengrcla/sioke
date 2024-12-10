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
            background-color: #ffffff; 
            color: 697565; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .navbar {
            padding: 0.3rem 0.5rem;
            font-size: 1rem;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: top 0.3s;
        }
        .table {
            margin-top: 1rem;
            background-color: #ffffff; 
            border-radius: 8px;
            border: 1.5px solid #000000; /* Border tabel luar */
            border-collapse: collapse;
        }
        .table th.text-center, .table td.text-center {
            text-align: center;
            vertical-align: middle;
        }
        .table thead th {
            background-color: #697565;
            color: white;
            text-align: center;
            vertical-align: middle;
            border: 1.5px solid #000000;
        }
        .btn-back {
            background-color: #697565; 
            color: #ffffff;
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
                        <td>{{ $sales->id_nota }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
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
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales->detail_sales as $detail)
                                        <tr>
                                            <td class="text-center">{{ $detail->product->nama_product }}</td>
                                            <td class="text-center">{{ $detail->quantity }}</td>
                                            <td class="text-center">{{ number_format($detail->harga, 2, ',', '.') }}</td>
                                            <td class="text-center">{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>{{ number_format($sales->total_harga, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Payment</th>
                        <td>{{ number_format($sales->total_pembayaran, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Change</th>
                        <td>{{ number_format($sales->total_kembali, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div class="text-center">
                <a href="{{ url()->previous() }}" class="btn btn-back mt-3">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 