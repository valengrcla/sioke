<!-- resources/views/sales/detail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Detail Sales</h1>
        <table class="table table-bordered">
            <tr>
                <th>ID Nota</th>
                <td>{{ $sales->detail_sales->id_nota }}</td>
                {{-- @dd($sales->id_nota) --}}
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($sales->created_at)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ $sales->customer->nama_customer }}</td>
            </tr>
            <tr>
                <th>Pengguna</th>
                <td>{{ $sales->pengguna->nama_pengguna }}</td>
            </tr>
            <tr>
                <th>Product</th>
                <td>{{ ($sales->product->nama_product) }}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{{ $sales->detail_sales->quantity }}</td>
            </tr>
            <tr>
                <th>Harga</th>
                <td>{{ number_format($sales->detail_sales->harga, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Subtotal</th>
                <td>{{ number_format($sales->detail_sales->subtotal, 2, ',', '.') }}</td>
            </tr>
        </table>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>
