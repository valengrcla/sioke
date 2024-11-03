<!-- resources/views/sidebar.blade.php -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/barongsai.png') }}" alt="Logo Okene Coffee" style="width: 100%; max-width: 150px; margin-bottom: 10px;">
        <h2>Okene Coffee</h2>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="icon"></i>Dashboard</a></li>
            <li><a href="{{ route('pengguna.index') }}" class="{{ request()->is('pengguna*') ? 'active' : '' }} {{ session('user') && session('user')->role->nama_role === 'Owner' ? '' : 'd-none' }}"><i class="icon"></i>Pengguna</a></li>
            <li><a href="{{ route('customer.index') }}" class="{{ request()->is('customer*') ? 'active' : '' }} "><i class="icon"></i>Customer</a></li>
            <li><a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }} {{ session('user') && session('user')->role->nama_role !== 'Pegawai' ? '' : 'd-none' }}"><i class="icon"></i>Product</a></li>
            <li><a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}"><i class="icon"></i>Sales</a></li>
            <li><a href="{{ route('poin.index') }}" class="{{ request()->is('poin*') ? 'active' : '' }}"><i class="icon"></i>Poin</a></li>
            {{-- <li><a href="{{ route('report.index') }}" class="{{ request()->is('report*') ? 'active' : '' }}"><i class="icon"></i>Report</a></li> --}}
        </ul>
        <a href="{{ route('logout') }}" class="logout">Logout</a>
    </div>
</div>

<style>
    body {
        font-family: 'Lusitana', sans-serif;
        display: flex;
        background-color: #ECDFCC;
        margin: 0;
    }
    /* CSS untuk Sidebar */
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
    }
    .sidebar-header {
        background-color: #181C14; /* Warna cokelat tua */
        padding: 20px;
        color: #FFFFFF;
        text-align: center; /* Pusatkan teks dan logo */
    }
    .sidebar h2 {
        font-size: 22px;
        font-weight: bold;
        color: #FFD54F; /* Warna kuning untuk "Okene Coffee" */
        margin-top: 5px;
        margin-bottom: 0px;
    }
    .sidebar-menu {
        background-color: #181C14; /* Warna putih untuk menu */
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
        color: #FFFF; /* Teks putih */
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
        background-color: #FFFF; /* Warna kuning untuk item yang aktif */
        color: #333; /* Teks lebih gelap pada item aktif */
        font-weight: bold;
    }

    .logout {
        color: #FFFF;
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
        width: 100%; /* Menjaga lebar logo penuh, sesuai container */
        max-width: 150px; /* Maksimal lebar logo */
        margin: 0 auto 10px; /* Mengatur jarak bawah logo */
    }
</style>
