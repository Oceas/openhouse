<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - {{ $property->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/open-house.png') }}">
    <meta name="description" content="Sign in to receive more information about {{ $property->title }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Input Mask Library -->
    <script src="https://unpkg.com/imask@6.6.3/dist/imask.min.js"></script>

    <style>
        .carousel-container {
            position: relative;
            overflow: hidden;
        }
        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .carousel-slide.active {
            opacity: 1;
        }
        .overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
        }
        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .card-shadow {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-gray-900">
    <!-- Background Carousel -->
    <div class="fixed inset-0 carousel-container">
        @php
            $allImages = collect();
            if ($property->featured_image) {
                $allImages->push($property->featured_image);
            }
            if ($property->gallery_images) {
                $allImages = $allImages->merge($property->gallery_images);
            }
            // If no images, use a default gradient
            if ($allImages->isEmpty()) {
                $allImages = collect(['default']);
            }
        @endphp
        
        @foreach($allImages as $index => $image)
            <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" 
                 style="background-image: url('{{ $image === 'default' ? '' : Storage::url($image) }}'); 
                        {{ $image === 'default' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' : '' }}"
                 data-image="{{ $image }}">
            </div>
        @endforeach
    </div>

    <!-- Overlay -->
    <div class="fixed inset-0 overlay"></div>

    <!-- Header -->
    <header class="relative z-10 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-32 h-auto">
                </div>
                <div class="flex items-center">
                    <a href="{{ route('public.property.show', ['address' => $property->url_address, 'ooh_id' => $property->ooh_id]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Property
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex">
        <!-- Left Column - Property Info -->
        <div class="w-1/2 hidden lg:flex items-start justify-center pt-8 px-8">
            <div class="bg-white/90 backdrop-blur-sm rounded-xl p-8 shadow-lg max-w-md">
                <div class="space-y-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Property Details</h2>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600">Address:</span>
                                <div class="font-medium">{{ $property->full_address }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Price:</span>
                                <div class="font-medium text-green-600 text-lg">{{ $property->formatted_price }}</div>
                            </div>
                            <div class="flex space-x-6">
                                @if($property->bedrooms)
                                    <div>
                                        <span class="text-gray-600">Bedrooms:</span>
                                        <div class="font-medium">{{ $property->bedrooms }}</div>
                                    </div>
                                @endif
                                @if($property->total_bathrooms)
                                    <div>
                                        <span class="text-gray-600">Bathrooms:</span>
                                        <div class="font-medium">{{ $property->total_bathrooms }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($property->has_open_house && $property->is_open_house_active)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-green-900 mb-2">Open House</h3>
                            <div class="space-y-1 text-green-800">
                                <div><strong>Start:</strong> {{ $property->open_house_start->format('M j, Y g:i A') }}</div>
                                <div><strong>End:</strong> {{ $property->open_house_end->format('M j, Y g:i A') }}</div>
                                @if($property->open_house_notes)
                                    <div class="mt-2 text-sm">{{ $property->open_house_notes }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                
            </div>
        </div>

        <!-- Right Column - Sign-in Form -->
        <div class="w-full lg:w-1/2 flex items-start justify-center pt-8 px-8">
            <div class="form-container rounded-2xl card-shadow p-8 w-full max-w-lg">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-600">Interested in this property? Sign in to receive more information.</p>
                </div>

                @if(session('success'))
                    <div id="success-message" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div id="error-message" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div id="validation-errors" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-800 font-medium">Please check your information and try again.</p>
                        </div>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="visitor-signin-form" class="space-y-4" method="POST" action="{{ route('public.property.signin', ['address' => $property->url_address, 'ooh_id' => $property->ooh_id]) }}">
                    @csrf

                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Basic Information</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-3">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" id="phone" name="phone"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Property Interests -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Property Interests</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="current_home_status" class="block text-sm font-medium text-gray-700 mb-1">Current Home Status</label>
                                <select id="current_home_status" name="current_home_status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select...</option>
                                    <option value="own">Own</option>
                                    <option value="rent">Rent</option>
                                    <option value="looking">Looking to buy</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="timeline_to_buy" class="block text-sm font-medium text-gray-700 mb-1">Timeline to Buy</label>
                                <select id="timeline_to_buy" name="timeline_to_buy"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select...</option>
                                    <option value="immediately">Immediately</option>
                                    <option value="1-3_months">1-3 months</option>
                                    <option value="3-6_months">3-6 months</option>
                                    <option value="6_months_plus">6+ months</option>
                                    <option value="just_browsing">Just browsing</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="source" class="block text-sm font-medium text-gray-700 mb-1">How did you find this property?</label>
                            <select id="source" name="source"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Select...</option>
                                <option value="zillow">Zillow</option>
                                <option value="realtor">Realtor.com</option>
                                <option value="redfin">Redfin</option>
                                <option value="social_media">Social Media</option>
                                <option value="friend_family">Friend/Family</option>
                                <option value="drive_by">Drive by</option>
                                <option value="sign">Open house sign</option>
                                <option value="agent">Agent referral</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Interests -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Interests</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="interested_in_similar_properties" value="1"
                                       class="rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="ml-3 text-sm text-gray-700">Interested in similar properties</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="interested_in_financing_info" value="1"
                                       class="rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="ml-3 text-sm text-gray-700">Interested in financing information</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="interested_in_market_analysis" value="1"
                                       class="rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="ml-3 text-sm text-gray-700">Interested in market analysis</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-primary text-white py-3 px-6 rounded-lg font-medium hover:bg-primary/90 transition-colors text-lg mt-6">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Carousel Navigation -->
    @if($allImages->count() > 1)
        <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-20">
            <div class="flex space-x-2">
                @foreach($allImages as $index => $image)
                    <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-colors {{ $index === 0 ? 'bg-white' : '' }}"
                            data-slide="{{ $index }}"></button>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        // Carousel functionality with lazy loading
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentSlide = 0;
        let loadedImages = new Set();

        function loadImage(slideElement) {
            const imagePath = slideElement.getAttribute('data-image');
            if (imagePath && imagePath !== 'default' && !loadedImages.has(imagePath)) {
                const img = new Image();
                img.onload = function() {
                    slideElement.style.backgroundImage = `url('/storage/${imagePath}')`;
                    loadedImages.add(imagePath);
                };
                img.src = `/storage/${imagePath}`;
            }
        }

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('bg-white'));
            
            slides[index].classList.add('active');
            if (dots[index]) {
                dots[index].classList.add('bg-white');
            }

            // Lazy load the current slide's image
            loadImage(slides[index]);
            
            // Preload next slide's image
            const nextIndex = (index + 1) % slides.length;
            loadImage(slides[nextIndex]);
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Auto-advance carousel with random timing between 3-5 seconds
        if (slides.length > 1) {
            function scheduleNextSlide() {
                const randomDelay = Math.random() * 2000 + 3000; // 3000-5000ms
                setTimeout(() => {
                    nextSlide();
                    scheduleNextSlide();
                }, randomDelay);
            }
            scheduleNextSlide();
        }

        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Auto-hide success/error messages after 5 seconds
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        const validationErrors = document.getElementById('validation-errors');

        function hideMessage(element) {
            if (element) {
                element.style.transition = 'opacity 0.5s ease-out';
                element.style.opacity = '0';
                setTimeout(() => {
                    element.style.display = 'none';
                }, 500);
            }
        }

        if (successMessage) {
            setTimeout(() => hideMessage(successMessage), 5000);
        }

        if (errorMessage) {
            setTimeout(() => hideMessage(errorMessage), 5000);
        }

        if (validationErrors) {
            setTimeout(() => hideMessage(validationErrors), 5000);
        }

        // Input masks
        document.addEventListener('DOMContentLoaded', function() {
            // Phone mask
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                IMask(phoneInput, {
                    mask: '(000) 000-0000',
                    lazy: false,
                    placeholderChar: '_'
                });
            }

            // Email validation and formatting
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('blur', function() {
                    const email = this.value.trim();
                    if (email && !isValidEmail(email)) {
                        this.classList.add('border-red-500');
                        this.classList.remove('border-gray-300');
                    } else {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-gray-300');
                    }
                });

                emailInput.addEventListener('input', function() {
                    if (this.classList.contains('border-red-500')) {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-gray-300');
                    }
                });
            }
        });

        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>
</html>
