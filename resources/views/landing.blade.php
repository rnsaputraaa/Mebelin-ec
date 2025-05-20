@extends('layouts.home')

@section('content')
<section class="py-8 bg-white">
    <div class="container mx-auto max-w-screen-xl pt-24">
        <div id="carousel-container" class="relative w-full overflow-hidden rounded-lg">
            <div id="carousel-slides" class="flex transition-transform duration-500 ease-in-out">

                <div class="carousel-slide w-full flex-shrink-0">
                    <div class="relative w-full h-64 md:h-80 lg:h-96 bg-black text-white flex">
                        <div class="w-1/2 p-6 md:p-10 flex flex-col justify-center">
                            <div class="flex items-center mb-2">
                                <h2 class="text-xl md:text-3xl font-bold">New Arrival Day</h2>
                                <span class="ml-4 px-3 py-1 bg-yellow-500 text-black font-bold text-sm rounded">POCO</span>
                            </div>
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold mb-1">POCO C71</h1>
                            <p class="text-lg md:text-xl font-medium mb-2">#SiPalingCadas</p>
                            <div class="text-2xl md:text-4xl lg:text-5xl font-bold mb-1">Diskon Rp100rb<span class="text-sm align-top">*</span></div>
                            <p class="text-xs mt-auto">*S&K Berlaku</p>
                        </div>
                    </div>
                </div>

                <div class="carousel-slide w-full flex-shrink-0">
                    <div class="relative w-full h-64 md:h-80 lg:h-96 bg-purple-900 text-white flex">
                        <div class="w-1/2 p-6 md:p-10 flex flex-col justify-center">
                            <div class="flex items-center mb-2">
                                <h2 class="text-xl md:text-3xl font-bold">Flash Sale</h2>
                                <span class="ml-4 px-3 py-1 bg-red-500 text-white font-bold text-sm rounded">HOT</span>
                            </div>
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold mb-1">Galaxy S24</h1>
                            <p class="text-lg md:text-xl font-medium mb-2">#BestDealsEver</p>
                            <div class="text-2xl md:text-4xl lg:text-5xl font-bold mb-1">Hemat 30%<span class="text-sm align-top">*</span></div>
                            <p class="text-xs mt-auto">*Selama persediaan masih ada</p>
                        </div>
                    </div>
                </div>

                <div class="carousel-slide w-full flex-shrink-0">
                    <div class="relative w-full h-64 md:h-80 lg:h-96 bg-gradient-to-r from-blue-800 to-blue-600 text-white flex">
                        <div class="w-1/2 p-6 md:p-10 flex flex-col justify-center">
                            <div class="flex items-center mb-2">
                                <h2 class="text-xl md:text-3xl font-bold">Weekend Special</h2>
                                <span class="ml-4 px-3 py-1 bg-green-500 text-white font-bold text-sm rounded">NEW</span>
                            </div>
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold mb-1">iPhone 15</h1>
                            <p class="text-lg md:text-xl font-medium mb-2">#GrabItNow</p>
                            <div class="text-2xl md:text-4xl lg:text-5xl font-bold mb-1">Cashback 5%<span class="text-sm align-top">*</span></div>
                            <p class="text-xs mt-auto">*Untuk pembelian dengan kartu kredit tertentu</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <button class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-opacity" data-index="0"></button>
                <button class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-opacity" data-index="1"></button>
                <button class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-opacity" data-index="2"></button>
            </div>

            <button id="prev-btn" class="absolute top-1/2 left-2 transform -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-black bg-opacity-30 text-white rounded-full hover:bg-opacity-50 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button id="next-btn" class="absolute top-1/2 right-2 transform -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-black bg-opacity-30 text-white rounded-full hover:bg-opacity-50 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>

<section class="py-8 bg-white">
    <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="max-w-prose text-left">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-4xl">
                    Modern Furniture for Modern Living
                </h1>
            
                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
                    Discover out collection of handcrafted furniture pieces that blend style and comfort
                </p>
            
                <div class="mt-4 flex gap-4 sm:mt-6 pt-5">
                    <a class="inline-block rounded-full border border-[#BF654B] bg-[#BF654B] px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-orange-900" href="#">Shop Now</a>
                </div>
            </div>

            <div class="flex justify-center lg:justify-end">
                <img src="img/banner.png" alt="Modern Furniture" class="rounded-lg object-cover">
            </div>
        </div>
    </div>
</section>

<section class="py-8 bg-white">
    <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
        <div class="bg-white rounded-lg p-6 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Kategori Produk</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <a href="" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c1.png" alt="Living Room" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Living Room</span>
                </a>

                <a href="/category/bedroom" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c2.png" alt="Bedroom" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Bedroom</span>
                </a>

                <a href="/category/dining-room" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c3.png" alt="Dining Room" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Dining Room</span>
                </a>

                <a href="/category/kitchen" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c4.png" alt="Kitchen" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Kitchen</span>
                </a>

                <a href="/category/workspace" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c5.png" alt="Workspace" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Workspace</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-8 bg-white">
    <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
        <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Produk Pilihan</h2>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</section>

<section class="py-8 pb-20 bg-white">
    <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
        <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Testimoni</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/100?img=6" alt="User 1" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="text-lg font-semibold">Adit</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/100?img=6" alt="User 2" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="text-lg font-semibold">Reynal</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/100?img=6" alt="User 3" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="text-lg font-semibold">Walid</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/100?img=6" alt="User 4" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="text-lg font-semibold">Rama</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/100?img=6" alt="User 5" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="text-lg font-semibold">Amir</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/100?img=6" alt="User 6" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="text-lg font-semibold">Zaini</h4>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('carousel-container');
        const slides = document.getElementById('carousel-slides');
        const slideElements = document.querySelectorAll('.carousel-slide');
        const dotsElements = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        
        let currentIndex = 0;
        const slideCount = slideElements.length;
        let slideWidth = container.clientWidth;
        let autoplayInterval;

        function initCarousel() {
            container.style.width = '100%';
            slideElements.forEach(slide => {
                slide.style.width = `${slideWidth}px`;
            });
            slides.style.width = `${slideWidth * slideCount}px`;

            goToSlide(currentIndex, false);
        }
        updateActiveDot();

        function updateSlideWidth() {
            slideWidth = container.clientWidth;
            slideElements.forEach(slide => {
                slide.style.width = `${slideWidth}px`;
            });
            slides.style.width = `${slideWidth * slideCount}px`;
            goToSlide(currentIndex, false);
        }

        initCarousel();
        window.addEventListener('resize', updateSlideWidth);

        function goToSlide(index, animate = true) {
            if (index < 0) {
                index = slideCount - 1;
            } else if (index >= slideCount) {
                index = 0;
            }
            
            currentIndex = index;
            const offset = -currentIndex * slideWidth;
            
            if (!animate) {
                slides.style.transition = 'none';
                slides.style.transform = `translateX(${offset}px)`;
                slides.offsetHeight;
                slides.style.transition = 'transform 500ms ease-in-out';
            } else {
                slides.style.transform = `translateX(${offset}px)`;
            }
            
            updateActiveDot();
            resetAutoplay();
        }

        function updateActiveDot() {
            dotsElements.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.add('opacity-100');
                    dot.classList.remove('opacity-50');
                } else {
                    dot.classList.add('opacity-50');
                    dot.classList.remove('opacity-100');
                }
            });
        }

        prevBtn.addEventListener('click', () => {
            goToSlide(currentIndex - 1);
        });
        
        nextBtn.addEventListener('click', () => {
            goToSlide(currentIndex + 1);
        });
        
        dotsElements.forEach(dot => {
            dot.addEventListener('click', () => {
                const index = parseInt(dot.getAttribute('data-index'));
                goToSlide(index);
            });
        });

        function startAutoplay() {
            autoplayInterval = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 5000);
        }
        
        function resetAutoplay() {
            clearInterval(autoplayInterval);
            startAutoplay();
        }

        let touchStartX = 0;
        let touchEndX = 0;
        
        container.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        container.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });
        
        function handleSwipe() {
            const threshold = 50;
            if (touchEndX < touchStartX - threshold) {
                // Swipe left
                goToSlide(currentIndex + 1);
            } else if (touchEndX > touchStartX + threshold) {
                // Swipe right
                goToSlide(currentIndex - 1);
            }
        }
        startAutoplay();
    });
</script>
@endsection