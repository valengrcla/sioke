<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Poin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: white;
        }
        .container {
            max-width: 1000px;
        }
        .btn-create {
            background-color: #FFD43B;
            color: white;
            font-weight: bold;
        }
        .btn-create:hover {
            background-color: #ffc107;
        }
    </style>
</head>
<body>
@include ('layouts.sidebar')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h1>Poin</h1>
        <button class="btn btn-create"><i class="fas fa-plus"></i> Penukaran</button>
    </div>

    <div class="input-group mb-4">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" placeholder="Search Poin">
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Poin</th>
                <th>Tanggal</th>
                <th>Nama Customer</th>
                <th>Aktivitas</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($poin as $Poin)
                <tr>
                    <td>{{ $Poin->id_poin }}</td>
                    <td>{{ \Carbon\Carbon::parse($Poin->created_at)->format('d F Y') }}</td>
                    <td class="text-muted">{{ $Poin->customer->nama_customer }}</td>
                    <td>{{ $Poin->aktivitas }}</td>
                    <td>{{ $Poin->poin }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data Poin belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

</body>
</html>
