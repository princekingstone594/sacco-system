<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 relative">

        <!-- BACKGROUND EFFECT -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-500 opacity-20 blur-2xl"></div>

        <!-- LOGIN CARD -->
        <div class="relative w-full max-w-md mx-auto bg-white rounded-2xl shadow-xl p-8 space-y-6">

            <!-- HEADER -->
            <div class="text-center space-y-2">
                <h1 class="text-3xl font-bold text-gray-800">
                    👑 Royalty Sacco
                </h1>
                <p class="text-sm text-gray-500">
                    Welcome back — sign in to your account
                </p>
            </div>

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email"
                        class="block w-full mt-1 rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1"/>
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password" />

                    <div class="relative mt-1">
                        <input id="password"
                            type="password"
                            name="password"
                            required
                            class="block w-full rounded-lg border-gray-300 pr-10 focus:ring-2 focus:ring-indigo-500">

                        <!-- Toggle Button -->
                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

                            <!-- Eye Icon -->
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-1"/>
                </div>

                <!-- OPTIONS -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600">
                        <span class="text-gray-600">Remember me</span>
                    </label>

                    <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
                        Forgot password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-semibold transition">
                    Sign In
                </button>

                <!-- FOOTER -->
                <p class="text-center text-sm text-gray-500">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                        Create one
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- TOGGLE SCRIPT -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.293 5.042M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
                `;
            } else {
                password.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</x-guest-layout>