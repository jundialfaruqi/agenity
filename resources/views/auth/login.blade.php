<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - {{ $appSetting->app_name ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-theme', 'night');
        }
    </script>
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center font-sans text-base-content relative">
    <!-- Theme Toggle -->
    <div class="absolute top-4 right-4">
        <button id="theme-toggle" class="btn btn-ghost btn-circle btn-sm">
            <!-- Sun Icon -->
            <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
            <!-- Moon Icon -->
            <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
            </svg>
        </button>
    </div>

    <div class="w-full max-w-sm p-6">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-2 text-secondary font-bold text-3xl">
                @if ($appSetting && $appSetting->app_logo)
                    <img src="{{ $appSetting->app_logo_url }}" class="w-10 h-10 object-contain" alt="Logo">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                        <path fill-rule="evenodd"
                            d="M14.615 1.595a.75.75 0 01.359.852L12.982 9.75h7.268a.75.75 0 01.548 1.262l-10.5 11.25a.75.75 0 01-1.272-.71l1.992-7.302H3.75a.75.75 0 01-.548-1.262l10.5-11.25a.75.75 0 01.913-.143z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
                <span>{{ $appSetting->app_name ?? config('app.name') }}</span>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl border border-base-200 rounded-2xl">
            <div class="card-body">
                <div class="text-center mb-4 border-base-300 border-b border-dashed">
                    <h2 class="text-2xl font-bold">{{ $appSetting->login_title ?? 'Welcome Back' }}</h2>
                    <p class="text-base-content/60 text-xs mt-1 mb-4">
                        {{ $appSetting->login_description ?? 'Enter your credentials to access your account' }}</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-soft max-sm:alert-vertical alert-error text-xs font-bold mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="text-sm">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.perform') }}" method="POST" class="space-y-2">
                    @csrf
                    <!-- Email -->
                    <div class="form-control mb-4">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Email Address</span>
                        </label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="name@example.com"
                                class="input input-bordered w-full pl-10 rounded-lg h-11" />
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/60">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                    <path
                                        d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                </svg>
                            </span>
                        </div>
                        @error('email')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-control mb-6">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Password</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password-input" placeholder="••••••••"
                                class="input input-bordered w-full pl-10 pr-10 rounded-lg h-11" />
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/60">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <button type="button" id="password-toggle"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/60 hover:text-secondary transition-colors">
                                <!-- Eye Icon -->
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <!-- Eye Slash Icon -->
                                <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                        <label class="label justify-end mt-2">
                            <a href="#" class="label-text-alt link link-hover font-medium underline">
                                Forgot password?
                            </a>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="form-control">
                        <button type="submit"
                            class="btn btn-secondary w-full text-white shadow-lg shadow-secondary/30 rounded-lg gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Version -->
        <div class="text-center mt-8 text-xs text-base-content/40">
            <p class="font-medium">{{ $appSetting->app_name ?? config('app.name') }} Web App</p>
            <p>Version 1.0.0</p>
        </div>
    </div>
    <script>
        document.getElementById('password-toggle').addEventListener('click', function() {
            const input = document.getElementById('password-input');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    </script>
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
</body>

</html>
