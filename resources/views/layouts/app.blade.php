{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Okene Coffee</title>
    
    <!-- Tambahkan link ke Chart.js -->
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
                        data: [10, 15, 12, 8, 17, 10, 18, 22, 19, 24, 21, 25],
                        backgroundColor: '#FF6F00'
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
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* CSS Dasar */
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            background-color: #f7f8fa;
            margin: 0;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;

        }
        .sidebar-header {
            background-color: #3E2723; /* Warna cokelat tua */
            padding: 20px;
            color: #FFFFFF;
        }
        .sidebar h2 {
            font-size: 22px;
            font-weight: bold;
            color: #FFC107; /* Warna kuning untuk "Okene Coffee" */
            margin-bottom: 30px;
        }
        /* Style untuk menu */
        .sidebar-menu {
            background-color: #FFFFFF; /* Warna putih untuk menu */
            padding: 20px;
            color: #333;
            height: calc(100vh - 80px); /* Menyesuaikan tinggi agar sidebar pas */
        }
        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .sidebar-menu li a {
            text-decoration: none;
            color: #333;/* Teks putih */
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar-menu li a:hover {
            background-color: #f0f0f0;
            color: #333;
        }
        .sidebar-menu li a.active {
            background-color: #FFC107; /* Warna kuning untuk item yang aktif */
            color: #333; /* Teks lebih gelap pada item aktif */
            font-weight: bold;
        }

        .logout {
            color: #333;
            text-decoration: none;
            display: block;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        .sidebar img {
            width: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
        }
        
        /* Card Styling */
        .card-container {
            background-color: #FFFFFF;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #FFF;
            border: 4px solid #FFC107;
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
        
        /* Chart and Last Sales Containers */
        /* Container untuk menempatkan chart dan last sales berdampingan */
        .row-container {
            display: flex;
            gap: 20px; /* Jarak antara chart dan last sales */
            margin-top: 20px; /* Jarak atas */
        }

        .chart-container, .sales-container {
            background-color: #FFFFFF;
            border: 7px solid #FFC107;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            flex: 2; /* Lebar chart lebih besar */
            max-width: 60%; /* Atur lebar maksimal agar chart lebih kecil */
        }

        .sales-container {
            flex: 1; /* Lebar sales lebih kecil */
            max-width: 40%; /* Atur lebar maksimal agar last sales lebih kecil */
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
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="sidebar-header">
        <h2>Okene Coffee</h2>
    </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="#" class="active"><i class="icon"></i>Dashboard</a></li>
                <li><a href="#"><i class="icon"></i>Pengguna</a></li>
                <li><a href="#"><i class="icon"></i>Customer</a></li>
                <li><a href="#"><i class="icon"></i>Product</a></li>
                <li><a href="#"><i class="icon"></i>Sales</a></li>
                <li><a href="#"><i class="icon"></i>Poin</a></li>
                <li><a href="#"><i class="icon"></i>Report</a></li>
            </ul>
        <a href="#" class="logout">Logout</a>
    </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <h1>Dashboard</h1>
        
        <!-- Card Container -->
        <div class="card-container">
            <div class="card">
                <div class="card-title">Jumlah Pendapatan</div>
                <p>Rp 7.250.000,00</p>
            </div>
            <div class="card">
                <div class="card-title">Total Sales</div>
                <p>75</p>
            </div>
            <div class="card">
                <div class="card-title">Total Product</div>
                <p>10</p>
            </div>
            <div class="card">
                <div class="card-title">Total Customer</div>
                <p>10</p>
            </div>
        </div>
        
        <!-- Chart and Last Sales Containers -->
        <div class="row-container">
            <div class="chart-container">
                <h3>Graphic Sales</h3>
                <canvas id="salesChart"></canvas>
            </div>
            
            <div class="sales-container">
                <h3>Last Sales</h3>
                <ul class="sales-list">
                    <li class="sale-item">
                        <img src="images/profile1.jpg" alt="Emo">
                        <p>Emo<br><span>emo@gmail.com</span><br>Rp 20.000,00</p>
                    </li>
                    <li class="sale-item">
                        <img src="images/profile2.jpg" alt="Eric Chou">
                        <p>Eric Chou<br><span>ericchou@gmail.com</span><br>Rp 42.000,00</p>
                    </li>
                    <!-- Tambahkan penjualan lainnya di sini -->
                </ul>
            </div>
    </div>
</body>
</html> --}}
