<!DOCTYPE html>
<html>
<head>
    <title>{{ config('application.name') }}</title>
</head>
<body>
    <header>
        <!-- Your header content here -->
    </header>

    <nav>
        <!-- Your navigation menu here -->
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Your footer content here -->
    </footer>
</body>
</html>
