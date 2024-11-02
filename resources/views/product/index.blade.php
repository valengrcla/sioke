<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: white;
        }
        .container {
            max-width: 1000px;
        }
        .card-product {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
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
        <h1>Products</h1>
        <button class="btn btn-create"><i class="fas fa-plus"></i> Create Product</button>
    </div>

    <div class="input-group mb-4">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" placeholder="Search Products">
    </div>

    <div class="row">
        @forelse ($product as $Product)
            <div class="col-md-4 mb-4">
                <div class="card-product">
                    <h5 class="mt-3">{{ $Product->nama_product }}</h5>
                    <p class="text-muted">Rp{{ number_format($Product->harga_product, 2) }}</p>
                    <p>{{ $Product->harga_poinproduct }} points</p>
                    <p>Date: {{ \Carbon\Carbon::parse($Product->created_at)->format('d F Y') }}</p>
                    
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('product.edit', $Product->id_product) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form onsubmit="return confirm('Are you sure?');" action="{{ route('product.destroy', $Product->id_product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">No products available.</div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
