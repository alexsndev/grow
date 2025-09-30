

<div class="login-bg">
    <div class="login-card">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-purple-300" />
                <x-text-input id="email" class="block mt-1 w-full bg-[rgba(44,44,84,0.7)] text-white border-[#7209b7] focus:border-[#4361ee] focus:ring-2 focus:ring-[#4361ee44] rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-pink-400" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-purple-300" />
                <x-text-input id="password" class="block mt-1 w-full bg-[rgba(44,44,84,0.7)] text-white border-[#7209b7] focus:border-[#4361ee] focus:ring-2 focus:ring-[#4361ee44] rounded-lg" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-pink-400" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-blue-300 hover:text-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="primary-btn ml-3">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</div>
