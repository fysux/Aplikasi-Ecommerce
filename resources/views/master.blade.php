@if (Auth::check() == false)
    <script>
        alert('Anda Harus Login Terlebih Dahulu !');
        window.location.href = "{{ route('login') }}";
    </script>
@endif

@if (Auth::check() == true)
<aside>
    <ul>
        <li><a href="{{ route('home') }}">Halaman Utama</a></li>
        <li><a href="{{ route('upgrade', Auth::user()->user_id) }}">Tingkatkan Akun</a></li>
        <li><a href="{{ route('upload_barang') }}">Upload Barang</a></li>
        <li><a href="{{ route('tambah_saldo') }}">Tambah Saldo</a></li>
        <li><a href="{{ route('logout') }}">Keluar</a></li>
    </ul>
</aside>
<div>
    
    <!-- Be present above all else. - Naval Ravikant -->
    <h1>Tingkatkan Akun</h1>
    @php
        $userMaster = Auth::user()->user_master; 
    @endphp
    @if($userMaster)
        <script>
            alert('Anda sudah menjadi User Master !');
            window.location.href = "{{ route('home') }}";
        </script>
    @endif

    @if (is_null(Auth::user()->user_master))
        <p>Anda Masih User Biasa !</p>            
    @endif

<form action="{{ route('upgrade') }}" method="POST">
    @csrf
    {{-- <div>
        <input type="hidden" name="user_master_id" id="id" value="{{ auth()->user_master()->getAttribute('user_master_id') }}">
    </div> --}}
    <div>
        <input type="hidden" name="user_id" id="id" value="{{ auth()->user()->getAttribute('user_id') }}">
    </div>
    <div>
        <label for="name">Nama</label>
        <input type="text" name="name" id="name" value="{{ auth()->user()->getAttribute('name') }}" readonly>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ auth()->user()->getAttribute('email') }}" readonly>
    </div>
    <div>
        <input type="submit" value="Tingkatkan">
    </div>
</form>

</div>
@endif
