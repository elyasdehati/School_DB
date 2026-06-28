<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

<div class="w-full max-w-md">

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

        <h1 class="text-3xl font-bold text-center text-gray-900">
            Forgot Password
        </h1>

        <p class="text-center text-gray-500 mt-2 mb-8">
            Enter your email to reset password
        </p>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Laravel Forgot Password Form --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6">
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
                    placeholder="name@example.com"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-black hover:bg-gray-900 text-white py-3 rounded-lg font-semibold transition">
                Send Reset Link
            </button>

        </form>

        <!-- Back to login -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}"
               class="text-sm text-gray-600 hover:text-black">
                Back to login
            </a>
        </div>

    </div>

</div>

</body>
</html>