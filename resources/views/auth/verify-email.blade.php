<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('upload/logo/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

<div class="w-full max-w-md">

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

        <h1 class="text-3xl font-bold text-center text-gray-900">
            Verify Email
        </h1>

        <p class="text-center text-gray-500 mt-2 mb-6">
            Check your email for verification link
        </p>

        <!-- Status Message -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm text-green-600 text-center">
                A new verification link has been sent to your email.
            </div>
        @endif

        <!-- Info Text -->
        <div class="mb-6 text-sm text-gray-600 text-center">
            Thanks for signing up! Please verify your email before continuing.
        </div>

        <!-- Resend Email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button
                type="submit"
                class="w-full bg-black hover:bg-gray-900 text-white py-3 rounded-lg font-semibold transition">
                Resend Verification Email
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf

            <button
                type="submit"
                class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Log Out
            </button>
        </form>

    </div>

</div>

</body>
</html>