@extends('docs.layout')

@section('title', 'Getting Started')
@section('description', 'Learn how to get started with Open House - the complete property management platform for real estate professionals.')

@section('content')
<div class="doc-content">
    <h1>Getting Started with Open House</h1>

    <p>Welcome to Open House! This guide will help you get up and running with our property management platform in just a few minutes.</p>

    <h2>What is Open House?</h2>
    <p>Open House is a comprehensive property management platform designed specifically for real estate professionals. It helps you:</p>
    <ul>
        <li>Create and manage stunning property listings</li>
        <li>Track visitors at open houses</li>
        <li>Generate detailed reports and analytics</li>
        <li>Share properties with potential buyers</li>
        <li>Streamline your real estate business</li>
    </ul>

    <h2>Quick Start Guide</h2>

    <h3>1. Create Your Account</h3>
    <p>Getting started is easy:</p>
    <ol>
        <li>Visit our <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">signup page</a></li>
        <li>Enter your name, email, and create a password</li>
        <li>Verify your email address</li>
        <li>Start using all features immediately</li>
    </ol>

    <h3>2. Complete Your Profile</h3>
    <p>After signing up, take a moment to complete your profile:</p>
    <ul>
        <li>Add your real estate license information</li>
        <li>Upload a professional photo</li>
        <li>Set your contact preferences</li>
    </ul>

    <h3>3. Add Your First Property</h3>
    <p>Create your first property listing:</p>
    <ol>
        <li>Click "Add Property" from your dashboard</li>
        <li>Fill in the basic property information</li>
        <li>Upload high-quality photos</li>
        <li>Add a detailed description</li>
        <li>Set the property status (Active, Pending, Sold)</li>
    </ol>

    <h3>4. Set Up Visitor Tracking</h3>
    <p>Enable visitor tracking for your open houses:</p>
    <ul>
        <li>Create a visitor sign-in form for each property</li>
        <li>Share the sign-in link with visitors</li>
        <li>Track visitor information and interest levels</li>
        <li>Follow up with qualified leads</li>
    </ul>

    <h2>Key Features Overview</h2>

    <h3>Property Management</h3>
    <p>Our property management system includes:</p>
    <ul>
        <li><strong>Professional Descriptions:</strong> Create detailed property descriptions with formatting</li>
        <li><strong>Photo Galleries:</strong> Upload multiple high-quality images</li>
        <li><strong>Virtual Tours:</strong> Add virtual tour links</li>
        <li><strong>Property Details:</strong> Track all MLS fields and custom information</li>
        <li><strong>Status Management:</strong> Update property status as deals progress</li>
        <li><strong>Automatic Geocoding:</strong> Properties are automatically mapped for search</li>
    </ul>

    <h3>Visitor Tracking</h3>
    <p>Capture and manage visitor information:</p>
    <ul>
        <li><strong>Digital Sign-in Forms:</strong> Collect visitor information electronically</li>
        <li><strong>Lead Scoring:</strong> Track visitor interest levels</li>
        <li><strong>Follow-up Reminders:</strong> Never miss a follow-up opportunity</li>
        <li><strong>Export Data:</strong> Download visitor lists for your CRM</li>
    </ul>

    <h3>Public Listings</h3>
    <p>Share properties with potential buyers:</p>
    <ul>
        <li><strong>Public URLs:</strong> Each property gets a unique public link</li>
        <li><strong>Professional Presentation:</strong> Beautiful, mobile-responsive design</li>
        <li><strong>Photo Carousels:</strong> Showcase property images with lightbox</li>
        <li><strong>Contact Integration:</strong> Easy contact forms for interested buyers</li>
    </ul>

    <h3>Interactive Property Search</h3>
    <p>Advanced search capabilities for buyers:</p>
    <ul>
        <li><strong>Map-Based Search:</strong> Interactive map with property markers</li>
        <li><strong>Advanced Filters:</strong> Search by location, price, beds, baths, property type</li>
        <li><strong>Property Comparison:</strong> Compare multiple properties side-by-side</li>
        <li><strong>Mobile Optimized:</strong> Works perfectly on all devices</li>
    </ul>

    <h3>Analytics & Reporting</h3>
    <p>Track your business performance:</p>
    <ul>
        <li><strong>Visitor Analytics:</strong> See how many people visit your properties</li>
        <li><strong>Lead Conversion:</strong> Track visitor-to-lead conversion rates</li>
        <li><strong>Property Performance:</strong> See which properties get the most interest</li>
        <li><strong>Monthly Reports:</strong> Detailed monthly performance summaries</li>
    </ul>

    <h2>Pricing & Plans</h2>
    <p>Open House offers simple, transparent pricing:</p>
    <ul>
        <li><strong>Special Early Bird Pricing:</strong> $9.99/month (normally $39.99)</li>
        <li><strong>All Features Included:</strong> No hidden fees or upsells</li>
        <li><strong>Cancel Anytime:</strong> No long-term contracts</li>
        <li><strong>Unlimited Properties:</strong> Add as many properties as you need</li>
    </ul>

    <h2>Getting Help</h2>
    <p>Need assistance? We're here to help:</p>
    <ul>
        <li><strong>Documentation:</strong> Browse our comprehensive guides</li>
        <li><strong>Email Support:</strong> Contact us at support@openhouse.showing.work</li>
        <li><strong>Community:</strong> Connect with other real estate professionals</li>
    </ul>

    <h2>Next Steps</h2>
    <p>Now that you're familiar with the basics, explore these areas:</p>
    <ul>
        <li><a href="{{ route('docs.property-management') }}" class="text-indigo-600 hover:text-indigo-800">Property Management Guide</a> - Learn how to create stunning listings</li>
        <li><a href="{{ route('docs.visitor-tracking') }}" class="text-indigo-600 hover:text-indigo-800">Visitor Tracking Guide</a> - Master lead capture and follow-up</li>
        <li><a href="{{ route('docs.faq') }}" class="text-indigo-600 hover:text-indigo-800">FAQ</a> - Find answers to common questions</li>
    </ul>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">Pro Tip</h3>
        <p class="text-blue-800">Start by adding just one property to get familiar with the system. Once you're comfortable, you can quickly add more properties and start tracking visitors at your open houses.</p>
    </div>
</div>
@endsection
