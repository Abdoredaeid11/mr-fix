
    <!DOCTYPE html>
    <html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <!-- تضمين Tailwind CSS من CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- إعدادات Tailwind للوضع الداكن -->
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            indigo: {
                                500: '#6366f1',
                                600: '#4f46e5',
                            }
                        }
                    }
                }
            }
        </script>

        <!-- أيقونات Heroicons (اختياري) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            /* يمكن إضافة أي أنماط مخصصة هنا */
            .dark .dark\:bg-gray-800 {
                background-color: #1f2937;
            }
            .dark .dark\:bg-gray-900 {
                background-color: #111827;
            }
            .dark .dark\:text-gray-100 {
                color: #494949;
            }
            .dark .dark\:text-gray-400 {
                color: #9ca3af;
            }
            .dark .dark\:border-gray-600 {
                border-color: #4b5563;
            }
        </style>
    </head>
    <body class="h-full">
        <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <div>
                    <img class="mx-auto h-21 w-auto" src="{{ asset('assets/img/mr-fix.png') }}" alt="Your Logo">
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100">Welcome Back!</h2>
                    <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                        Sign in to your account
                    </p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Email address">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Password">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="remember_me" class="ms-2 block text-sm text-gray-900 dark:text-gray-100">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Forgot your password?
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            Log In
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- تضمين Alpine.js للوظائف التفاعلية (اختياري) -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- نص JavaScript مخصص -->
        <script>
            // تفعيل الوضع الداكن إذا كان مفعل في localStorage
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // يمكن إضافة أي وظائف JavaScript مخصصة هنا
        </script>
    </body>
    </html>
