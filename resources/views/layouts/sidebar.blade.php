<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/barongsai.png') }}" alt="Logo Okene Coffee" style="width: 100%; max-width: 150px; margin-bottom: 10px;">
        <h2>Okene Coffee</h2>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="fas fa-home" style="margin-right: 10px;"></i>Dashboard</a></li>
            <li><a href="{{ route('pengguna.index') }}" class="{{ request()->is('pengguna*') ? 'active' : '' }} {{ session('user') && session('user')->role->nama_role === 'Owner' ? '' : 'd-none' }}"><i class="fas fa-users" style="margin-right: 10px;"></i>Pengguna</a></li>
            <li><a href="{{ route('customer.index') }}" class="{{ request()->is('customer*') ? 'active' : '' }}"><i class="fas fa-user" style="margin-right: 10px;"></i>Customer</a></li>
            <li><a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }} {{ session('user') && session('user')->role->nama_role !== 'Pegawai' ? '' : 'd-none' }}"><i class="fas fa-box" style="margin-right: 10px;"></i>Product</a></li>
            <li><a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}"><i class="fas fa-shopping-cart" style="margin-right: 10px;"></i>Sales</a></li>
            <li><a href="{{ route('poin.index') }}" class="{{ request()->is('poin*') ? 'active' : '' }}"><i class="fas fa-coins" style="margin-right: 10px;"></i>Poin</a></li>
            {{-- <li><a href="{{ route('report.index') }}" class="{{ request()->is('report*') ? 'active' : '' }}"><i class="icon" style="margin-right: 10px;"></i>Report</a></li> --}}
        </ul>
        
        <a href="{{ route('logout') }}" class="logout"><i class="fas fa-sign-out-alt"></i></a>
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
        background-color: #181C14; /
        padding: 30px;
        color: #FFFFFF;
        text-align: center; 
    }
    .sidebar h2 {
        font-size: 22px;
        font-weight: bold;
        color: #FFD54F; 
        margin-top: 5px;
        margin-bottom: 0px;
    }
    .sidebar-menu {
        background-color: #181C14; 
        padding: 20px;
        color: #333;
        height: calc(100vh - 80px); 
    }
    .sidebar-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        padding-top: 30px;
    }
    .sidebar-menu li {
        margin-bottom: 15px;
        font-size: 16px;
    }
    .sidebar-menu li a {
        text-decoration: none;
        color: #FFD54F; 
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .sidebar-menu li a:hover {
        background-color: #FFD54F;
        color: #333;
    }
    .sidebar-menu li a.active {
        background-color: #FFD54F; 
        color: #333; 
        font-weight: bold;
    }

    .logout {
        color: #FFD54F;
        text-decoration: none;
        display: flex;
        justify-content: center; 
        align-items: center; 
        width: 50px; 
        height: 50px; 
        margin: 20px auto; 
        padding: 10px; 
        border-radius: 5px; 
        transition: background-color 0.3s, transform 0.3s; 
        font-size: 18px;
    }

    .logout:hover {
        background-color: #FFD54F;
        color: #333;
    }

    .sidebar img {
        width: 100%; 
        max-width: 150px; 
        /* margin: 0 auto 10px;  */
        margin-top: 35px;
    }
</style>
