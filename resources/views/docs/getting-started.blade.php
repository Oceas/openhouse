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
    <p>Getting started is easy and free:</p>
    <ol>
        <li>Visit our <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">signup page</a></li>
        <li>Enter your name, email, and create a password</li>
        <li>Verify your email address</li>
        <li>Start your 14-day free trial</li>
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
        <li><strong>Rich Text Editor:</strong> Create detailed property descriptions with formatting</li>
        <li><strong>Photo Galleries:</strong> Upload multiple high-quality images</li>
        <li><strong>Virtual Tours:</strong> Add virtual tour links</li>
        <li><strong>Property Details:</strong> Track all MLS fields and custom information</li>
        <li><strong>Status Management:</strong> Update property status as deals progress</li>
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

    <h2>Subscription & Pricing</h2>
    <p>Open House offers a simple, transparent pricing model:</p>
    <ul>
        <li><strong>14-Day Free Trial:</strong> No credit card required to start</li>
        <li><strong>$9.99/month:</strong> After your trial period</li>
        <li><strong>Cancel Anytime:</strong> No long-term contracts</li>
        <li><strong>All Features Included:</strong> No hidden fees or upsells</li>
    </ul>

    <h2>Getting Help</h2>
    <p>Need assistance? We're here to help:</p>
    <ul>
        <li><strong>Documentation:</strong> Browse our comprehensive guides</li>
        <li><strong>FAQ:</strong> Find answers to common questions</li>
        <li><strong>Support:</strong> Contact our support team</li>
    </ul>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-blue-900 font-semibold mb-2">Pro Tip</h3>
        <p class="text-blue-800">Take advantage of your 14-day free trial to explore all features. You can create unlimited properties and track unlimited visitors during your trial period.</p>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-200">
        <h2>Next Steps</h2>
        <p>Ready to get started? Here's what to do next:</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <a href="{{ route('register') }}" class="block bg-indigo-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                Create Your Account
            </a>
            <a href="/docs/property-management" class="block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                Learn About Property Management
            </a>
        </div>
    </div>
</div>
@endsection
