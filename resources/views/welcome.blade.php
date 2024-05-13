<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ecom</title>
</head>
<body>
    @extends('layouts.index-template')
    
    <aside>
        <ul>
            <li><a href="{{ route('home') }}">Halaman Utama</a></li>
            <li><a href="{{ route('upgrade', Auth::user()->user_id) }}">Tingkatkan Akun</a></li>
            <li><a href="{{ route('upload_barang') }}">Upload Barang</a></li>
            <li><a href="{{ route('tambah_saldo') }}">Tambah Saldo</a></li>
            <li><a href="{{ route('riwayat') }}">Riwayat Transaksi</a></li>
            <li><a href="{{ route('logout') }}">Keluar</a></li>
        </ul>
    </aside>
    <hr>
    <div>
        {{-- Saldo Anda Sekarang --}}
        @php
            $user = Auth::user()->user_id;
            $saldo = App\Models\Saldo::where('user_id', $user)->sum('saldo');
        @endphp
        <p>Saldo Anda Sekarang : {{ $saldo }}</p>
    </div>
    <hr>
    {{-- tampilkan pesan error jika gagal membeli barang --}}
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
        <p>Beli Barang Anda Sekarang!</p>
        <div class="bg-gray-200">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Penjual</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $product)
                            <tr>
                                <td>{{ $product->nama }}</td>
                                <td><img src="{{ asset('./storage/images/'.$product->gambar) }}" alt="{{ $product->nama }}" class="md:h-full md:w-48"></td>
                                <td>{{ $product->user->name }}</td>
                                <td>{{ $product->stok }}</td>
                                <td>{{ $product->harga }}</td>
                                @php
                                    $user_id = $product->user_id;   
                                    $product_id = $product->barang_id;
                                @endphp
                                <td><a href="{{ route('beli' , [$user_id, $product_id])}}">Beli</a></td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>