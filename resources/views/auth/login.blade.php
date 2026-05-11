<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950">

    <!-- Whole Page Background -->
    <section 
        class="relative flex min-h-screen items-center justify-center bg-cover bg-center bg-no-repeat px-4 py-8"
        style="background-image: url('{{ asset('image/library_bg.jpg') }}');">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-slate-950/55"></div>

        <!-- Main Glass Container -->
        <div class="relative z-10 -mt-8 w-full max-w-5xl overflow-hidden rounded-3xl border border-white/20 bg-white/10 shadow-2xl backdrop-blur-sm">

            <div class="grid min-h-[500px] grid-cols-1 lg:grid-cols-2">

                <!-- Left Side Branding -->
                <div class="flex items-center px-8 py-10 sm:px-12 lg:px-16">
                    <div class="max-w-md text-white">

                        <!-- Logo and System Name -->
                        <div class="mb-7 flex items-center gap-3">
                            <img 
                                src="{{ asset('image/library_logo.jpg') }}"
                                alt="Open Learning Hub Logo"
                                class="h-11 w-11 rounded-full border border-white/40 object-cover shadow-lg">

                            <h2 class="text-xl font-bold tracking-wide drop-shadow">
                                Open Learning Hub
                            </h2>
                        </div>

                        <!-- Main Heading -->
                        <h1 class="text-4xl font-extrabold leading-tight tracking-tight drop-shadow-lg sm:text-5xl">
                            EXPLORE<br>
                            LEARNING
                        </h1>

                        <!-- Short Description -->
                        <p class="mt-5 text-base font-semibold text-white drop-shadow">
                            Access your learning space with ease.
                        </p>

                        <p class="mt-3 max-w-sm text-sm leading-relaxed text-white/85 drop-shadow">
                            Sign in to manage your account, access available resources,
                            and continue your learning activities.
                        </p>

                    </div>
                </div>

                <!-- Right Side Login Card -->
                <div class="flex items-center justify-center px-6 py-10 sm:px-8">

                    <!-- Login Glass Card -->
                    <div class="w-full max-w-sm rounded-3xl border border-white/30 bg-slate-900/25 p-6 shadow-2xl backdrop-blur-xl sm:p-8">

                        <div class="mb-6 text-center">
                            <h1 class="text-2xl font-bold text-white drop-shadow">
                                Login Account
                            </h1>

                            <p class="mt-2 text-sm text-white/80">
                                Welcome back, please sign in to continue
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="mb-5 rounded-xl border border-red-300/40 bg-red-500/25 px-4 py-3 text-sm text-white">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form class="space-y-4" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Username -->
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-white">
                                    Username
                                </label>

                                <input 
                                    type="text"
                                    name="name" 
                                    id="name"
                                    placeholder="admin12345"
                                    required
                                    class="w-full rounded-xl border border-white/40 bg-white/90 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-500 focus:border-blue-400 focus:ring-4 focus:ring-blue-400/30">
                            </div>

                            <!-- Password -->
                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <label for="password" class="block text-sm font-semibold text-white">
                                        Password
                                    </label>

                                    <a href="#" class="text-xs text-white/80 hover:text-white hover:underline">
                                        Forgot password?
                                    </a>
                                </div>

                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    placeholder="••••••••"
                                    required
                                    class="w-full rounded-xl border border-white/40 bg-white/90 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-500 focus:border-blue-400 focus:ring-4 focus:ring-blue-400/30">
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                class="w-full rounded-xl bg-blue-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                LOG IN
                            </button>

                            <!-- Divider -->
                            <div class="flex items-center gap-4">
                                <div class="h-px flex-1 bg-white/30"></div>
                                <span class="text-xs text-white/70">or</span>
                                <div class="h-px flex-1 bg-white/30"></div>
                            </div>

                            <!-- Register Link -->
                            <p class="text-center text-sm text-white/85">
                                Don’t have an account?
                                <a href="{{ route('register') }}" class="font-bold text-white hover:underline">
                                    Register here
                                </a>
                            </p>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </section>

</body>
</html>