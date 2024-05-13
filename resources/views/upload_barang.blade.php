@if (Auth::check() == false)
    <script>
        alert('Anda Harus Login Terlebih Dahulu !');
        window.location.href = "{{ route('login') }}";
    </script>
@endif

@if(Auth::check() == true)
<aside>
    <ul>
        <li><a href="{{ route('home') }}">Halaman Utama</a></li>
        <li><a href="{{ route('upgrade', Auth::user()->user_id) }}">Tingkatkan Akun</a></li>
        <li><a href="{{ route('upload_barang') }}">Upload Barang</a></li>
        <li><a href="{{ route('tambah_saldo') }}">Tambah Saldo</a></li>
        <li><a href="{{ route('logout') }}">Keluar</a></li>
    </ul>
</aside>
{{-- tambahkan session jika upload berhasil --}}
@if (session('success'))
    <script>
        alert('Data Barang Berhasil Ditambahkan');
        window.location.href = "{{ route('upload') }}";
    </script>
@endif
<div>
    {{-- cek apakah user telah menjadi user master --}}
    @php
        $userMaster = Auth::user()->user_master;
    @endphp

    @if ($userMaster)
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}" >
        <div>
            <label for="name">Nama</label>
            <input type="text" name="nama" id="name">
        </div>
        <div>
            <label for="image">Gambar</label>
            <input type="file" name="gambar" id="image">
        </div>
        <div>
            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok">
        </div>
        <div>
            <label for="price">Harga</label>
            <input type="number" name="harga" id="price">
        </div>
        <div>
            <input type="submit" value="Upload">
        </div>
    </form>
@endif

@if ($userMaster == null)
    <p>Anda Masih User Biasa !</p>
    <a href="{{ route('upgrade', Auth::user()->user_id) }}">Tingkatkan Akun</a>
@endif

</div>
@endif