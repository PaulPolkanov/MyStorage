<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="/css/styles.css">
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <header>
                <div class="wrap flex">
                    <span> CRM </span>
                    {{-- <img class="" src="https://laravel.com/img/logomark.min.svg" alt="Laravel"> --}}
                    <span> My shope</span>
                </div>
            </header>

            @yield('content')
            
        </div>
    </body>
</html>
