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
<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
    <h1>Tambah Saldo</h1>
    {{-- jika berhasil --}}
    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
            window.location.href = "{{ route('home') }}";
        </script>
    @endif
    @php
        $user = Auth::user()->user_id;
        $user_ = Auth::user();
        $saldo = App\Models\Saldo::where('user_id', $user)->sum('saldo');
    @endphp
    {{-- Jika user sudah punya saldo --}}
    @if ($saldo)
        <div>
            <p>Saldo Anda Sekarang : {{ $saldo }}</p>
        </div>
    @endif
    
    <form action="{{ route('tambah_uang') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" id="id" value="{{ $user_->user_id }}">
        <div>
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" value="{{ $user_->name }}" readonly>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="{{ $user_->email }}" readonly>
        </div>
        <div>
            <label for="balance">Saldo</label>
            <input type="number" name="saldo" id="balance">
        </div>
        <div>
            <input type="submit" value="Tambah Saldo">
        </div>
    </form>
</div>
@endif
