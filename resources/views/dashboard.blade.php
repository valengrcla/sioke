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
        /* CSS Dasar */
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

        /* Card Styling */
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

        /* Chart and Last Sales Containers */
        .row-container {
            display: flex;
            gap: 20px; /* Jarak antara chart dan last sales */
            margin-top: 20px; /* Jarak atas */
        }

        .chart-container, .sales-container {
            background-color: #FFFFFF;
            border: 7px solid #697565;
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
    <!-- Include Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <h1>Dashboard</h1>
        <h2>{{session('user')->role->nama_role}}</h2>

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
                    <!-- Tambahkan penjualan terakhir lainnya -->
                </ul>
            </div>
        </div>
    </div>

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