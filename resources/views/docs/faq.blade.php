@extends('docs.layout')

@section('title', 'Frequently Asked Questions')
@section('description', 'Find answers to common questions about Open House property management platform.')

@section('content')
<div class="doc-content">
    <h1>Frequently Asked Questions</h1>

    <p>Find answers to the most common questions about Open House. If you don't see your question here, please contact our support team.</p>

    <h2>Getting Started</h2>

    <h3>How do I create an account?</h3>
    <p>Creating an account is easy:</p>
    <ol>
        <li>Visit our <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">signup page</a></li>
        <li>Enter your name, email, and create a password</li>
        <li>Verify your email address</li>
        <li>Start using all features immediately</li>
    </ol>

    <h3>What's included in my subscription?</h3>
    <p>Your $9.99/month subscription includes:</p>
    <ul>
        <li>Unlimited property listings</li>
        <li>Visitor tracking and lead capture</li>
        <li>Interactive property search with maps</li>
        <li>Public property pages</li>
        <li>Analytics and reporting</li>
        <li>All platform features</li>
    </ul>

    <h3>Can I cancel my subscription?</h3>
    <p>Yes, absolutely! You can cancel your subscription at any time from your account settings. There are no cancellation fees or penalties.</p>

    <h2>Property Management</h2>

    <h3>How many properties can I create?</h3>
    <p>You can create unlimited properties with your subscription. There are no limits on the number of properties you can manage.</p>

    <h3>What file types are supported for images?</h3>
    <p>We support the following image formats:</p>
    <ul>
        <li>JPG/JPEG</li>
        <li>PNG</li>
        <li>WebP</li>
    </ul>
    <p>Maximum file size is 5MB per image, and we recommend using images that are at least 1200x800 pixels for best quality.</p>

    <h3>Can I edit properties after creating them?</h3>
    <p>Yes! You can edit any property at any time. Simply go to your property listing and click the "Edit" button to make changes.</p>

    <h3>How do I delete a property?</h3>
    <p>To delete a property:</p>
    <ol>
        <li>Go to your property listing</li>
        <li>Click the "Delete" button</li>
        <li>Confirm the deletion</li>
    </ol>
    <p><strong>Warning:</strong> Deleting a property is permanent and cannot be undone.</p>

    <h3>Do properties automatically appear on the search map?</h3>
    <p>Yes! When you create or update a property, our system automatically generates latitude and longitude coordinates. Your properties will appear on the interactive search map without any manual work.</p>

    <h2>Visitor Tracking</h2>

    <h3>How does visitor tracking work?</h3>
    <p>Visitor tracking allows you to capture information from people who visit your open houses:</p>
    <ol>
        <li>Enable visitor tracking for a property</li>
        <li>Share the sign-in link with visitors</li>
        <li>Visitors fill out a simple form</li>
        <li>You receive their information in your dashboard</li>
    </ol>

    <h3>What information do I collect from visitors?</h3>
    <p>The visitor sign-in form collects:</p>
    <ul>
        <li>Name, email, and phone number</li>
        <li>Interest level (High, Medium, Low)</li>
        <li>Buying timeline</li>
        <li>Financing status</li>
        <li>Additional notes</li>
    </ul>

    <h3>Can I export visitor data?</h3>
    <p>Yes! You can export visitor data in CSV format for importing into your CRM or other systems.</p>

    <h3>Is visitor data secure?</h3>
    <p>Absolutely! We take data security seriously:</p>
    <ul>
        <li>All data is encrypted in transit and at rest</li>
        <li>We comply with data protection regulations</li>
        <li>You control your data and can export it anytime</li>
        <li>We never share your data with third parties</li>
    </ul>

    <h2>Public Listings & Search</h2>

    <h3>How do public property pages work?</h3>
    <p>Each property automatically gets a public page that anyone can visit:</p>
    <ul>
        <li>Beautiful photo galleries with lightbox viewing</li>
        <li>Complete property details and descriptions</li>
        <li>Contact forms for interested buyers</li>
        <li>Mobile-optimized design</li>
        <li>SEO-friendly URLs</li>
    </ul>

    <h3>How does the interactive search work?</h3>
    <p>Our interactive search allows buyers to find properties:</p>
    <ul>
        <li>Map-based search with property markers</li>
        <li>Filter by location, price, beds, baths, property type</li>
        <li>Click markers to see property details</li>
        <li>Works perfectly on mobile devices</li>
    </ul>

    <h3>Can I control which properties are public?</h3>
    <p>Yes! You can set properties as public or private. Private properties won't appear in search results or have public pages.</p>

    <h2>Analytics & Reporting</h2>

    <h3>What analytics are available?</h3>
    <p>You can track:</p>
    <ul>
        <li>How many people view each property</li>
        <li>Visitor sign-ins and lead generation</li>
        <li>Property performance and interest levels</li>
        <li>Monthly reports and trends</li>
    </ul>

    <h3>Can I export reports?</h3>
    <p>Yes! You can export analytics data in various formats for further analysis or sharing with clients.</p>

    <h2>Technical Questions</h2>

    <h3>What browsers are supported?</h3>
    <p>Open House works on all modern browsers:</p>
    <ul>
        <li>Chrome (recommended)</li>
        <li>Firefox</li>
        <li>Safari</li>
        <li>Edge</li>
    </ul>

    <h3>Is Open House mobile-friendly?</h3>
    <p>Yes! Open House is fully responsive and works perfectly on:</p>
    <ul>
        <li>Smartphones</li>
        <li>Tablets</li>
        <li>Desktop computers</li>
    </ul>

    <h3>Do I need to install any software?</h3>
    <p>No! Open House is a web-based platform. You can access it from any device with an internet connection and a web browser.</p>

    <h2>Pricing & Billing</h2>

    <h3>How much does Open House cost?</h3>
    <p>Open House costs $9.99/month for our special early bird pricing (normally $39.99). This includes all features with no additional charges.</p>

    <h3>Are there any hidden fees?</h3>
    <p>No! The $9.99/month price includes everything. No setup fees, no per-property charges, no surprises.</p>

    <h3>What payment methods do you accept?</h3>
    <p>We accept all major credit and debit cards. Payments are processed securely through our payment provider.</p>

    <h3>Can I get a refund?</h3>
    <p>We don't provide refunds for partial months, but you can cancel anytime and won't be charged for future months.</p>

    <h2>Support & Help</h2>

    <h3>How do I get help if I have a problem?</h3>
    <p>We're here to help! You can:</p>
    <ul>
        <li>Email us at support@openhouse.showing.work</li>
        <li>Check our documentation for detailed guides</li>
        <li>Browse our FAQ for common questions</li>
    </ul>

    <h3>How quickly do you respond to support requests?</h3>
    <p>We typically respond to support emails within 24 hours, often much sooner.</p>

    <h3>Do you offer training or onboarding?</h3>
    <p>Yes! Our documentation provides comprehensive guides to help you get started quickly. The platform is designed to be intuitive and easy to use.</p>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">Still Have Questions?</h3>
        <p class="text-blue-800">If you don't see your question answered here, please don't hesitate to contact us. We're here to help you succeed with Open House!</p>
        <a href="mailto:support@openhouse.showing.work" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Contact Support
        </a>
    </div>
</div>
@endsection
