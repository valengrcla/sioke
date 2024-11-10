<table>
    <thead>
        <tr>
            <th>ID Nota</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Menu</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report as $data)
            <tr>
                <td>{{ $data->id_nota }}</td>
                <td>{{ $data->tanggalPenjualan }}</td>
                <td>{{ $data->nama_customer }}</td>
                <td>{{ $data->namaMenu }}</td>
                <td>{{ $data->totalQuantity }}</td>
                <td>{{ $data->total_harga }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"><strong>Total Transaksi</strong></td>
            <td colspan="2">{{ $totalTransaksi }}</td>
        </tr>
    </tfoot>
</table>
