<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/icons/structura.png') }}" sizes="64x64" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>403 - Access Denied</title>
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

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 md:px-8">
        <a href="{{ route('product') }}" class="text-sm text-gray-600 mb-4 inline-block">
            <img src="{{ asset('images/icons/back.png') }}" alt="Back" class="w-3 h-3 inline-block mr-2">
            Kembali ke halaman utama
        </a>

        <div class="bg-[#F8F9F9] p-4 md:p-8 rounded-lg shadow h-[400px] md:h-[360px] text-center flex items-center justify-center">
            <div class="text-center">
                <h2 class="text-[32px] md:text-[40px] font-light mb-4 text-red-600">403</h2>
                <h3 class="text-[18px] md:text-[24px] font-bold mb-4 text-darkblue">AKSES TIDAK DIIZINKAN</h3>
                <p class="text-sm md:text-base text-gray-600 px-2 md:px-0">Kamu tidak memiliki hak akses untuk halaman ini.</p>
                <a href="{{ route('product') }}">
                    <button
                        class="mt-6 px-6 py-2 md:px-10 md:py-2 bg-darkblue text-white font-semibold rounded-[10px] text-sm md:text-[16px] transition-transform duration-300 ease-in-out transform hover:scale-105">
                        Kembali Belanja
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
