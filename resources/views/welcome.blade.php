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
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
                width: 100%;
                margin: 0;
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
            .purple-btn {
                background-color: #8b5cf6;
                color: white;
            }
            .purple-btn:hover {
                background-color: #7c3aed;
            }
            .yellow-btn {
                background-color: #f59e0b;
                color: white;
            }
            .yellow-btn:hover {
                background-color: #d97706;
            }
            .red-btn {
                background-color: #ef4444;
                color: white;
                transition: all 0.3s ease;
            }
            .red-btn:hover {
                background-color: #dc2626;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            .pink-btn {
                background-color: #ec4899;
                color: white;
                transition: all 0.3s ease;
            }
            .pink-btn:hover {
                background-color: #db2777;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            .bond-card {
                background: linear-gradient(135deg, #dbeafe 0%, #ffffff 100%);
                border-left: 5px solid #3b82f6;
            }
            .reit-card {
                background: linear-gradient(135deg, #d1fae5 0%, #ffffff 100%);
                border-left: 5px solid #10b981;
            }
            .legal-card {
                background: linear-gradient(135deg, #ede9fe 0%, #ffffff 100%);
                border-left: 5px solid #8b5cf6;
            }
            .compliance-card {
                background: linear-gradient(135deg, #fef3c7 0%, #ffffff 100%);
                border-left: 5px solid #f59e0b;
            }
            .sales-marketing-card {
                background: linear-gradient(135deg, #fce7f3 0%, #ffffff 100%);
                border-left: 5px solid #ec4899;
            }
            .blue-icon {
                color: #3b82f6;
            }
            .green-icon {
                color: #10b981;
            }
            .purple-icon {
                color: #8b5cf6;
            }
            .yellow-icon {
                color: #f59e0b;
            }
            .red-icon {
                color: #ef4444;
            }
            .pink-icon {
                color: #ec4899;
            }
            .blue-bg-light {
                background-color: #dbeafe;
            }
            .green-bg-light {
                background-color: #d1fae5;
            }
            .purple-bg-light {
                background-color: #ede9fe;
            }
            .yellow-bg-light {
                background-color: #fef3c7;
            }
            .red-bg-light {
                background-color: #fee2e2;
            }
            .pink-bg-light {
                background-color: #fce7f3;
            }
            .cards-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
                width: 100%;
                justify-items: center;
            }
            
            /* Styles for when only one or a few cards are displayed */
            .cards-container.single-card {
                grid-template-columns: 1fr;
                max-width: 600px;
                margin: 0 auto;
            }
            
            .cards-container.two-cards {
                max-width: 800px;
                margin: 0 auto;
            }
            
            .cards-container.three-cards {
                grid-template-columns: repeat(3, 1fr);
                max-width: 1000px;
                margin: 0 auto;
            }
            
            .header-container {
                width: 100%;
                position: relative;
                margin-bottom: 1rem;
            }
            
            .logo-container {
                display: flex;
                justify-content: center;
                margin-bottom: 1rem;
            }
            
            .user-section {
                position: relative;
                margin-top: 2.5rem;
                margin-bottom: 2rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                z-index: 100;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                align-items: center;
                justify-content: center;
            }
            
            .modal-content {
                background-color: white;
                padding: 2rem;
                border-radius: 0.5rem;
                max-width: 90%;
                width: 400px;
                text-align: center;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .modal-buttons {
                display: flex;
                justify-content: center;
                gap: 1rem;
                margin-top: 1.5rem;
            }
            
            @media (min-width: 768px) {
                /* No specific desktop overrides needed */
            }
            
            @media (max-width: 767px) {
                .cards-container {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body class="font-sans">
        <div class="container relative flex flex-col items-center justify-center px-4 py-12 mx-auto">
            <!-- Header Section -->
            <div class="header-container">
                <!-- Logo (centered) -->
                <div class="logo-container">
                    <a href="#" class="block">
                        <img 
                            class="w-auto h-24" 
                            src="{{ asset('images/art_logo.png') }}" 
                            alt="Application Logo"
                        >
                    </a>
                </div>
                
                <!-- User Info and Logout Button (centered) -->
                <div class="flex justify-center w-full user-section">
                    <div class="font-medium text-gray-600">
                        Hello, <span class="font-semibold">{{ Auth::user()->name }}</span>
                    </div>
                    <button type="button" onclick="showLogoutConfirmation()" class="flex items-center gap-2 px-5 py-2 ml-4 rounded-lg shadow-md red-btn hover:shadow-lg">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </div>
            </div>
            
            @php
                // Count how many permissions the user has
                $permissionCount = 0;
                if(Auth::user()->hasPermission('DCMTRD')) $permissionCount++;
                if(Auth::user()->hasPermission('REITS')) $permissionCount++;
                if(Auth::user()->hasPermission('LEGAL')) $permissionCount++;
                if(Auth::user()->hasPermission('COMPLIANCE')) $permissionCount++;
                if(Auth::user()->hasPermission('SALES')) $permissionCount++;
                
                // Set the appropriate CSS class based on the number of permissions
                $containerClass = 'cards-container';
                if($permissionCount == 1) {
                    $containerClass .= ' single-card';
                } elseif($permissionCount == 2) {
                    $containerClass .= ' two-cards';
                } elseif($permissionCount == 3) {
                    $containerClass .= ' three-cards';
                } elseif($permissionCount == 4) {
                    $containerClass .= ' cards-container';
                } elseif($permissionCount == 5) {
                    $containerClass .= ' cards-container';
                }
            @endphp
            
            <div class="{{ $containerClass }}">
            @if(Auth::user()->hasPermission('DCMTRD'))
            <!-- Card 1: Bond Monitoring -->
            <a href="{{ 
                Auth::user()->role === 'admin' ? route('admin.dashboard', ['section' => 'dcmtrd']) : 
                (Auth::user()->role === 'maker' ? route('maker.dashboard', ['section' => 'dcmtrd']) : 
                (Auth::user()->role === 'approver' ? route('approver.dashboard', ['section' => 'dcmtrd']) : 
                route('dashboard', ['section' => 'dcmtrd']))) 
            }}" class="shadow-lg card bond-card">
                <div class="p-8">
                    <div class="icon-container blue-bg-light">
                        <i class="fas fa-building blue-icon fa-3x"></i>
                    </div>
                    <h2 class="mb-4 text-2xl font-bold text-center">Bond Monitoring (DCMT)</h2>
                    <p class="mb-6 text-center text-gray-600">Track bond performance, market trends, and explore issuers available in the market.</p>
                    <div class="flex justify-center">
                        <span class="inline-flex items-center px-4 py-2 font-medium rounded-md blue-btn">
                            View Dashboard <i class="ml-2 fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endif

            @if(Auth::user()->hasPermission('REITS'))
            <!-- Card 2: REITs -->
            <a href="{{ 
                Auth::user()->role === 'admin' ? route('admin.dashboard', ['section' => 'reits']) : 
                (Auth::user()->role === 'maker' ? route('maker.dashboard', ['section' => 'reits']) : 
                (Auth::user()->role === 'approver' ? route('approver.dashboard', ['section' => 'reits']) : 
                (Auth::user()->role === 'legal' ? route('legal.dashboard', ['section' => 'reits']) : 
                route('dashboard', ['section' => 'reits'])))) 
            }}" class="shadow-lg card reit-card">
                <div class="p-8">
                    <div class="icon-container green-bg-light">
                        <i class="fas fa-home green-icon fa-3x"></i>
                    </div>
                    <h2 class="mb-4 text-2xl font-bold text-center">Real Estate Investment Trusts (REITs)</h2>
                    <p class="mb-6 text-center text-gray-600">Discover and analyze Real Estate Investment Trusts and their benefits.</p>
                    <div class="flex justify-center">
                        <span class="inline-flex items-center px-4 py-2 font-medium rounded-md green-btn">
                            View Dashboard <i class="ml-2 fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endif

            @if(Auth::user()->hasPermission('LEGAL'))
            <!-- Card 3: Legal Department -->
            <a href="{{ 
                Auth::user()->role === 'admin' ? route('admin.dashboard', ['section' => 'legal']) : 
                (Auth::user()->role === 'maker' ? route('maker.dashboard', ['section' => 'legal']) : 
                (Auth::user()->role === 'approver' ? route('approver.dashboard', ['section' => 'legal']) : 
                (Auth::user()->role === 'legal' ? route('legal.dashboard', ['section' => 'legal']) : 
                route('dashboard', ['section' => 'legal'])))) 
            }}" class="shadow-lg card legal-card">
                <div class="p-8">
                    <div class="icon-container purple-bg-light">
                        <i class="fas fa-balance-scale purple-icon fa-3x"></i>
                    </div>
                    <h2 class="mb-4 text-2xl font-bold text-center">Legal Department</h2>
                    <p class="mb-6 text-center text-gray-600">Manage legal documentation, review contracts, and ensure regulatory compliance.</p>
                    <div class="flex justify-center">
                        <span class="inline-flex items-center px-4 py-2 font-medium rounded-md purple-btn">
                            View Dashboard <i class="ml-2 fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endif

            @if(Auth::user()->hasPermission('COMPLIANCE'))
            <!-- Card 4: Compliance -->
            <a href="{{ 
                Auth::user()->role === 'admin' ? route('admin.dashboard', ['section' => 'compliance']) : 
                (Auth::user()->role === 'maker' ? route('maker.dashboard', ['section' => 'compliance']) : 
                (Auth::user()->role === 'approver' ? route('approver.dashboard', ['section' => 'compliance']) : 
                route('compliance.dashboard', ['section' => 'compliance']))) 
            }}" class="shadow-lg card compliance-card">
                <div class="p-8">
                    <div class="icon-container yellow-bg-light">
                        <i class="fas fa-clipboard-check yellow-icon fa-3x"></i>
                    </div>
                    <h2 class="mb-4 text-2xl font-bold text-center">Compliance Management</h2>
                    <p class="mb-6 text-center text-gray-600">Monitor compliance requirements, track deadlines, and manage regulatory obligations.</p>
                    <div class="flex justify-center">
                        <span class="inline-flex items-center px-4 py-2 font-medium rounded-md yellow-btn">
                            View Dashboard <i class="ml-2 fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endif
            
            @if(Auth::user()->hasPermission('SALES'))
            <!-- Card 5: Sales & Marketing Management -->
            <a href="{{ 
                Auth::user()->role === 'admin' ? route('admin.dashboard', ['section' => 'sales-marketing']) : 
                (Auth::user()->role === 'maker' ? route('maker.dashboard', ['section' => 'sales-marketing']) : 
                (Auth::user()->role === 'approver' ? route('approver.dashboard', ['section' => 'sales-marketing']) : 
                (Auth::user()->role === 'sales' ? route('sales.dashboard', ['section' => 'sales-marketing']) : 
                route('dashboard', ['section' => 'sales-marketing'])))) 
            }}" class="card sales-marketing-card shadow-lg">
                <div class="p-8">
                    <div class="icon-container pink-bg-light">
                        <i class="fas fa-chart-line pink-icon fa-3x"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-center mb-4">Sales & Marketing Management</h2>
                    <p class="text-gray-600 text-center mb-6">Analyze market trends, track sales performance, and develop marketing strategies.</p>
                    <div class="flex justify-center">
                        <span class="inline-flex items-center px-4 py-2 pink-btn font-medium rounded-md">
                            View Dashboard <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endif
            </div>
        </div>
        
        <!-- Logout Confirmation Modal -->
        <div id="logoutModal" class="modal">
            <div class="modal-content">
                <h3 class="mb-4 text-xl font-bold">Confirm Logout</h3>
                <p>Are you sure you want to logout?</p>
                <div class="modal-buttons">
                    <button onclick="hideLogoutConfirmation()" class="px-4 py-2 text-gray-800 bg-gray-200 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-md red-btn">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            function showLogoutConfirmation() {
                document.getElementById('logoutModal').style.display = 'flex';
            }
            
            function hideLogoutConfirmation() {
                document.getElementById('logoutModal').style.display = 'none';
            }
            
            // Close modal when clicking outside of it
            window.onclick = function(event) {
                const modal = document.getElementById('logoutModal');
                if (event.target === modal) {
                    hideLogoutConfirmation();
                }
            }
        </script>
    </body>
</html>