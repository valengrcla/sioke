<table>
    <thead>
        <tr>
            <th>ID Nota</th>
            <th>Date</th>
            <th>Customer</th>
            <th>User</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report as $data)
            @php
                // Ambil detail transaksi dari setiap data
                $details = DB::table('detail_sales')
                    ->join('product', 'detail_sales.id_product', '=', 'product.id_product')
                    ->where('detail_sales.id_nota', $data->id_nota)
                    ->select('product.nama_product', 'detail_sales.quantity', DB::raw('detail_sales.quantity * product.harga_product as subtotal'))
                    ->get();
                $detailCount = $details->count();
            @endphp
           
            @foreach($details as $index => $detail)
                <tr>
                    @if($index == 0)
                        <td rowspan="{{ $detailCount }}">{{ $data->id_nota }}</td>
                        <td rowspan="{{ $detailCount }}">{{ $data->tanggalPenjualan }}</td>
                        <td rowspan="{{ $detailCount }}">{{ $data->nama_customer }}</td>
                        <td rowspan="{{ $detailCount }}">{{ $data->nama_pengguna }}</td>
                    @endif
                    <td>{{ $detail->nama_product }}</td>
                    <td>{{ $detail->quantity }}</td>
                    {{-- <td>{{ number_format($detail->harga, 2, ',', '.') }}</td> --}}
                    <td>{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                    @if($index == 0)
                        <td rowspan="{{ $detailCount }}">{{ number_format($data->total_harga, 2, ',', '.') }}</td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7"><strong>Total Transaksi</strong></td>
            <td ><strong>{{ number_format($totalTransaksi, 2, ',', '.') }}</strong></td>
        </tr>
    </tfoot>
</table>
 
 