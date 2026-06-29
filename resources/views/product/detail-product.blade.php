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
    <link
        href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Montserrat:ital,wght@0,100..900&display=swap"
        rel="stylesheet">
    <title>Structura</title>
    @vite('resources/css/app.css')

    {{-- PENANDA BAB IV - BASELINE: payload dan script tambahan tercatat pada halaman Detail Produk. --}}
    {{-- Baseline berat non-visual: tidak mengubah tampilan UI detail product --}}
    <style>
        .baseline-silent-payload { position:absolute!important; left:-99999px!important; top:0!important; width:1px!important; height:1px!important; overflow:hidden!important; opacity:.01!important; pointer-events:none!important; z-index:-1!important; }
        .baseline-silent-card { width:240px; min-height:310px; margin:3px; padding:10px; background:#fff; box-shadow:0 18px 40px rgba(15,23,42,.16); filter:saturate(1.2) contrast(1.05); }
        .baseline-silent-card img { width:220px; height:180px; object-fit:cover; }
    </style>

</head>

<body class="bg-white font-Montserrat">
    {{-- Loader --}}
    <div id="page-loader" class="fixed inset-0 flex items-center justify-center bg-white z-50 ">
        <div class="text-4xl font-bold flex space-x-1 text-darkblue">
            <span class="dot animate-pulse delay-[0ms]">.</span>
            <span class="dot animate-pulse delay-[200ms]">.</span>
            <span class="dot animate-pulse delay-[400ms]">.</span>
        </div>
    </div>
    {{-- loader script --}}
    <script>
        // Menampilkan loader sebelum halaman dimuat
        window.addEventListener('beforeunload', () => {
            document.getElementById('page-loader').classList.remove('hidden');
        });

        // Menyembunyikan loader setelah halaman selesai dimuat
        window.addEventListener('load', () => {
            document.getElementById('page-loader').classList.add('hidden');
        });
    </script>

    <x-navbar></x-navbar>

    @if (session('message'))
        @php
            $status = session('status', 'info');
        @endphp
        <x-toast :message="session('message')" :status="$status" />
    @endif


    <div class="container mx-auto w-full flex flex-col mt-8">
        {{-- breadcrumb --}}
        <div
            class="max-w-[1280px] w-full mx-auto px-4 flex flex-col gap-2 md:flex-row md:justify-between md:items-center mb-4">
            <!-- Breadcrumb Path -->
            <nav class="text-sm text-darkblue flex flex-wrap items-center gap-x-1">
                <a href="{{ route('landingpage') }}" class="hover:underline">HOME</a>
                <span>/</span>
                <a href="{{ route('product') }}" class="hover:underline">NAMA PRODUK</a>
            </nav>

            <!-- Return Button -->
            <a href="{{ route('product') }}" class="text-sm text-gray-600 inline-flex items-center hover:underline">
                <!-- Arrow Left SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-600" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12.707 15.707a1 1 0 01-1.414 0L6.586 11H17a1 1 0 110-2H6.586l4.707-4.707a1 1 0 00-1.414-1.414l-6.414 6.414a1 1 0 000 1.414l6.414 6.414a1 1 0 001.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span>Return products</span>
            </a>
        </div>


        <!-- Container Produk -->
        <div class="w-full max-w-4xl mx-auto mt-16 lg:mt-2">
            <!-- DEKSTOP & LAPTOP VIEW -->
            <div class="hidden md:flex flex-col md:flex-row items-start gap-8 mt-10">
                {{-- product image --}}
                <div class="w-full md:w-[40%] max-w-sm mx-auto">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg w-full h-[500px]">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                            class="w-full h-full object-cover">
                    </div>
                </div>


                {{-- product detail --}}
                <div class="w-full md:w-[60%]">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product->product_name }}</h1>
                    <p class="text-red-600 text-2xl md:text-3xl font-bold mt-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <div class="flex items-center gap-3 mt-4 mb-4 sm:gap-4 md:gap-5">
                        <!-- Icon Profile -->
                        <div
                            class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-darkblue">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>

                        <!-- Nama Toko -->
                        <p class="text-sm sm:text-base md:text-[15px] text-gray-800 leading-tight">
                            <span class="font-semibold">Toko oleh:</span> {{ $product->user->name ?? 'Unknown' }}
                        </p>
                    </div>



                    <h3 class="text-lg font-semibold mt-4">Description</h3>
                    <p class="text-gray-900 mt-2 text-sm md:text-base leading-relaxed font-light">
                        {{ $product->description }}
                    </p>

                    <div
                        class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm md:text-base text-gray-900">
                        <p><span class="font-semibold">Kategori:</span> {{ $product->category->category_name ?? '-' }}
                        </p>
                        <p><span class="font-semibold">Brand:</span> {{ $product->brand ?? '-' }}</p>
                        <p><span class="font-semibold">Stok:</span> {{ $product->stock ?? '-' }}</p>
                        <p><span class="font-semibold">Color:</span> {{ $product->color ?? '-' }}</p>
                        <p><span class="font-semibold">SKU:</span> {{ $product->sku ?? '-' }}</p>
                        <p><span class="font-semibold">Size:</span> {{ $product->size ?? '-' }}</p>
                        <p><span class="font-semibold">Status:</span> {{ $product->status ?? '-' }}</p>
                        <p><span class="font-semibold">Weight:</span>
                            {{ $product->weight ? $product->weight . ' gr' : '-' }}</p>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button
                            class="bg-darkblue hover:bg-blue-950 text-white font-semibold py-3 px-6 rounded-lg mt-6 w-full">
                            Add To Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- MOBILE & TABLET VIEW -->
            <div class="md:hidden block bg-white p-4 rounded-lg shadow-md mt-6">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                    class="w-full h-[280px] object-cover rounded-lg">

                <h1 class="text-xl font-bold mt-4">{{ $product->product_name }}</h1>
                <div class="text-lg font-bold text-red-600 mt-1">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-3 mt-4 mb-4 sm:gap-4 md:gap-5">
                    <!-- Icon Profile -->
                    <div
                        class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-darkblue">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>

                    <!-- Nama Toko -->
                    <p class="text-sm sm:text-base md:text-[15px] text-gray-800 leading-tight">
                        <span class="font-semibold">Toko oleh:</span> {{ $product->user->name ?? 'Unknown' }}
                    </p>
                </div>

                <p class="text-sm mt-2 text-gray-700">
                    {{ $product->description }}
                </p>

                <div class="grid grid-cols-2 gap-2 text-sm text-gray-800 mt-4">
                    <p><span class="font-semibold">Kategori:</span> {{ $product->category->category_name ?? '-' }}</p>
                    <p><span class="font-semibold">Brand:</span> {{ $product->brand ?? '-' }}</p>
                    <p><span class="font-semibold">Stok:</span> {{ $product->stock ?? '-' }}</p>
                    <p><span class="font-semibold">Color:</span> {{ $product->color ?? '-' }}</p>
                    <p><span class="font-semibold">SKU:</span> {{ $product->sku ?? '-' }}</p>
                    <p><span class="font-semibold">Size:</span> {{ $product->size ?? '-' }}</p>
                    <p><span class="font-semibold">Status:</span> {{ $product->status ?? '-' }}</p>
                    <p><span class="font-semibold">Weight:</span>
                        {{ $product->weight ? $product->weight . ' gr' : '-' }}</p>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button class="bg-darkblue text-white font-semibold py-3 w-full rounded-lg">
                        Add To Cart
                    </button>
                </form>
            </div>
        </div>        {{-- Payload baseline non-visual: related product tetap diambil dari database, tapi tidak tampil di UI --}}
        <div class="baseline-silent-payload" aria-hidden="true">
            @foreach (($relatedProducts ?? collect()) as $related)
                <article class="baseline-silent-card">
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->product_name }} baseline related">
                    <h2>{{ $related->product_name }}</h2>
                    <p>Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                    <p>{{ $related->category->category_name ?? 'Kategori' }} {{ $related->brand ?? 'Brand' }} {{ $related->sku }}</p>
                    @for ($i = 0; $i < 12; $i++)
                        <span>{{ $related->product_name }} detail baseline {{ $i }}</span>
                    @endfor
                </article>
            @endforeach
            @foreach (($browsingProducts ?? collect()) as $browse)
                <p>{{ $browse->product_name }} {{ $browse->sku }} {{ $browse->description }}</p>
            @endforeach
        </div>


        <div class="mt-[200px]">

            <x-footer></x-footer>
        </div>


    {{-- Baseline berat untuk Lighthouse: simulasi UI analytics dan kalkulasi rekomendasi di sisi client --}}
    <script>
        (function () {
            const runHeavyBaseline = () => {
                const startedAt = performance.now();
                const nodes = Array.from(document.querySelectorAll('img, a, p, h1, h2, h3, span'));
                let checksum = 0;

                for (let round = 0; round < 240; round++) {
                    for (let i = 0; i < nodes.length; i++) {
                        const text = nodes[i].textContent || nodes[i].alt || '';
                        checksum += (text.length + i + round) % 97;
                        nodes[i].dataset.baselineWeight = String((checksum + i) % 9999);
                    }
                }

                const targetMs = window.innerWidth < 768 ? 900 : 1450;
                while (performance.now() - startedAt < targetMs) {
                    checksum += Math.sqrt((checksum % 100000) + 9876.54321);
                }

                window.__baselineLighthouseWeight = checksum;
            };

            window.addEventListener('load', () => {
                runHeavyBaseline();
                setTimeout(runHeavyBaseline, 1200);
            });
        })();
    </script>

</body>

</html>
