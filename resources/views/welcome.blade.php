<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
          <script src="https://cdn.tailwindcss.com"></script>
        @endif

        <style>
          body {
            height: 100vh;
          }
        </style>
    </head>
    <body class="flex items-center justify-center bg-gray-100">
      <div class="container mx-auto p-8">
          <h1 class="text-4xl font-bold text-center mb-8">Welcome to Our Platforms!</h1>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-4">
              <!-- Card 1: List of Issuers -->
              <a href="{{ route('issuer-search.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                  <i class="fas fa-building fa-5x mb-4 text-blue-500"></i> <!-- XXL Icon -->
                  <h2 class="text-2xl font-semibold mb-2">Bond Monitoring (DCMTRD)</h2>
                  <p class="text-gray-600 text-center">Explore the various issuers available in the market.</p>
              </a>

              <!-- Card 2: REITs -->
              <a href="{{ route('login') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                  <i class="fas fa-home fa-5x mb-4 text-green-500"></i> <!-- XXL Icon -->
                  <h2 class="text-2xl font-semibold mb-2">REITs</h2>
                  <p class="text-gray-600 text-center">Discover Real Estate Investment Trusts and their benefits.</p>
              </a>
          </div>
      </div>
    </body>
</html>
