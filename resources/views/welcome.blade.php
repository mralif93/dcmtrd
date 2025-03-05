<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bond & REIT Platform</title>
        <link rel="icon" href="{{ asset('images/art_icon.png') }}" type="image/x-icon">
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
                background-color: #f8fafc;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
            }
            .card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            .icon-container {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem auto;
            }
            .blue-btn {
                background-color: #3b82f6;
                color: white;
            }
            .blue-btn:hover {
                background-color: #2563eb;
            }
            .green-btn {
                background-color: #10b981;
                color: white;
            }
            .green-btn:hover {
                background-color: #059669;
            }
            .bond-card {
                background: linear-gradient(135deg, #dbeafe 0%, #ffffff 100%);
                border-left: 5px solid #3b82f6;
            }
            .reit-card {
                background: linear-gradient(135deg, #d1fae5 0%, #ffffff 100%);
                border-left: 5px solid #10b981;
            }
            .blue-icon {
                color: #3b82f6;
            }
            .green-icon {
                color: #10b981;
            }
            .blue-bg-light {
                background-color: #dbeafe;
            }
            .green-bg-light {
                background-color: #d1fae5;
            }
        </style>
    </head>
    <body class="font-sans">
        <div class="container mx-auto px-4">
            <!-- Logo -->
            <div class="flex justify-center mb-12 pb-12">
                <a href="#" class="block">
                    <img 
                        class="h-24 w-auto" 
                        src="{{ asset('images/art_logo.png') }}" 
                        alt="Application Logo"
                    >
                </a>
            </div>
            
            <!-- Two Cards Only -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto">
                <!-- Card 1: Bond Monitoring -->
                <a href="{{ route('issuer-search.index') }}" class="card bond-card shadow-lg">
                    <div class="p-8">
                        <div class="icon-container blue-bg-light">
                            <i class="fas fa-building blue-icon fa-3x"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-center mb-4">Bond Monitoring (DCMTRD)</h2>
                        <p class="text-gray-600 text-center mb-6">Track bond performance, market trends, and explore issuers available in the market.</p>
                        <div class="flex justify-center">
                            <span class="inline-flex items-center px-4 py-2 blue-btn font-medium rounded-md">
                                Explore Now <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Card 2: REITs -->
                <a href="{{ route('login') }}" class="card reit-card shadow-lg">
                    <div class="p-8">
                        <div class="icon-container green-bg-light">
                            <i class="fas fa-home green-icon fa-3x"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-center mb-4">Real Estate Investment Trusts (REITs)</h2>
                        <p class="text-gray-600 text-center mb-6">Discover and analyze Real Estate Investment Trusts and their benefits.</p>
                        <div class="flex justify-center">
                            <span class="inline-flex items-center px-4 py-2 green-btn font-medium rounded-md">
                                Learn More <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </body>
</html>