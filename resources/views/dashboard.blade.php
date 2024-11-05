<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <title>Dashboard - Okene Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #FAF3E0;
            margin: 0;
        }

        .main-content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #FFF;
            border: 4px solid #697565;
            border-radius: 10px;
            padding: 15px;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            text-align: center;
            width: 300px;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .card p {
            font-size: 24px;
            margin: 0;
        }

        .row-container {
            display: flex;
            gap: 20px; 
            margin-top: 20px; 
        }

        .chart-container, .sales-container {
            background-color: #FFFFFF;
            border: 7px solid #697565;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            flex: 2; 
            max-width: 60%; 
        }

        .sales-container {
            flex: 1; 
            max-width: 40%; 
        }

        .sales-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sale-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .sale-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .sale-item p {
            margin: 0;
            font-size: 16px;
        }
        .sale-item span {
            font-size: 14px;
            color: #666;
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

    <div class="main-content">
        <h1>Dashboard</h1>
        <h2>{{session('user')->role->nama_role}}</h2>

        <div class="card-container">
            <div class="card">
                <div class="card-title">Jumlah Pendapatan</div>
                <p>Rp {{ number_format($totalPendapatan, 2, ',', '.') }}</p></p>
            </div>
            <div class="card">
                <div class="card-title">Total Sales</div>
                <p>{{ $totalSales }}</p>
            </div>
            <div class="card">
                <div class="card-title">Total Product</div>
                <p>{{ $totalProduct }}</p>
            </div>
            <div class="card">
                <div class="card-title">Total Customer</div>
                <p>{{ $totalCustomer }}</p>
            </div>
        </div>

        <div class="row-container">
            <div class="chart-container">
                <h3>Graphic Sales</h3>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="sales-container">
                <h3>Last Sales</h3>
                <ul class="sales-list">
                    @foreach($lastSales as $sales)
                        <li class="sale-item">
                            <img src="{{ asset('images/customer/' . $sales->customer->customer_img) }}" alt="{{ $sales->customer->nama_customer }}" onerror="this.src='default-profile.png'">
                            <p>{{ $sales->customer->nama_customer }}<br><span>{{ $sales->customer->email_customer }}</span><br>Rp {{ number_format($sales->total_harga, 2, ',', '.') }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Sales',
                        data: @json($monthlySales),
                        backgroundColor: '#3C3D37'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>