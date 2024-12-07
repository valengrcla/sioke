<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #E8E8E8;
            margin: 0;
            overflow-x: hidden;
        }

        .container {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            overflow-x: hidden;
        }

        .card-pengguna {
            background-color: #FFFF;
            border: 3px solid #697565;
            border-radius: 10px;
            padding: 15px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            height: 250px; 
        }

        .card-pengguna img {
            border-radius: 50%;
            width: 50px; 
            height: 50px; 
            object-fit: cover;
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
        
        .card-pengguna h5 {
            font-size: 1rem; 
            margin: 0.5rem 0; /
        }
        .card-pengguna p {
            font-size: 0.85rem; 
            margin: 0.3rem 0; 
        }

        .input-group-text {
            background-color: #697565;
            color: white;
        }
    </style>
</head>
<body>
@include ('layouts.sidebar')
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
<style>
    .mt-n1 {
        margin-top: 2rem;
    }
</style>
<div class="container mt-n1">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h1 style = "margin-top: -75px;">Pengguna</h1>
        <div>
            <a href="{{ route('pengguna.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Create Pengguna</a>
        </div>
    </div>

    <form method="GET" action="{{ route('pengguna.index') }}">
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Search Pengguna" value="{{ request('search') }}">
        </div>
    </form>

    <div class="row">
        @forelse ($pengguna as $Pengguna)
            <div class="col-md-3 mb-4">
                <div class="card-pengguna">
                    <img src="{{ asset($Pengguna->user_img ? 'images/pengguna/' . $Pengguna->user_img : 'images/image_default.jpg') }}" alt="">
                    <h5 class="mt-2 fw-bold" style="margin-bottom: 0;">{{ $Pengguna->nama_pengguna }}</h5>
                    <p class="text-muted" style="margin-top: 0; margin-bottom: 0;">{{ $Pengguna->role->nama_role }}</p>
                    <p class="text-start">Username: {{ $Pengguna->username }}</p>
                    <p class="text-start">Password: *****</p>
                    <p class="text-start">Date: {{ \Carbon\Carbon::parse($Pengguna->created_at)->format('d F Y') }}</p>

                    <div class="d-flex justify-content-center mt-2">
                        <a href="{{ route('pengguna.edit', $Pengguna->id_pengguna) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pengguna.delete',  $Pengguna->id_pengguna) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">No Users Available!</div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Are you sure to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                width: '320px',  
                heightAuto: false,  
                customClass: {
                    popup: 'small-popup' 
                },
                padding: '15px',  
                backdrop: 'rgba(0, 0, 0, 0.4)',  
                didOpen: () => {
                    
                    const title = Swal.getTitle();
                    const icon = Swal.getIcon();
                    const actions = Swal.getActions();

                    title.style.fontSize = '1.3rem';  
                    icon.style.width = '50px';  
                    icon.style.height = '50px';  
                    actions.querySelectorAll('button').forEach(button => {
                        button.style.fontSize = '1rem';  
                        button.style.padding = '5px 15px';  
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = button.closest('form');
                    form.submit();
                }
            });
        });
    });
</script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "SUCCESS",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "FAILED!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

</body>
</html>
