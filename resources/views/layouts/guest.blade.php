<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Access — KROSS SHOP' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-brand-white text-brand-black min-h-screen">

    <main class="flex items-center justify-center min-h-screen px-6">
    @yield('content')
</main>


</body>
</html>
