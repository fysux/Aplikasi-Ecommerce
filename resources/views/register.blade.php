<div>
    <h1>Register</h1>
    {{-- jika register gagal --}}
    @if ($message = Session::get('error'))
        <p>{{ $message }}</p>
    @endif
    <form action="{{ route('daftar') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nama</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <input type="submit" value="Daftar">
        </div>
    </form>

    <a href="{{ route('login') }}">Login</a>
</div>