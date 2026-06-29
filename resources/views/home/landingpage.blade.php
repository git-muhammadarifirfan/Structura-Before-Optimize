<!DOCTYPE html>

<head>
    <html lang="en">

    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('images/icons/structura.png') }}" sizes="64x64" type="image/png">
    <title>Structura</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-white font-Montserrat">

    <!--cutomerchat-->
    <script src="//code.tidio.co/hqsiluutklrxvrzkhjvle2sh7trgrvs1.js" async></script>

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
        const loader = document.getElementById('page-loader');

        // Tampilkan loader saat mulai pindah halaman
        window.addEventListener('beforeunload', () => {
            loader.classList.remove('hidden');
        });

        // Sembunyikan loader saat halaman selesai dimuat ATAU setelah 3 detik (mana yang lebih dulu)
        window.addEventListener('load', () => {
            setTimeout(() => loader.classList.add('hidden'), 300); // kasih jeda dikit biar animasi smooth
        });

        // Batas maksimal tampil loader: 3 detik
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 500);
    </script>



    {{-- Navbar --}}
    <x-navbar></x-navbar>
    {{-- Image Top Landingpage --}}
    <div class="mt-8 bg-smoothcream max-w-[1280px] mx-auto h-[300px] w-full relative bg-cover bg-center lg:rounded-[10px] xl:rounded-[10px] 2xl:rounded-[10px]"
        style="background-image: url('{{ asset('images/landingpages/contructionsimage.png') }}');">

        {{-- inside content --}}
        <div
            class="absolute inset-0 flex flex-col items-center md:items-start justify-center text-darkblue px-4 text-center md:text-left">

            {{-- Teks dan tombol dalam satu kolom --}}
            <div class="w-full md:w-3/4 lg:w-1/2 max-w-lg md:ml-8">
                <p class="text-base sm:text-xl md:text-xl lg:text-2xl font-bold">
                    Paket renovasi terbaik! Lengkapi kebutuhan pembangunan Anda dengan harga ekonomis dan kualitas
                    terjamin!
                </p>


                {{-- Beli Sekarang Button --}}
                @auth
                    <a href="{{ route('product') }}">
                        <button
                            class="mt-4 px-6 md:px-10 py-2 bg-darkblue text-white font-semibold rounded-[10px] text-sm md:text-base transition-transform duration-300 ease-in-out transform hover:scale-105">
                            Beli Sekarang!
                        </button>
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}">
                        <button
                            class="mt-4 px-6 md:px-10 py-2 bg-darkblue text-white font-semibold rounded-[10px] text-sm md:text-base transition-transform duration-300 ease-in-out transform hover:scale-105">
                            Beli Sekarang!
                        </button>
                    </a>
                @endguest
            </div>
        </div>
    </div>

    {{-- Category Section --}}
    <x-category :categories="$categories"></x-category>

    {{-- Descript Section --}}
    <div class="mx-auto text-center py-6 sm:py-8 lg:py-10 px-6 w-full max-w-[1280px] rounded-[10px] mt-0 sm:mt-2 lg:mt-6 bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ asset('images/landingpages/Footer-Landing-Page-1.png') }});">

        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#1E375A]">Hai, kami STRUCTURA.</h1>

        <p class="text-sm sm:text-base text-gray-600 mt-4 max-w-2xl mx-auto">
            STRUCTURA adalah platform e-commerce bahan bangunan yang menyediakan material konstruksi berkualitas tinggi
            dengan harga terjangkau. Berfokus pada kebutuhan para profesional di industri pembangunan, STRUCTURA
            menghadirkan solusi lengkap mulai dari material dasar hingga alat berat. Kami berkomitmen mendukung
            pembangunan yang efisien dan inovatif, sekaligus memberdayakan pasar lokal dengan produk terbaik yang
            memenuhi standar global.
        </p>
    </div>

    {{--  --}}
    <div class="mx-auto text-center">
        <h1 class="mt-8 mb-8 font-extrabold text-darkblue text-xl">TERBARU DI STRUCTURA</h1>
    </div>

    <div class="mx-auto mb-8 h-auto w-full max-w-[1280px] flex items-center justify-center px-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 w-full">
            @foreach ($latestProducts as $product)
                <div
                    class="bg-white p-2 sm:p-3 md:p-4 text-left w-full max-w-[180px] sm:max-w-[200px] md:max-w-[220px] text-darkblue mx-auto">
                    <a href="{{ route('product.detail', $product->sku) }}" class="group block">
                        <div class="w-full h-[160px] sm:h-[180px] md:h-[200px] overflow-hidden mx-auto rounded-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 ease-in-out transform group-hover:scale-105">
                        </div>
                        <h2 class="mt-2 text-[12px] sm:text-[14px] md:text-[16px] font-semibold ml-1 sm:ml-2">
                            {{ $product->product_name }}</h2>
                        <p class="ml-1 sm:ml-2 font-light text-[10px] sm:text-[12px]">Merk: {{ $product->brand }}
                        </p>
                        <p class="font-extrabold ml-1 sm:ml-2 text-[12px] sm:text-[14px] md:text-[16px]">Rp
                            {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div
        class="mt-8 mb-16 mx-auto bg-darkblue h-auto w-full max-w-[1280px] relative bg-cover bg-center lg:rounded-[10px] xl:rounded-[10px] 2xl:rounded-[10px] flex flex-col lg:flex-row overflow-hidden ">
        {{-- Image Section (hanya tampil di laptop/pc) --}}
        <div
            class="hidden lg:flex w-1/2 bg-gray-500 items-center justify-center rounded-t-[10px] lg:rounded-t-none lg:rounded-l-[10px] overflow-hidden">
            <img src="{{ asset('images/landingpages/exploremore.png') }}" alt="Material Konstruksi"
                class="w-full h-full object-cover">
        </div>



        {{-- Content Section --}}
        <div
            class="w-full lg:w-1/2 px-4 py-6 text-white flex flex-col justify-center items-start sm:items-center sm:text-center">
            <h2 class="text-base sm:text-lg md:text-xl font-bold mb-2">Jelajahi Lebih Banyak</h2>
            <p class="text-sm sm:text-base md:text-lg max-w-md">
                Temukan berbagai kategori material bangunan dengan mudah dan cepat.
            </p>


            @auth
                <a href="{{ route('product') }}" class="w-full sm:w-auto">
                    <button
                        class="mt-4 px-5 py-2 bg-white text-darkblue font-semibold rounded-[10px] text-sm sm:text-base w-full sm:w-auto">
                        Belanja Sekarang!
                    </button>
                </a>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="w-full sm:w-auto">
                    <button
                        class="mt-4 px-5 py-2 bg-white text-darkblue font-semibold rounded-[10px] text-sm sm:text-base w-full sm:w-auto">
                        Belanja Sekarang!
                    </button>
                </a>
            @endguest
        </div>
    </div>

    <x-footer></x-footer>


</body>

</html>
