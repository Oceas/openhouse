<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }} - {{ $property->full_address }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/open-house.png') }}">
    <meta name="description" content="{{ $property->meta_description ?? $property->description }}">

        <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#8b5cf6',
                    }
                }
            }
        }
    </script>

    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .hero-gradient {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ $property->featured_image ? Storage::url($property->featured_image) : "" }}');
            background-size: cover;
            background-position: center;
        }

        /* Custom carousel styles */
        .carousel-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            flex: 0 0 100%;
            position: relative;
        }

        .carousel-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .carousel-image:hover {
            transform: scale(1.02);
        }

        .carousel-slide a {
            display: block;
            width: 100%;
            height: 100%;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .carousel-nav:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        .carousel-nav.prev {
            left: 20px;
        }

        .carousel-nav.next {
            right: 20px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicator.active {
            background: white;
        }

        .image-counter {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 8px;
            margin-top: 16px;
        }

        .thumbnail {
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .thumbnail:hover {
            transform: scale(1.05);
        }

        .thumbnail.active {
            border-color: #6366f1;
        }

        /* Custom Lightbox Styles */
        .lb-nav a.lb-prev,
        .lb-nav a.lb-next {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .lb-nav a.lb-prev:hover,
        .lb-nav a.lb-next:hover {
            opacity: 1;
        }

        .lb-closeContainer .lb-close {
            opacity: 0.8;
            transition: opacity 0.3s ease;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lb-closeContainer .lb-close:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.9);
        }

        .lb-dataContainer .lb-number {
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            background: rgba(0, 0, 0, 0.7);
            padding: 8px 16px;
            border-radius: 20px;
        }

        .lb-nav a.lb-prev,
        .lb-nav a.lb-next {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lb-nav a.lb-prev:before,
        .lb-nav a.lb-next:before {
            color: white;
            font-size: 24px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-32 h-auto">
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('public.search') }}" class="text-gray-600 hover:text-gray-900 font-medium">Search Properties</a>
                </div>
            </div>
        </div>
    </nav>

        <!-- Photo Carousel Section -->
    <div class="relative">
        @php
            $allImages = collect();
            if ($property->featured_image) {
                $allImages->push($property->featured_image);
            }
            if ($property->gallery_images) {
                $allImages = $allImages->merge($property->gallery_images);
            }
            $totalImages = $allImages->count();
        @endphp

        @if($totalImages > 0)
            <div class="carousel-container">
                <div class="carousel-track" id="carousel-track">
                    @foreach($allImages as $index => $image)
                        <div class="carousel-slide">
                            <a href="{{ Storage::url($image) }}"
                               data-lightbox="property-gallery"
                               data-title="{{ $property->title }} - Image {{ $index + 1 }}"
                               onclick="openLightbox('{{ Storage::url($image) }}', '{{ $property->title }} - Image {{ $index + 1 }}', {{ $index }})">
                                <img src="{{ Storage::url($image) }}"
                                     alt="Property Image {{ $index + 1 }}"
                                     class="carousel-image">
                            </a>
                        </div>
                    @endforeach
                </div>

                @if($totalImages > 1)
                    <!-- Navigation Buttons -->
                    <button class="carousel-nav prev" onclick="changeSlide(-1)">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="carousel-nav next" onclick="changeSlide(1)">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Image Counter -->
                    <div class="image-counter">
                        <span id="current-image">1</span> of {{ $totalImages }}
                    </div>

                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        @for($i = 0; $i < $totalImages; $i++)
                            <div class="carousel-indicator {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide({{ $i }})"></div>
                        @endfor
                    </div>
                @endif
            </div>

            <!-- Thumbnail Grid -->
            @if($totalImages > 1)
                <div class="thumbnail-grid">
                    @foreach($allImages as $index => $image)
                        <img src="{{ Storage::url($image) }}"
                             alt="Thumbnail {{ $index + 1 }}"
                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                             onclick="goToSlide({{ $index }})">
                    @endforeach
                </div>
            @endif
        @else
            <!-- Fallback when no images -->
            <div class="hero-gradient min-h-96 flex items-center justify-center text-white">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $property->title }}</h1>
                    <p class="text-xl md:text-2xl mb-6">{{ $property->full_address }}</p>
                    <div class="text-3xl md:text-4xl font-bold text-green-400">
                        {{ $property->formatted_price }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Property Information Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl card-shadow p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $property->title }}</h1>
                    <p class="text-xl text-gray-600 mb-6">{{ $property->full_address }}</p>
                    <div class="text-3xl font-bold text-green-600 mb-4">
                        {{ $property->formatted_price }}
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bedrooms ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-600">Bedrooms</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bathrooms ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-600">Bathrooms</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->square_feet ? number_format($property->square_feet) : 'N/A' }}</div>
                            <div class="text-sm text-gray-600">Sq Ft</div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Quick Contact</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-blue-800">{{ $property->listing_agent_name ?? 'Contact Agent' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-blue-800">{{ $property->listing_agent_phone ?? '(555) 123-4567' }}</span>
                            </div>
                            @if($property->virtual_tour_url)
                                <a href="{{ $property->virtual_tour_url }}" target="_blank" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                    Virtual Tour
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Description -->
                @if($property->description)
                    <div class="bg-white rounded-2xl card-shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Description</h2>
                        <div class="prose max-w-none">
                            {!! $property->description !!}
                        </div>
                    </div>
                @endif

                <!-- Features -->
                @if($property->exterior_features || $property->interior_features || $property->community_features)
                    <div class="bg-white rounded-2xl card-shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Features</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if($property->exterior_features)
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-3">Exterior Features</h3>
                                    <p class="text-gray-600">{{ $property->exterior_features }}</p>
                                </div>
                            @endif
                            @if($property->interior_features)
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-3">Interior Features</h3>
                                    <p class="text-gray-600">{{ $property->interior_features }}</p>
                                </div>
                            @endif
                            @if($property->community_features)
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-3">Community Features</h3>
                                    <p class="text-gray-600">{{ $property->community_features }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif


            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info -->
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Info</h3>
                    <div class="space-y-3">
                        @if($property->mls_number)
                            <div class="flex justify-between">
                                <span class="text-gray-600">MLS #:</span>
                                <span class="font-medium">{{ $property->mls_number }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Property Type:</span>
                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</span>
                        </div>
                        @if($property->lot_size)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lot Size:</span>
                                <span class="font-medium">{{ $property->formatted_lot_size }}</span>
                            </div>
                        @endif
                        @if($property->garage_spaces)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Garage:</span>
                                <span class="font-medium">{{ $property->garage_spaces }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Open House -->
                @if($property->has_open_house && $property->is_open_house_active)
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-4">Open House</h3>
                        <div class="space-y-2 text-green-800">
                            <div>
                                <strong>Start:</strong> {{ $property->open_house_start->format('M j, Y g:i A') }}
                            </div>
                            <div>
                                <strong>End:</strong> {{ $property->open_house_end->format('M j, Y g:i A') }}
                            </div>
                            @if($property->open_house_notes)
                                <div class="mt-3 text-sm">
                                    {{ $property->open_house_notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Visitor Sign-in Card -->
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Interested in this property?</h3>
                    <p class="text-sm text-gray-600 mb-4">Sign in to receive more information and updates about this listing.</p>

                    <a href="{{ route('public.property.signin.form', ['address' => $property->url_address, 'ooh_id' => $property->ooh_id]) }}"
                       class="block w-full bg-primary text-white py-3 px-4 rounded-lg font-medium hover:bg-primary/90 transition-colors text-center">
                        Sign In for More Information
                    </a>

                    <div class="mt-4 text-xs text-gray-500 text-center">
                        We'll never share your information with third parties.
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    <div class="space-y-3">
                        @if($property->listing_agent)
                            <div>
                                <div class="font-medium">{{ $property->listing_agent }}</div>
                                <div class="text-sm text-gray-600">Listing Agent</div>
                            </div>
                        @endif
                        @if($property->listing_office)
                            <div>
                                <div class="font-medium">{{ $property->listing_office }}</div>
                                <div class="text-sm text-gray-600">Listing Office</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Virtual Tour & Video -->
                @if($property->virtual_tour_url || $property->video_url)
                    <div class="bg-white rounded-2xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Virtual Experience</h3>
                        <div class="space-y-3">
                            @if($property->virtual_tour_url)
                                <a href="{{ $property->virtual_tour_url }}"
                                   target="_blank"
                                   class="block w-full bg-primary text-white text-center py-2 px-4 rounded-lg hover:bg-primary/90 transition-colors">
                                    Virtual Tour
                                </a>
                            @endif
                            @if($property->video_url)
                                <a href="{{ $property->video_url }}"
                                   target="_blank"
                                   class="block w-full bg-secondary text-white text-center py-2 px-4 rounded-lg hover:bg-secondary/90 transition-colors">
                                    Watch Video
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="text-gray-300 text-sm">
                    &copy; {{ date('Y') }} Open House Management System. All rights reserved.
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium text-sm">
                        Agent Sign In
                    </a>
                </div>
            </div>
        </div>
    </footer>

        <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <!-- Carousel JavaScript -->
    <script>
                // Function to open lightbox modal
        function openLightbox(imageUrl, title, imageIndex) {
            console.log('openLightbox called with:', imageUrl, title, imageIndex);

            if (typeof lightbox !== 'undefined') {
                console.log('Lightbox is available, opening modal...');
                // Create a temporary element to trigger lightbox
                const tempLink = document.createElement('a');
                tempLink.href = imageUrl;
                tempLink.setAttribute('data-lightbox', 'property-gallery');
                tempLink.setAttribute('data-title', title);
                document.body.appendChild(tempLink);

                // Start lightbox from the specific image
                lightbox.start(tempLink);

                // Clean up
                setTimeout(() => {
                    document.body.removeChild(tempLink);
                }, 100);
            } else {
                console.log('Lightbox not available, opening in new tab...');
                // Fallback: open image in new tab
                window.open(imageUrl, '_blank');
            }
        }

        // Wait for DOM and Lightbox to be ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize lightbox if not already initialized
            if (typeof lightbox !== 'undefined') {
                console.log('Lightbox initialized successfully');
            } else {
                console.error('Lightbox not loaded');
            }
        });
        let currentSlide = 0;
        const totalSlides = {{ $totalImages ?? 0 }};

        function changeSlide(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            updateCarousel();
        }

        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            updateCarousel();
        }

        function updateCarousel() {
            const track = document.getElementById('carousel-track');
            const currentImageSpan = document.getElementById('current-image');
            const indicators = document.querySelectorAll('.carousel-indicator');
            const thumbnails = document.querySelectorAll('.thumbnail');

            if (track) {
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
            }

            if (currentImageSpan) {
                currentImageSpan.textContent = currentSlide + 1;
            }

            // Update indicators
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlide);
            });

            // Update thumbnails
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.classList.toggle('active', index === currentSlide);
            });
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (totalSlides <= 1) return;

            if (e.key === 'ArrowLeft') {
                changeSlide(-1);
            } else if (e.key === 'ArrowRight') {
                changeSlide(1);
            }
        });

        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;

        const carouselContainer = document.querySelector('.carousel-container');
        if (carouselContainer) {
            carouselContainer.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
            });

            carouselContainer.addEventListener('touchend', function(e) {
                endX = e.changedTouches[0].clientX;
                handleSwipe();
            });
        }

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = startX - endX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next slide
                    changeSlide(1);
                } else {
                    // Swipe right - previous slide
                    changeSlide(-1);
                }
            }
        }

        // Auto-play carousel (optional)
        let autoPlayInterval;

        function startAutoPlay() {
            if (totalSlides > 1) {
                autoPlayInterval = setInterval(() => {
                    changeSlide(1);
                }, 5000); // Change slide every 5 seconds
            }
        }

        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
        }

                // Start auto-play when page loads
        document.addEventListener('DOMContentLoaded', function() {
            startAutoPlay();

            // Stop auto-play when user interacts with carousel
            const carousel = document.querySelector('.carousel-container');
            if (carousel) {
                carousel.addEventListener('mouseenter', stopAutoPlay);
                carousel.addEventListener('mouseleave', startAutoPlay);
            }

            // Ensure lightbox works for carousel images
            const carouselImages = document.querySelectorAll('.carousel-slide a[data-lightbox]');
            carouselImages.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (typeof lightbox !== 'undefined') {
                        lightbox.start(this);
                    }
                });
            });
        });

        // Lightbox configuration
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lightbox !== 'undefined') {
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'albumLabel': 'Image %1 of %2',
                    'fadeDuration': 300,
                    'imageFadeDuration': 300,
                    'showImageNumberLabel': true,
                    'alwaysShowNavOnTouchDevices': true,
                    'disableScrolling': true,
                    'enableKeyboardNav': true,
                    'keyboardNav': true,
                    'showNavArrows': true,
                    'showCloseButton': true,
                    'closeButtonPosition': 'top-right'
                });
                console.log('Lightbox configured successfully');
            }


        });

        // Enhanced lightbox keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (lightbox.end) return; // Don't interfere if lightbox is not open

            switch(e.key) {
                case 'ArrowLeft':
                    if (lightbox.currentImageIndex > 0) {
                        lightbox.changeImage(lightbox.currentImageIndex - 1);
                    } else if (lightbox.options.wrapAround) {
                        lightbox.changeImage(lightbox.album.length - 1);
                    }
                    e.preventDefault();
                    break;
                case 'ArrowRight':
                    if (lightbox.currentImageIndex < lightbox.album.length - 1) {
                        lightbox.changeImage(lightbox.currentImageIndex + 1);
                    } else if (lightbox.options.wrapAround) {
                        lightbox.changeImage(0);
                    }
                    e.preventDefault();
                    break;
                case 'Escape':
                    lightbox.end();
                    e.preventDefault();
                    break;
            }
        });

        // Add touch swipe support for lightbox
        let lightboxStartX = 0;
        let lightboxEndX = 0;

        document.addEventListener('touchstart', function(e) {
            if (lightbox.end) return;
            lightboxStartX = e.touches[0].clientX;
        });

        document.addEventListener('touchend', function(e) {
            if (lightbox.end) return;
            lightboxEndX = e.changedTouches[0].clientX;
            handleLightboxSwipe();
        });

        function handleLightboxSwipe() {
            const swipeThreshold = 50;
            const diff = lightboxStartX - lightboxEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next image
                    if (lightbox.currentImageIndex < lightbox.album.length - 1) {
                        lightbox.changeImage(lightbox.currentImageIndex + 1);
                    } else if (lightbox.options.wrapAround) {
                        lightbox.changeImage(0);
                    }
                } else {
                    // Swipe right - previous image
                    if (lightbox.currentImageIndex > 0) {
                        lightbox.changeImage(lightbox.currentImageIndex - 1);
                    } else if (lightbox.options.wrapAround) {
                        lightbox.changeImage(lightbox.album.length - 1);
                    }
                }
            }
        }
    </script>
</body>
</html>
