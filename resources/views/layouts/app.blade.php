<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meine App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/shorterStyle.css')
</head>
<body>
<header>
    <h1>@yield('title', 'Meine App')</h1>
</header>

<main class="py-4">
    @yield('content')
</main>

<footer>
    &copy; 2026 URL Shortener
</footer>

<!-- Optional Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
