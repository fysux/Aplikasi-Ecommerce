<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- ambil data barang yang dipilih, untuk barang_id ada pada route --}}
    @php
        // ambil barang_id yang telah disisipkan diroute
        $barang_id = request()->route('barang_id');
        $barang = App\Models\Barang::find($barang_id);
        // data penjual yang diambil
        $user_id = App\Models\User::find($barang->user_id);
        $user = App\Models\User::find($user_id->user_id);
        $pembeli = Auth::user()->user_id;
    @endphp
    <h1>{{ $barang ->nama }}</h1>
    <img src="{{ asset('./storage/images/'.$barang->gambar) }}" alt="{{ $barang->nama }}" style="max-width: 100px;">
    <p>Stok : {{ $barang->stok }}</p>
    <p>Harga : {{ $barang->harga }}</p>
    <p>Penjual : {{ $user->name }}</p>
    <form action="{{ route('beli', [$pembeli, $barang_id] ) }}" method="post">
        @csrf
        <input type="number" name="qty" value="1">
        <input type="hidden" name="user_id" value="{{ $pembeli }}">
        <input type="hidden" name="barang_id" value="{{ $barang_id }}">
        <input type="hidden" name="harga" value="{{ $barang->harga }}">

        <input type="submit" value="Beli">
    </form>
</body>
</html>