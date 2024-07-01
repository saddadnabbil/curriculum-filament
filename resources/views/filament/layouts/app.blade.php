<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Application' }}</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Sesuaikan dengan lokasi file CSS Anda -->
    @livewireStyles
    @filamentStyles
</head>
<body>
    <div id="app">
        <!-- Include sidebar and other common components if any -->
        
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script> <!-- Sesuaikan dengan lokasi file JS Anda -->
    @livewireScripts
    @filamentScripts
</body>
</html>
