@extends('docs.layout')

@section('title', 'Subscriptions & Billing')
@section('description', 'Learn about Open House subscription plans, billing, and account management.')

@section('content')
<div class="doc-content">
    <h1>Subscriptions & Billing</h1>

    <p>Open House offers a simple, transparent subscription model designed to help real estate professionals succeed. This guide covers everything you need to know about subscriptions and billing.</p>

    <h2>Subscription Plans</h2>

    <h3>Professional Plan</h3>
    <p>Our single, comprehensive plan includes all features:</p>
    <ul>
        <li><strong>Price:</strong> $4.99/month</li>
        <li><strong>Trial Period:</strong> 14 days free</li>
        <li><strong>Billing Cycle:</strong> Monthly</li>
        <li><strong>Cancellation:</strong> Cancel anytime</li>
    </ul>

    <h3>What's Included</h3>
    <p>Your subscription includes access to all Open House features:</p>
    <ul>
        <li><strong>Unlimited Properties:</strong> Create as many property listings as you need</li>
        <li><strong>Visitor Tracking:</strong> Capture and manage visitor information</li>
        <li><strong>Photo Galleries:</strong> Upload unlimited high-quality images</li>
        <li><strong>Public Listings:</strong> Professional public property pages</li>
        <li><strong>PDF Exports:</strong> Generate property brochures</li>
        <li><strong>Data Export:</strong> Export visitor and property data</li>
        <li><strong>Email Support:</strong> Get help when you need it</li>
    </ul>

    <h2>Getting Started</h2>

    <h3>Free Trial</h3>
    <p>Every new account starts with a 14-day free trial:</p>
    <ul>
        <li><strong>No Credit Card Required:</strong> Start using Open House immediately</li>
        <li><strong>Full Access:</strong> All features available during trial</li>
        <li><strong>No Obligation:</strong> Cancel anytime during the trial</li>
        <li><strong>Easy Upgrade:</strong> Add payment method when ready to continue</li>
    </ul>

    <h3>Starting Your Trial</h3>
    <ol>
        <li>Visit our <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">signup page</a></li>
        <li>Create your account with name, email, and password</li>
        <li>Verify your email address</li>
        <li>Start using Open House immediately</li>
        <li>Add payment method before trial ends to continue</li>
    </ol>

    <h2>Billing and Payment</h2>

    <h3>Payment Methods</h3>
    <p>We accept all major payment methods:</p>
    <ul>
        <li><strong>Credit Cards:</strong> Visa, Mastercard, American Express, Discover</li>
        <li><strong>Debit Cards:</strong> All major debit card networks</li>
        <li><strong>Secure Processing:</strong> Powered by Stripe for maximum security</li>
    </ul>

    <h3>Billing Cycle</h3>
    <p>Understanding your billing schedule:</p>
    <ul>
        <li><strong>Monthly Billing:</strong> Charged on the same date each month</li>
        <li><strong>Pro-rated Charges:</strong> Only pay for the days you use</li>
        <li><strong>Automatic Renewal:</strong> Continues until cancelled</li>
        <li><strong>Email Notifications:</strong> Receive billing reminders</li>
    </ul>

    <h3>Payment Security</h3>
    <p>Your payment information is secure:</p>
    <ul>
        <li><strong>PCI Compliance:</strong> Meets highest security standards</li>
        <li><strong>Encryption:</strong> All data encrypted in transit and at rest</li>
        <li><strong>Tokenization:</strong> Payment details never stored on our servers</li>
        <li><strong>Fraud Protection:</strong> Advanced fraud detection systems</li>
    </ul>

    <h2>Managing Your Subscription</h2>

    <h3>Account Dashboard</h3>
    <p>Manage your subscription from your account dashboard:</p>
    <ul>
        <li><strong>Billing History:</strong> View all past charges</li>
        <li><strong>Payment Methods:</strong> Update or change payment info</li>
        <li><strong>Subscription Status:</strong> Check current plan and status</li>
        <li><strong>Usage Statistics:</strong> See how you're using Open House</li>
    </ul>

    <h3>Updating Payment Information</h3>
    <p>Keep your payment method current:</p>
    <ol>
        <li>Go to your account settings</li>
        <li>Click "Billing" or "Subscription"</li>
        <li>Update your payment method</li>
        <li>Save the changes</li>
    </ol>

    <h3>Billing Portal</h3>
    <p>Access our secure billing portal for:</p>
    <ul>
        <li>Downloading invoices and receipts</li>
        <li>Updating payment methods</li>
        <li>Viewing billing history</li>
        <li>Managing subscription settings</li>
    </ul>

    <h2>Cancellation and Refunds</h2>

    <h3>How to Cancel</h3>
    <p>Cancelling your subscription is easy:</p>
    <ol>
        <li>Log into your Open House account</li>
        <li>Go to account settings</li>
        <li>Click "Cancel Subscription"</li>
        <li>Confirm your cancellation</li>
        <li>Receive confirmation email</li>
    </ol>

    <h3>Cancellation Policy</h3>
    <p>Understanding what happens when you cancel:</p>
    <ul>
        <li><strong>Immediate Access:</strong> Continue using Open House until the end of your billing period</li>
        <li><strong>No Refunds:</strong> We don't provide refunds for partial months</li>
        <li><strong>Data Retention:</strong> Your data is retained for 30 days after cancellation</li>
        <li><strong>Easy Reactivation:</strong> Reactivate anytime by adding a payment method</li>
    </ul>

    <h3>Data After Cancellation</h3>
    <p>What happens to your data:</p>
    <ul>
        <li><strong>30-Day Grace Period:</strong> Access your data for 30 days</li>
        <li><strong>Export Options:</strong> Download your data before it's deleted</li>
        <li><strong>Permanent Deletion:</strong> Data is permanently deleted after 30 days</li>
        <li><strong>No Recovery:</strong> Deleted data cannot be recovered</li>
    </ul>

    <h2>Account Limits and Usage</h2>

    <h3>Storage Limits</h3>
    <p>Understanding your storage allocation:</p>
    <ul>
        <li><strong>Image Storage:</strong> 10GB total storage for property images</li>
        <li><strong>File Types:</strong> JPG, PNG, WebP supported</li>
        <li><strong>File Size:</strong> Maximum 5MB per image</li>
        <li><strong>Optimization:</strong> Automatic image compression</li>
    </ul>

    <h3>Usage Monitoring</h3>
    <p>Track your usage in your dashboard:</p>
    <ul>
        <li><strong>Storage Usage:</strong> See how much storage you're using</li>
        <li><strong>Property Count:</strong> Number of active properties</li>
        <li><strong>Visitor Data:</strong> Number of visitor records</li>
        <li><strong>Export History:</strong> Track your data exports</li>
    </ul>

    <h2>Support and Help</h2>

    <h3>Billing Support</h3>
    <p>Get help with billing issues:</p>
    <ul>
        <li><strong>Email Support:</strong> billing@openhouse.com</li>
        <li><strong>Response Time:</strong> Within 24 hours</li>
        <li><strong>Documentation:</strong> Comprehensive billing guides</li>
        <li><strong>FAQ:</strong> Common billing questions answered</li>
    </ul>

    <h3>Common Billing Questions</h3>
    <p>Frequently asked questions:</p>
    <ul>
        <li><strong>When am I charged?</strong> On the same date each month</li>
        <li><strong>Can I change my billing date?</strong> Contact support to request changes</li>
        <li><strong>What if my payment fails?</strong> We'll retry and notify you</li>
        <li><strong>Can I get a refund?</strong> No refunds for partial months</li>
        <li><strong>How do I update my card?</strong> Use the billing portal</li>
    </ul>

    <h2>Security and Privacy</h2>

    <h3>Data Protection</h3>
    <p>Your data is protected:</p>
    <ul>
        <li><strong>Encryption:</strong> All data encrypted at rest and in transit</li>
        <li><strong>Backup:</strong> Regular automated backups</li>
        <li><strong>Access Control:</strong> Secure authentication and authorization</li>
        <li><strong>Compliance:</strong> Meets industry security standards</li>
    </ul>

    <h3>Privacy</h3>
    <p>We respect your privacy:</p>
    <ul>
        <li><strong>No Data Sharing:</strong> We never sell your data</li>
        <li><strong>Limited Access:</strong> Only authorized personnel can access data</li>
        <li><strong>Audit Logs:</strong> Track all access to your account</li>
        <li><strong>GDPR Compliant:</strong> Meets international privacy standards</li>
    </ul>

    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-8">
        <h3 class="text-green-900 font-semibold mb-2">Pro Tips</h3>
        <ul class="text-green-800 space-y-1">
            <li>• Export your data regularly as a backup</li>
            <li>• Set calendar reminders for billing dates</li>
            <li>• Keep your payment method updated</li>
            <li>• Monitor your storage usage to avoid limits</li>
            <li>• Contact support early if you have billing issues</li>
        </ul>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-200">
        <h2>Next Steps</h2>
        <p>Ready to get started or need more information?</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <a href="{{ route('register') }}" class="block bg-indigo-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                Start Free Trial
            </a>
            <a href="/docs/faq" class="block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                Frequently Asked Questions
            </a>
        </div>
    </div>
</div>
@endsection
