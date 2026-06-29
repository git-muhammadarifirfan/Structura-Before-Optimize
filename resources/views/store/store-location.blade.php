<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/icons/structura.png') }}" sizes="64x64" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Structura</title>
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <script>
        function changeMap(src) {
            document.getElementById("storeMap").src = src;
        }
    </script>
</head>

<body class="bg-gray-100 font-Montserrat">

    <!-- Loader -->
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

    <x-navbar></x-navbar>

    <!-- Main Container -->
    <div class="container mx-auto px-4 md:px-0 py-8 max-w-screen-xl">
        <!-- Breadcrumb -->
        <div class="mb-4 text-sm text-darkblue">
            <a href="{{ route('landingpage') }}" class="hover:underline">HOME</a> /
            <a href="{{ route('product') }}" class="hover:underline">ALL PRODUCT</a>
        </div>

        <h1 class="text-2xl md:text-3xl text-darkblue font-extrabold text-center mb-10">TOKO KAMI</h1>

        <!-- Map & Store List -->
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Map -->
            <div class="w-full lg:w-2/3">
                <div class="w-full rounded-xl overflow-hidden shadow-lg">
                     <iframe id="storeMap"
        class="w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[360px] xl:h-[400px] 2xl:h-[450px]"
                        class="w-full h-full"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.855111513546!2d112.8290248760255!3d-7.698693792318782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7cfc9ac5a7333%3A0x1d884104428bd109!2sGUDANG%20CV.%20RIZKI%20JAYA%20PASURUAN!5e0!3m2!1sen!2sid!4v1746779743637!5m2!1sen!2sid"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Store List -->
            <div class="w-full lg:w-1/3 space-y-6">
                <!-- Store 1 -->
                <div onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.855111513546!2d112.8290248760255!3d-7.698693792318782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7cfc9ac5a7333%3A0x1d884104428bd109!2sGUDANG%20CV.%20RIZKI%20JAYA%20PASURUAN!5e0!3m2!1sen!2sid!4v1746779743637!5m2!1sen!2sid')"
                    class="bg-[#F6F6F6] p-4 rounded-xl shadow-md cursor-pointer hover:bg-[#ebebeb] transition flex items-center">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/icons/Buildings.png') }}" class="w-6 h-6" />
                            <div>
                                <h2 class="font-bold text-sm md:text-base">Kraton - Kab. Pasuruan</h2>
                                <p class="text-gray-600 text-xs md:text-sm">
                                    TB. Rizki Jaya, Jalan ponpes terpadu al-yasini, desa kebotohan, kecamatan kraton, kab. Pasuruan
                                </p>
                            </div>
                        </div>
                        <img src="{{ asset('images/icons/Mapicon.png') }}" class="w-5 h-5" />
                    </div>
                </div>

                <!-- Store 2 -->
                <div onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.216572318171!2d112.75410427602593!3d-7.766843492252412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7d347b32e3287%3A0x10898029bdf75c88!2sUD.%20RIZKI%20JAYA%205!5e0!3m2!1sen!2sid!4v1746779967222!5m2!1sen!2sid')"
                    class="bg-[#F6F6F6] p-4 rounded-xl shadow-md cursor-pointer hover:bg-[#ebebeb] transition flex items-center">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/icons/Buildings.png') }}" class="w-6 h-6" />
                            <div>
                                <h2 class="font-bold text-sm md:text-base">Purwosari - Kab. Pasuruan</h2>
                                <p class="text-gray-600 text-xs md:text-sm">
                                    TB. Rizki Jaya 5, Pakem, Purwosari, Kab. Pasuruan
                                </p>
                            </div>
                        </div>
                        <img src="{{ asset('images/icons/Mapicon.png') }}" class="w-5 h-5" />
                    </div>
                </div>

                <!-- Store 3 -->
                <div onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.1480255269735!2d112.5889285760269!3d-7.87957649214284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7881f4263278f3%3A0x2c2b909624467e63!2sUD.RIZKI%20JAYA!5e0!3m2!1sen!2sid!4v1746779993255!5m2!1sen!2sid')"
                    class="bg-[#F6F6F6] p-4 rounded-xl shadow-md cursor-pointer hover:bg-[#ebebeb] transition flex items-center">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/icons/Buildings.png') }}" class="w-6 h-6" />
                            <div>
                                <h2 class="font-bold text-sm md:text-base">Karangploso - Kab. Malang</h2>
                                <p class="text-gray-600 text-xs md:text-sm">
                                    TB. Rizki Jaya 4, Desa Bocek, Kec. Karangploso, Kab. Malang
                                </p>
                            </div>
                        </div>
                        <img src="{{ asset('images/icons/Mapicon.png') }}" class="w-5 h-5" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-20">
        <x-eventnavbar></x-eventnavbar>
    </div>
    <div class="mt-10">
        <x-footer></x-footer>
    </div>
</body>

</html>
