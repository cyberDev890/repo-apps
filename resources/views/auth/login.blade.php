<x-corona-guest-layout>
    <h3 class="card-title text-center mb-3">INVENTORY BRI JEMBER</h3>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="text-left w-100">Email *</label>
            <input type="email" name="email" class="form-control p_input text-white" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="form-group">
            <label class="text-left w-100">Password *</label>
            <input type="password" name="password" class="form-control p_input text-white" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="form-group d-flex align-items-center justify-content-between">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" name="remember" class="form-check-input"> Ingat Saya 
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-pass">Lupa password?</a>
            @endif
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
        </div>
        
        @if (Route::has('register'))
        <p class="sign-up text-center mt-4">Belum punya akun? <a href="{{ route('register') }}"> Daftar</a></p>
        @endif
    </form>
</x-corona-guest-layout>
