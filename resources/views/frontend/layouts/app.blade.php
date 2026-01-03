<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PPDB Online' }} - {{ $school->name ?? 'Sekolah' }}</title>

    <!-- Favicon -->
    @if(isset($school->logo) && $school->logo)
        <link rel="icon" href="{{ asset('storage/' . $school->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Dynamic Theme Color & Animations -->
    <style>
        :root {
            --primary-color: {{ $school->primary_color ?? '#4F46E5' }}; 
            --secondary-color: {{ $school->secondary_color ?? '#10B981' }};
        }
        body { font-family: 'Poppins', sans-serif; }
        
        /* Utility Classes */
        .text-primary-custom { color: var(--primary-color); }
        .bg-primary-custom { background-color: var(--primary-color); }
        .border-primary-custom { border-color: var(--primary-color); }
        
        /* Fix for hover states with custom variables */
        .hover\:bg-primary-custom:hover { background-color: var(--primary-color) !important; }
        .hover\:text-primary-custom:hover { color: var(--primary-color) !important; }
        .group:hover .group-hover\:bg-primary-custom { background-color: var(--primary-color) !important; }
        .group:hover .group-hover\:text-primary-custom { color: var(--primary-color) !important; }

        .btn-primary-custom { 
            background-color: var(--primary-color); 
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover { 
            filter: brightness(110%); 
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(var(--primary-color), 0.3);
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-dark {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        
        /* Gradient Text */
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800 flex flex-col min-h-screen">
    
    @include('frontend.layouts.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('frontend.layouts.footer')

    <!-- Floating WhatsApp Button -->
    @if(isset($school->phone) && $school->phone)
        @php
            // Format Phone Number for WhatsApp (08xx -> 628xx)
            $phone = preg_replace('/[^0-9]/', '', $school->phone);
            if(str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
        @endphp
        <a href="https://wa.me/{{ $phone }}?text=Halo%20Admin,%20saya%20kendal%20di%20PPDB%20Online." target="_blank" class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-all transform hover:scale-110 flex items-center justify-center group">
            <i class="fab fa-whatsapp fa-2x"></i>
            <span class="absolute right-full mr-3 bg-white text-gray-800 text-xs font-bold px-2 py-1 rounded shadow opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                Butuh Bantuan?
            </span>
            <!-- Pulse Effect -->
            <span class="absolute top-0 left-0 -z-10 w-full h-full rounded-full bg-green-500 opacity-75 animate-ping"></span>
        </a>
    @endif

</body>
</html>
