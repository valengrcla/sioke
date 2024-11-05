<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Report </h2>
    <form method="GET" action="{{ route('report.view') }}" class="mb-4">
        <div class="row">
            <div class="col-md-5">
                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}" required>
            </div>
            <div class="col-md-5">
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    
    @if(isset($report) && count($report) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Nota</th>
                    <th>Tanggal Penjualan</th>
                    <th>Nama Customer</th>
                    <th>Menu</th>
                    <th>Total Harga</th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report as $data)
                    <tr>
                        <td>{{ $data->id_nota }}</td>
                        <td>{{ $data->tanggalPenjualan }}</td>
                        <td>{{ $data->nama_customer }}</td>
                        <td>{{ $data->namaMenu }}</td>
                        <td>{{ $data->total_harga }}</td>
                        <td>{{ $data->totalQuantity }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total Transaksi</strong></td>
                    <td colspan="2">{{ $totalTransaksi }}</td>
                </tr>
            </tfoot>
        </table>
        <a href="{{ route('report.export') }}?tanggal_awal={{ request('tanggal_awal') }}&tanggal_akhir={{ request('tanggal_akhir') }}" class="btn btn-success">Export to Excel</a>
    @else
        <p>No data available for the selected date range.</p>
    @endif
</div>
</body>
</html>
