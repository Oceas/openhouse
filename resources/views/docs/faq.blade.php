@extends('docs.layout')

@section('title', 'Frequently Asked Questions')
@section('description', 'Find answers to common questions about Open House property management platform.')

@section('content')
<div class="doc-content">
    <h1>Frequently Asked Questions</h1>

    <p>Find answers to the most common questions about Open House. If you don't see your question here, please contact our support team.</p>

    <h2>Getting Started</h2>

    <h3>How do I create an account?</h3>
    <p>Creating an account is easy and free:</p>
    <ol>
        <li>Visit our <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">signup page</a></li>
        <li>Enter your name, email, and create a password</li>
        <li>Verify your email address</li>
        <li>Start your 14-day free trial immediately</li>
    </ol>

    <h3>Is there a free trial?</h3>
    <p>Yes! Every new account comes with a 14-day free trial. You can:</p>
    <ul>
        <li>Create unlimited properties</li>
        <li>Track unlimited visitors</li>
        <li>Use all features without restrictions</li>
        <li>No credit card required to start</li>
    </ul>

    <h3>What happens after my trial ends?</h3>
    <p>After your 14-day trial, you'll need to add a payment method to continue using Open House. Your subscription will be $9.99/month and you can cancel anytime.</p>

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

    <h3>Can I export my property data?</h3>
    <p>Yes! You can export property data in several formats:</p>
    <ul>
        <li><strong>PDF:</strong> Professional property brochures</li>
        <li><strong>CSV:</strong> Spreadsheet format for data analysis</li>
        <li><strong>JSON:</strong> For API integrations</li>
    </ul>

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
    <p>Yes! You can export visitor data in multiple formats:</p>
    <ul>
        <li><strong>CSV:</strong> For importing into your CRM</li>
        <li><strong>PDF:</strong> Professional visitor reports</li>
        <li><strong>JSON:</strong> For API integrations</li>
    </ul>

    <h3>Is visitor data secure?</h3>
    <p>Absolutely! We take data security seriously:</p>
    <ul>
        <li>All data is encrypted in transit and at rest</li>
        <li>We comply with GDPR and other privacy regulations</li>
        <li>We never sell or share your visitor data</li>
        <li>Visitors are informed about data collection</li>
    </ul>

    <h2>Public Listings</h2>

    <h3>How do public property pages work?</h3>
    <p>Every property automatically gets a public page:</p>
    <ul>
        <li>Unique URL for each property</li>
        <li>Professional, mobile-responsive design</li>
        <li>Photo carousel with lightbox</li>
        <li>Complete property details</li>
        <li>Visitor sign-in integration</li>
    </ul>

    <h3>Can I customize the public page design?</h3>
    <p>Currently, public pages use our standard professional design. We're working on customization options for future releases.</p>

    <h3>How do I share a property with potential buyers?</h3>
    <p>You can share properties in several ways:</p>
    <ul>
        <li>Copy the public URL and share it directly</li>
        <li>Use the "Share" button to get social media links</li>
        <li>Export as PDF and email to prospects</li>
        <li>Include the link in your marketing materials</li>
    </ul>

    <h2>Billing and Subscriptions</h2>

    <h3>How much does Open House cost?</h3>
    <p>Open House costs $9.99/month after your 14-day free trial. This includes:</p>
    <ul>
        <li>Unlimited properties</li>
        <li>Unlimited visitor tracking</li>
        <li>All features and updates</li>
        <li>Email support</li>
    </ul>

    <h3>What payment methods do you accept?</h3>
    <p>We accept all major payment methods:</p>
    <ul>
        <li>Visa, Mastercard, American Express, Discover</li>
        <li>All major debit cards</li>
        <li>Secure processing through Stripe</li>
    </ul>

    <h3>Can I cancel my subscription?</h3>
    <p>Yes! You can cancel your subscription anytime:</p>
    <ol>
        <li>Go to your account settings</li>
        <li>Click "Cancel Subscription"</li>
        <li>Confirm your cancellation</li>
    </ol>
    <p>You'll continue to have access until the end of your billing period.</p>

    <h3>Do you offer refunds?</h3>
    <p>We don't provide refunds for partial months. However, you can cancel anytime and won't be charged for future months.</p>

    <h3>What happens to my data if I cancel?</h3>
    <p>After cancellation:</p>
    <ul>
        <li>You can access your data for 30 days</li>
        <li>Export your data before it's deleted</li>
        <li>Data is permanently deleted after 30 days</li>
        <li>You can reactivate anytime by adding a payment method</li>
    </ul>

    <h2>Technical Support</h2>

    <h3>What browsers are supported?</h3>
    <p>Open House works on all modern browsers:</p>
    <ul>
        <li>Chrome (recommended)</li>
        <li>Firefox</li>
        <li>Safari</li>
        <li>Edge</li>
    </ul>

    <h3>Is Open House mobile-friendly?</h3>
    <p>Yes! Open House is fully responsive and works great on:</p>
    <ul>
        <li>Smartphones</li>
        <li>Tablets</li>
        <li>Desktop computers</li>
    </ul>

    <h3>How do I get help if I have issues?</h3>
    <p>We offer several support options:</p>
    <ul>
        <li><strong>Documentation:</strong> Comprehensive guides and tutorials</li>
        <li><strong>FAQ:</strong> This page with common questions</li>
        <li><strong>Email Support:</strong> support@openhouse.com</li>
        <li><strong>Response Time:</strong> Within 24 hours</li>
    </ul>

    <h3>Do you have an API?</h3>
    <p>Yes! We provide a comprehensive REST API for developers. Check out our <a href="/docs/api" class="text-indigo-600 hover:text-indigo-800">API documentation</a> for details.</p>

    <h2>Data and Privacy</h2>

    <h3>Is my data secure?</h3>
    <p>Yes! We take security seriously:</p>
    <ul>
        <li>All data is encrypted in transit and at rest</li>
        <li>Regular security audits and updates</li>
        <li>PCI compliance for payment processing</li>
        <li>Secure data centers with redundancy</li>
    </ul>

    <h3>Do you backup my data?</h3>
    <p>Yes! We perform regular automated backups:</p>
    <ul>
        <li>Daily backups of all data</li>
        <li>Multiple backup locations</li>
        <li>Point-in-time recovery available</li>
        <li>99.9% uptime guarantee</li>
    </ul>

    <h3>Can I export all my data?</h3>
    <p>Yes! You can export your data anytime:</p>
    <ul>
        <li>Export individual properties as PDF</li>
        <li>Export visitor data as CSV</li>
        <li>Use our API for bulk data export</li>
        <li>Download all data before cancellation</li>
    </ul>

    <h3>Do you share my data with third parties?</h3>
    <p>No! We never sell, rent, or share your data with third parties. Your data belongs to you and is only used to provide Open House services.</p>

    <h2>Features and Updates</h2>

    <h3>How often do you add new features?</h3>
    <p>We regularly update Open House with new features and improvements:</p>
    <ul>
        <li>Monthly feature updates</li>
        <li>Security and performance improvements</li>
        <li>User-requested features</li>
        <li>Automatic updates - no action required</li>
    </ul>

    <h3>Can I request new features?</h3>
    <p>Absolutely! We welcome feature requests:</p>
    <ul>
        <li>Email us at features@openhouse.com</li>
        <li>Include detailed descriptions</li>
        <li>We review all requests</li>
        <li>Popular requests get priority</li>
    </ul>

    <h3>Do you have integrations with other tools?</h3>
    <p>We're working on integrations with popular real estate tools. Currently available:</p>
    <ul>
        <li>REST API for custom integrations</li>
        <li>CSV export for CRM import</li>
        <li>Webhook support for real-time updates</li>
    </ul>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-blue-900 font-semibold mb-2">Still Have Questions?</h3>
        <p class="text-blue-800">If you couldn't find the answer you're looking for, our support team is here to help. Contact us at support@openhouse.com and we'll get back to you within 24 hours.</p>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-200">
        <h2>Ready to Get Started?</h2>
        <p>Join thousands of real estate professionals using Open House to manage their properties and close more deals.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <a href="{{ route('register') }}" class="block bg-indigo-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                Start Free Trial
            </a>
            <a href="/docs/getting-started" class="block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                Read Getting Started Guide
            </a>
        </div>
    </div>
</div>
@endsection
