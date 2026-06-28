<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

<div class="w-full max-w-md">

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

        <h1 class="text-4xl font-bold text-center text-gray-900">
            Welcome back
        </h1>

        <p class="text-center text-gray-500 mt-2 mb-8">
            Sign in to your account
        </p>

        {{-- Laravel Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="name@example.com"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-2">
                <label class="block text-sm font-medium mb-2">
                    Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember + Forgot -->
            <div class="flex justify-between items-center mt-4 mb-6">

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-gray-600 hover:text-black">
                        Forgot password?
                    </a>
                @endif

            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-black hover:bg-gray-900 text-white py-3 rounded-lg font-semibold transition">
                Sign in
            </button>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-black font-medium hover:underline">
                        Sign up
                    </a>
                </p>
            </div>

        </form>

    </div>

</div>

</body>
</html>