@extends('docs.layout')

@section('title', 'Property Management')
@section('description', 'Learn how to create, manage, and optimize your property listings with Open House.')

@section('content')
<div class="doc-content">
    <h1>Property Management</h1>

    <p>Open House provides powerful tools to create and manage stunning property listings. This guide covers everything you need to know about property management.</p>

    <h2>Creating a New Property</h2>

    <h3>Step-by-Step Process</h3>
    <ol>
        <li><strong>Navigate to Properties:</strong> From your dashboard, click "Properties" in the navigation</li>
        <li><strong>Add New Property:</strong> Click the "Add Property" button</li>
        <li><strong>Fill Basic Information:</strong> Enter property details in the form</li>
        <li><strong>Upload Images:</strong> Add featured image and gallery photos</li>
        <li><strong>Write Description:</strong> Create detailed property descriptions</li>
        <li><strong>Save Property:</strong> Click "Create Property" to save</li>
    </ol>

    <h3>Required Fields</h3>
    <p>The following fields are required when creating a property:</p>
    <ul>
        <li><strong>Title:</strong> A compelling property title</li>
        <li><strong>List Price:</strong> Property listing price</li>
        <li><strong>Address:</strong> Street address, city, state, and ZIP code</li>
        <li><strong>Property Type:</strong> Single family, condo, townhouse, etc.</li>
        <li><strong>Status:</strong> Active, Pending, or Sold</li>
    </ul>

    <h2>Property Details</h2>

    <h3>Basic Information</h3>
    <ul>
        <li><strong>MLS Number:</strong> Multiple Listing Service identifier</li>
        <li><strong>Square Footage:</strong> Total living area</li>
        <li><strong>Bedrooms/Bathrooms:</strong> Number of bedrooms and bathrooms</li>
        <li><strong>Lot Size:</strong> Property lot dimensions</li>
        <li><strong>Year Built:</strong> Construction year</li>
    </ul>

    <h3>Advanced Features</h3>
    <ul>
        <li><strong>Property Features:</strong> List amenities and special features</li>
        <li><strong>Virtual Tour URL:</strong> Link to virtual tour or video</li>
        <li><strong>Automatic Geocoding:</strong> Properties are automatically mapped</li>
        <li><strong>Custom Fields:</strong> Add any additional information</li>
    </ul>

    <h2>Automatic Geocoding</h2>
    <p>Open House automatically generates latitude and longitude coordinates for your properties:</p>
    <ul>
        <li><strong>Automatic Processing:</strong> Coordinates are generated when you create or update a property</li>
        <li><strong>Map Integration:</strong> Properties automatically appear on the interactive search map</li>
        <li><strong>No Manual Work:</strong> No need to manually enter coordinates</li>
        <li><strong>Accurate Results:</strong> Uses reliable geocoding services for precise locations</li>
    </ul>

    <h2>Image Management</h2>

    <h3>Featured Image</h3>
    <p>Every property should have a featured image that appears prominently:</p>
    <ul>
        <li><strong>Recommended Size:</strong> 1200x800 pixels minimum</li>
        <li><strong>Format:</strong> JPG, PNG, or WebP</li>
        <li><strong>File Size:</strong> Maximum 5MB per image</li>
        <li><strong>Content:</strong> Exterior shot or best room in the house</li>
    </ul>

    <h3>Gallery Images</h3>
    <p>Add multiple images to showcase the property:</p>
    <ul>
        <li><strong>Upload Multiple:</strong> Select multiple files at once</li>
        <li><strong>Drag & Drop:</strong> Reorder images by dragging</li>
        <li><strong>Remove Images:</strong> Delete unwanted photos</li>
        <li><strong>Image Optimization:</strong> Automatic compression for faster loading</li>
    </ul>

    <h3>Image Best Practices</h3>
    <ul>
        <li>Use high-quality, well-lit photos</li>
        <li>Show all major rooms and features</li>
        <li>Include exterior shots from multiple angles</li>
        <li>Highlight unique features and amenities</li>
        <li>Ensure photos are properly staged</li>
    </ul>

    <h2>Property Descriptions</h2>

    <h3>Writing Effective Descriptions</h3>
    <p>Create compelling property descriptions that attract buyers:</p>
    <ul>
        <li><strong>Compelling Headlines:</strong> Start with an attention-grabbing title</li>
        <li><strong>Key Features:</strong> Highlight the most important features first</li>
        <li><strong>Neighborhood Info:</strong> Include nearby amenities and attractions</li>
        <li><strong>School Information:</strong> Mention nearby schools and districts</li>
        <li><strong>Engaging Language:</strong> Use descriptive, appealing words</li>
    </ul>

    <h3>Description Best Practices</h3>
    <ul>
        <li>Start with a compelling headline</li>
        <li>Highlight key features and amenities</li>
        <li>Include neighborhood information</li>
        <li>Mention nearby attractions and schools</li>
        <li>Use descriptive, engaging language</li>
        <li>Keep paragraphs short and scannable</li>
        <li>Include call-to-action phrases</li>
    </ul>

    <h2>Property Status Management</h2>

    <h3>Status Options</h3>
    <ul>
        <li><strong>Active:</strong> Property is available for sale</li>
        <li><strong>Pending:</strong> Property is under contract</li>
        <li><strong>Sold:</strong> Property has been sold</li>
        <li><strong>Withdrawn:</strong> Property is no longer on the market</li>
    </ul>

    <h3>Managing Status Changes</h3>
    <p>Keep your property status up to date:</p>
    <ul>
        <li>Update status as deals progress</li>
        <li>Set appropriate dates for status changes</li>
        <li>Add notes about status changes</li>
        <li>Notify team members of important updates</li>
    </ul>

    <h2>Public Property Pages</h2>

    <h3>Professional Presentation</h3>
    <p>Each property gets a beautiful public page:</p>
    <ul>
        <li><strong>Photo Carousel:</strong> Interactive image gallery with lightbox</li>
        <li><strong>Property Details:</strong> Complete property information</li>
        <li><strong>Contact Forms:</strong> Easy ways for buyers to reach you</li>
        <li><strong>Mobile Optimized:</strong> Looks great on all devices</li>
        <li><strong>SEO Friendly:</strong> Optimized for search engines</li>
    </ul>

    <h3>Sharing Properties</h3>
    <p>Share your properties with potential buyers:</p>
    <ul>
        <li><strong>Direct Links:</strong> Each property has a unique URL</li>
        <li><strong>Social Media:</strong> Easy sharing to social platforms</li>
        <li><strong>Email Integration:</strong> Send property links via email</li>
        <li><strong>QR Codes:</strong> Generate QR codes for print materials</li>
    </ul>

    <h2>Property Search & Discovery</h2>

    <h3>Interactive Map Search</h3>
    <p>Your properties appear on our interactive search map:</p>
    <ul>
        <li><strong>Map Markers:</strong> Properties show as clickable markers</li>
        <li><strong>Property Previews:</strong> Click markers to see property details</li>
        <li><strong>Search Filters:</strong> Buyers can filter by location, price, features</li>
        <li><strong>Mobile Friendly:</strong> Works perfectly on mobile devices</li>
    </ul>

    <h3>Search Optimization</h3>
    <p>Help buyers find your properties:</p>
    <ul>
        <li><strong>Complete Information:</strong> Fill out all property fields</li>
        <li><strong>High-Quality Photos:</strong> Use professional images</li>
        <li><strong>Detailed Descriptions:</strong> Write comprehensive descriptions</li>
        <li><strong>Accurate Pricing:</strong> Keep prices current</li>
        <li><strong>Regular Updates:</strong> Update listings regularly</li>
    </ul>

    <h2>Property Analytics</h2>

    <h3>Performance Tracking</h3>
    <p>Track how your properties perform:</p>
    <ul>
        <li><strong>View Counts:</strong> See how many people view each property</li>
        <li><strong>Visitor Sign-ins:</strong> Track open house visitors</li>
        <li><strong>Lead Generation:</strong> Monitor lead quality and quantity</li>
        <li><strong>Conversion Rates:</strong> Track visitor-to-lead conversions</li>
    </ul>

    <h3>Optimization Tips</h3>
    <ul>
        <li>Monitor which properties get the most views</li>
        <li>Analyze visitor feedback and questions</li>
        <li>Adjust pricing based on market response</li>
        <li>Update photos and descriptions regularly</li>
        <li>Use analytics to improve your listings</li>
    </ul>

    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-green-900 mb-2">Best Practice</h3>
        <p class="text-green-800">Take high-quality photos of your properties and write detailed, engaging descriptions. Properties with complete information and professional photos typically receive 3x more views and generate more qualified leads.</p>
    </div>
</div>
@endsection
