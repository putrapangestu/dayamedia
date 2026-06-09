<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    <title>@yield('title', 'Daya Media')</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    @stack('meta')
    
    <link href="{{ asset('') }}assets/landing/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="{{ asset('') }}assets/landing/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/landing/css/styles.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased flex h-full text-base text-foreground bg-white">
    <div class="flex grow flex-col">
        <main class="grow flex flex-col" id="content" role="content">
            @yield('content')
            @include('landing.partials.footer')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('js')
</body>
</html>
