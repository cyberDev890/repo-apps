<x-corona-guest-layout>
    <h3 class="card-title text-center mb-3">INVENTORY BRI JEMBER<br><small class="text-muted mt-2 d-block">Daftar Akun Baru</small></h3>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="text-left w-100">Nama Lengkap *</label>
            <input type="text" name="name" class="form-control p_input text-white" value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="form-group">
            <label class="text-left w-100">Email *</label>
            <input type="email" name="email" class="form-control p_input text-white" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="form-group">
            <label class="text-left w-100">Password *</label>
            <input type="password" name="password" class="form-control p_input text-white" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="form-group">
            <label class="text-left w-100">Konfirmasi Password *</label>
            <input type="password" name="password_confirmation" class="form-control p_input text-white" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-block enter-btn">Daftar</button>
        </div>
        
        <p class="sign-up text-center mt-4">Sudah punya akun? <a href="{{ route('login') }}"> Login</a></p>
    </form>
</x-corona-guest-layout>
