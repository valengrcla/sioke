<!-- Navbar Blade -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="max-width: 180px; padding: 0.3rem 0.5rem; border-radius: 0.5rem;">
    <div class="container-fluid">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto">
            <!-- User Profile Information -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- Profile Picture -->
                    <img src="{{ session('user.profile_picture') }}" alt="Profile Picture" class="rounded-circle" width="30" height="30" style="object-fit: cover; margin-right: 8px;">
                    
                    <!-- Username and Role -->
                    <div class="d-flex flex-column text-start">
                        <span>{{ session('user.username') }}</span>
                        <small class="text-muted">{{ session('user.role.name') }}</small>
                    </div>
                </a>
                
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
