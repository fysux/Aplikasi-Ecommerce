<div>
    <a href="{{ route('home') }}">Kembali</a>
    <h1>Riwayat Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pembelian</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $riwayat = App\Models\Transaksi::where('user_id', Auth::user()->user_id)->get();
            @endphp
            @foreach ($riwayat as $riwayat)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $riwayat->barang->nama }}</td>
                    <td>{{ $riwayat->created_at }}</td>
                    <td>{{ $riwayat->total_harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
