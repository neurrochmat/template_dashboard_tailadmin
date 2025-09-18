<!doctype html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Login | TailAdmin</title>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-sky-600 to-teal-500">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-10">
        <div class="absolute inset-0 bg-grid-white/[0.08] [mask-image:radial-gradient(ellipse_at_center,white,transparent_60%)]"></div>

        <div class="relative z-10 mx-auto w-full max-w-md">
            <div class="mb-6 flex items-center justify-center gap-3">
                <img class="h-10 w-10" src="{{ asset('assets/images/logo/logo-icon.svg') }}" alt="Logo" />
                <div class="text-white">
                    <h1 class="text-2xl font-bold leading-tight">TailAdmin</h1>
                    <p class="text-white/80 text-sm">Admin Dashboard</p>
                </div>
            </div>

            <div class="rounded-2xl bg-white/95 p-6 shadow-2xl ring-1 ring-white/10 backdrop-blur-md dark:bg-gray-900/95">
                <h2 class="mb-1 text-center text-2xl font-semibold text-gray-900 dark:text-white">Welcome back</h2>
                <p class="mb-6 text-center text-gray-500 dark:text-gray-400">Sign in to your account</p>

                @if($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/40 dark:text-red-200">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/login" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required
                                         class="peer w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white" placeholder="you@example.com">
                            <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12H8m8-4H8m8 8H8m-5 2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                         class="peer w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white" placeholder="••••••••" />
                            <button type="button" onclick="const el=document.getElementById('password'); el.type = el.type==='password' ? 'text' : 'password'" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" aria-label="Toggle password">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                    </div>

                    <button type="submit" class="group relative inline-flex w-full items-center justify-center overflow-hidden rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                        <span class="absolute inset-0 h-full w-full translate-y-10 bg-gradient-to-t from-white/20 to-white/0 opacity-0 transition duration-300 ease-out group-hover:translate-y-0 group-hover:opacity-100"></span>
                        <span class="relative">Sign In</span>
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-gray-500">
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">Create an account</a>
                </div>
            </div>

            <p class="mt-6 text-center text-white/80 text-xs">© {{ date('Y') }} TailAdmin. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
