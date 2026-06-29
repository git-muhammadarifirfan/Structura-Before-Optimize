<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/icons/structura.png') }}" sizes="64x64" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap" rel="stylesheet">
    
    <title>404 - Page Not Found</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white font-Montserrat">
    {{-- Loader --}}
    <div id="page-loader" class="fixed inset-0 flex items-center justify-center bg-white z-50">
        <div class="text-4xl font-bold flex space-x-1 text-darkblue">
            <span class="dot animate-pulse delay-[0ms]">.</span>
            <span class="dot animate-pulse delay-[200ms]">.</span>
            <span class="dot animate-pulse delay-[400ms]">.</span>
        </div>
    </div>

    {{-- Loader Script --}}
    <script>
        window.addEventListener('beforeunload', () => {
            document.getElementById('page-loader').classList.remove('hidden');
        });
        window.addEventListener('load', () => {
            document.getElementById('page-loader').classList.add('hidden');
        });
    </script>

    {{-- Navbar --}}
    <x-navbar></x-navbar>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 md:px-8">
        <a href="{{ route('product') }}" class="text-sm text-gray-600 mb-4 inline-block">
            <img src="{{ asset('images/icons/back.png') }}" alt="Back" class="w-3 h-3 inline-block mr-2">
            Continue shopping
        </a>

        <div class="bg-[#F8F9F9] p-6 sm:p-8 rounded-lg shadow h-[300px] sm:h-[340px] md:h-[400px] text-center flex items-center justify-center">
            <div class="text-center">
                <h2 class="text-[32px] sm:text-[36px] md:text-[40px] font-light mb-4 text-darkblue">404</h2>
                <h3 class="text-[18px] sm:text-[20px] md:text-[24px] font-bold mb-6 text-darkblue">PAGE NOT FOUND</h3>
                <a href="{{ route('product') }}">
                    <button class="mt-4 px-6 py-2 sm:px-8 md:px-10 bg-darkblue text-white font-semibold rounded-[10px] text-sm sm:text-base transition duration-300 transform hover:scale-105">
                        Continue Shopping
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
