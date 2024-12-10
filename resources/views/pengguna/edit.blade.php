<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            font-family: 'Lusitana', serif;
        }

        .mb-3 {
            background-color: #9CA986;
            border-radius: 5px;
        }

        .form-control {
            background-color: white;
            border: 1px solid #ccc;
        }

        .form-label {
            color: #000000;
        }

        .btn-secondary {
            background-color: #E63946;
            color: #ffffff; 
            border: none;
        }

        .btn-secondary:hover {
            background-color: #C5283D; 
            color: #ffffff; 
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
    
    <div class="container mt-5 mb-5" style="margin-left: 280px; max-width: 900px; min-height: 700px;">
        <h2 class="mb-4">Pengguna / Edit Pengguna</h2>
        
        <form action="{{ route('pengguna.update', $pengguna->id_pengguna) }}" method="POST" enctype="multipart/form-data"
            class="border p-4 rounded" 
            style="background-color: #9CA986; min-height: 400px; position: relative; padding-bottom: 20px;">
            @csrf
            @method('PUT')
        
            <!-- Nama Pengguna -->
            <div class="mb-3">
                <label for="nama_pengguna" class="form-label">Name</label>
                <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Enter Name" value="{{ $pengguna->nama_pengguna }}" required>
            </div>
        
            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" value="{{ $pengguna->username }}" required>
                @if ($errors->has('username'))
                    <div class="text-danger">{{ $errors->first('username') }}</div>
                @endif
            </div>
        
            <!-- Password -->
            {{-- <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" minlength="8">
                <small class="form-text text-muted">Leave empty if you don't want to change the password</small>
            </div> --}}
        
            <!-- Upload Image -->
            <div class="mb-3">
                <label for="user_img" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="user_img" name="user_img" accept="image/*">
                @if ($pengguna->user_img)
                    <img src="{{ asset('images/pengguna/' . $pengguna->user_img) }}" alt="Current Image" class="mt-2" width="100">
                @endif
            </div>
        
            <!-- Role Selection as Dropdown -->
            <div class="mb-3">
                <label for="id_role" class="form-label">Role</label>
                <select class="form-select" id="id_role" name="id_role" required>
                    <option disabled>Choose Role</option>
                    @foreach ($role as $roles)
                        <option value="{{ $roles->id_role }}" 
                            @if ($pengguna->id_role == $roles->id_role) selected @endif>
                            {{ $roles->nama_role }}
                        </option>
                    @endforeach
                </select>
                @error('id_role')
                    <div class="text-danger">{{ $message }}</div> <!-- Tampilkan pesan error jika ada -->
                @enderror
            </div>
        
            <!-- Submit Button -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Edit Pengguna</button>
            </div>
        </form>
    </div>
</body>
</html>
