<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - {{ $property->title }}</title>
    <meta name="description" content="Sign in to receive more information about {{ $property->title }}">

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

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">OH</span>
                    </div>
                    <span class="ml-2 text-xl font-bold text-gray-900">Open House</span>
                </div>
                <div class="text-sm text-gray-600">
                    Visitor Sign-in
                </div>
            </div>
        </div>
    </header>

    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Property Information -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl card-shadow p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $property->title }}</h1>
                            <a href="{{ route('public.property.show', $property->slug) }}" 
                               class="text-primary hover:text-primary/80 text-sm font-medium">
                                ← Back to Property
                            </a>
                        </div>

                        @if($property->featured_image)
                            <div class="mb-6">
                                <img src="{{ Storage::url($property->featured_image) }}" 
                                     alt="{{ $property->title }}" 
                                     class="w-full h-48 object-cover rounded-lg">
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 mb-2">Property Details</h2>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Address:</span>
                                        <div class="font-medium">{{ $property->full_address }}</div>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Price:</span>
                                        <div class="font-medium text-green-600">{{ $property->formatted_price }}</div>
                                    </div>
                                    @if($property->bedrooms)
                                        <div>
                                            <span class="text-gray-600">Bedrooms:</span>
                                            <div class="font-medium">{{ $property->bedrooms }}</div>
                                        </div>
                                    @endif
                                    @if($property->bathrooms)
                                        <div>
                                            <span class="text-gray-600">Bathrooms:</span>
                                            <div class="font-medium">{{ $property->bathrooms }}</div>
                                        </div>
                                    @endif
                                    @if($property->square_feet)
                                        <div>
                                            <span class="text-gray-600">Square Feet:</span>
                                            <div class="font-medium">{{ number_format($property->square_feet) }}</div>
                                        </div>
                                    @endif
                                    @if($property->property_type)
                                        <div>
                                            <span class="text-gray-600">Type:</span>
                                            <div class="font-medium">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</div>
                                        </div>
                                    @endif
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

                            @if($property->description)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                                    <div class="text-sm text-gray-600 line-clamp-4">
                                        {{ Str::limit(strip_tags($property->description), 200) }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sign-in Form -->
                <div class="bg-white rounded-2xl card-shadow p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Sign In</h2>
                        <p class="text-gray-600">Interested in this property? Sign in to receive more information.</p>
                    </div>

                    <form id="visitor-signin-form" class="space-y-6">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                    <input type="text" id="first_name" name="first_name" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                    <input type="text" id="last_name" name="last_name" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            
                            <div class="mt-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" id="phone" name="phone"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>

                        <!-- Property Interests -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Property Interests</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="current_home_status" class="block text-sm font-medium text-gray-700 mb-1">Current Home Status</label>
                                    <select id="current_home_status" name="current_home_status"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
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
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">Select...</option>
                                        <option value="immediately">Immediately</option>
                                        <option value="1-3_months">1-3 months</option>
                                        <option value="3-6_months">3-6 months</option>
                                        <option value="6_months_plus">6+ months</option>
                                        <option value="just_browsing">Just browsing</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="budget_min" class="block text-sm font-medium text-gray-700 mb-1">Budget Min</label>
                                    <input type="number" id="budget_min" name="budget_min" placeholder="500000"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label for="budget_max" class="block text-sm font-medium text-gray-700 mb-1">Budget Max</label>
                                    <input type="number" id="budget_max" name="budget_max" placeholder="750000"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="source" class="block text-sm font-medium text-gray-700 mb-1">How did you find this property?</label>
                                <select id="source" name="source"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
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
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Interests</h3>
                            <div class="space-y-3">
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

                        <!-- Additional Notes -->
                        <div>
                            <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                            <textarea id="additional_notes" name="additional_notes" rows="4"
                                      placeholder="Any specific questions or comments..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-primary text-white py-4 px-6 rounded-lg font-medium hover:bg-primary/90 transition-colors text-lg">
                            Sign In
                        </button>
                    </form>

                    <div id="signin-success" class="hidden mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-800 font-medium">Thank you for signing in! We'll be in touch soon.</p>
                        </div>
                    </div>

                    <div id="signin-error" class="hidden mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-800 font-medium" id="error-message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle visitor sign-in form submission
        document.addEventListener('DOMContentLoaded', function() {
            const signinForm = document.getElementById('visitor-signin-form');
            if (signinForm) {
                signinForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(signinForm);
                    const submitButton = signinForm.querySelector('button[type="submit"]');
                    const successDiv = document.getElementById('signin-success');
                    const errorDiv = document.getElementById('signin-error');
                    const errorMessage = document.getElementById('error-message');
                    
                    // Disable submit button and show loading state
                    submitButton.disabled = true;
                    submitButton.textContent = 'Signing In...';
                    
                    // Hide previous messages
                    successDiv.classList.add('hidden');
                    errorDiv.classList.add('hidden');
                    
                    fetch('{{ route("public.property.signin", $property->slug) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            successDiv.classList.remove('hidden');
                            signinForm.reset();
                            
                            // Scroll to success message
                            successDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        } else {
                            // Show error message
                            errorMessage.textContent = data.message || 'An error occurred. Please try again.';
                            errorDiv.classList.remove('hidden');
                            
                            // Scroll to error message
                            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorMessage.textContent = 'An error occurred. Please try again.';
                        errorDiv.classList.remove('hidden');
                        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitButton.disabled = false;
                        submitButton.textContent = 'Sign In';
                    });
                });
            }
        });
    </script>
</body>
</html>
