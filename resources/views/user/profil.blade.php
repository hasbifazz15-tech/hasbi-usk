
<hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

<h2>Ganti Password</h2>

<p class="description">
    Masukkan password lama dan password baru kamu.
</p>

@if (session('password_success'))
    <div class="success">
        {{ session('password_success') }}
    </div>
@endif

<form action="{{ route('user.profil.password') }}" method="POST">
    @csrf
    @method('PUT')

    <label for="current_password">Password lama</label>
    <input
        type="password"
        id="current_password"
        name="current_password"
        autocomplete="current-password"
        required
    >
    @error('current_password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password">Password baru</label>
    <input
        type="password"
        id="password"
        name="password"
        minlength="8"
        autocomplete="new-password"
        required
    >
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="password_confirmation">Konfirmasi password baru</label>
    <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        minlength="8"
        autocomplete="new-password"
        required
    >

    <button type="submit" class="btn">
        Simpan Password Baru
    </button>
</form>
