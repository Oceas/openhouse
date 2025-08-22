@extends('docs.layout')

@section('title', 'Visitor Tracking')
@section('description', 'Learn how to capture and manage visitor information at open houses with Open House.')

@section('content')
<div class="doc-content">
    <h1>Visitor Tracking</h1>

    <p>Open House provides powerful visitor tracking tools to help you capture leads and follow up with potential buyers. This guide covers everything you need to know about visitor management.</p>

    <h2>Overview</h2>

    <p>Visitor tracking allows you to:</p>
    <ul>
        <li>Capture visitor information at open houses</li>
        <li>Track visitor interest levels and preferences</li>
        <li>Generate detailed visitor reports</li>
        <li>Follow up with qualified leads</li>
        <li>Export visitor data for your CRM</li>
    </ul>

    <h2>Setting Up Visitor Tracking</h2>

    <h3>1. Enable Visitor Sign-in</h3>
    <p>For each property, you can enable visitor sign-in functionality:</p>
    <ol>
        <li>Navigate to your property listing</li>
        <li>Click "Manage Visitors" or "Visitor Sign-in"</li>
        <li>Enable visitor tracking for the property</li>
        <li>Customize the sign-in form if needed</li>
    </ol>

    <h3>2. Access the Sign-in Form</h3>
    <p>Visitors can access the sign-in form in two ways:</p>
    <ul>
        <li><strong>Public Property Page:</strong> Direct link from the property's public page</li>
        <li><strong>Admin Link:</strong> Share the admin-generated sign-in URL</li>
    </ul>

    <h2>Visitor Sign-in Process</h2>

    <h3>What Visitors See</h3>
    <p>When visitors access the sign-in form, they'll see:</p>
    <ul>
        <li>Property information and photos</li>
        <li>Professional sign-in form</li>
        <li>Clear instructions and privacy notice</li>
        <li>Easy-to-use interface</li>
    </ul>

    <h3>Information Collected</h3>
    <p>The sign-in form collects essential visitor information:</p>
    <ul>
        <li><strong>Personal Information:</strong> Name, email, phone number</li>
        <li><strong>Interest Level:</strong> How interested they are in the property</li>
        <li><strong>Timeline:</strong> When they're looking to buy</li>
        <li><strong>Financing:</strong> Whether they need financing</li>
        <li><strong>Additional Notes:</strong> Any specific requirements or questions</li>
    </ul>

    <h2>Managing Visitor Data</h2>

    <h3>Viewing Visitors</h3>
    <p>Access visitor information through your dashboard:</p>
    <ol>
        <li>Go to your property listing</li>
        <li>Click "View Visitors" or "Visitor List"</li>
        <li>See all visitors who signed in</li>
        <li>Click on individual visitors for detailed information</li>
    </ol>

    <h3>Visitor Details</h3>
    <p>For each visitor, you can view:</p>
    <ul>
        <li><strong>Contact Information:</strong> Name, email, phone</li>
        <li><strong>Sign-in Date/Time:</strong> When they visited</li>
        <li><strong>Interest Level:</strong> High, Medium, or Low</li>
        <li><strong>Timeline:</strong> Buying timeline</li>
        <li><strong>Financing Status:</strong> Cash buyer or needs financing</li>
        <li><strong>Notes:</strong> Any additional information they provided</li>
    </ul>

    <h2>Lead Scoring and Prioritization</h2>

    <h3>Interest Levels</h3>
    <p>Visitors are categorized by interest level:</p>
    <ul>
        <li><strong>High Interest:</strong> Very interested, ready to buy soon</li>
        <li><strong>Medium Interest:</strong> Somewhat interested, considering options</li>
        <li><strong>Low Interest:</strong> Just looking, not ready to buy</li>
    </ul>

    <h3>Follow-up Priority</h3>
    <p>Prioritize your follow-up based on:</p>
    <ul>
        <li>Interest level (High priority for high interest)</li>
        <li>Timeline (Immediate buyers first)</li>
        <li>Financing status (Cash buyers may be faster)</li>
        <li>Sign-in recency (Recent visitors first)</li>
    </ul>

    <h2>Exporting Visitor Data</h2>

    <h3>Export Options</h3>
    <p>Export visitor data for use in other systems:</p>
    <ul>
        <li><strong>CSV Export:</strong> Download as spreadsheet file</li>
        <li><strong>PDF Report:</strong> Generate professional visitor report</li>
        <li><strong>CRM Integration:</strong> Import into your CRM system</li>
        <li><strong>Email Lists:</strong> Export email addresses for marketing</li>
    </ul>

    <h3>Export Formats</h3>
    <p>Choose the format that works best for your workflow:</p>
    <ul>
        <li><strong>CSV:</strong> For spreadsheet applications like Excel</li>
        <li><strong>PDF:</strong> For printing and sharing with clients</li>
        <li><strong>JSON:</strong> For API integrations</li>
    </ul>

    <h2>Privacy and Compliance</h2>

    <h3>Data Protection</h3>
    <p>Open House is committed to protecting visitor privacy:</p>
    <ul>
        <li><strong>Secure Storage:</strong> All data is encrypted and securely stored</li>
        <li><strong>Privacy Notice:</strong> Clear privacy policy for visitors</li>
        <li><strong>Data Retention:</strong> Configurable data retention policies</li>
        <li><strong>GDPR Compliance:</strong> Meets international privacy standards</li>
    </ul>

    <h3>Visitor Consent</h3>
    <p>Visitors are informed about:</p>
    <ul>
        <li>What information is being collected</li>
        <li>How the information will be used</li>
        <li>Their rights regarding their data</li>
        <li>Contact information for questions</li>
    </ul>

    <h2>Best Practices</h2>

    <h3>Maximizing Sign-ins</h3>
    <ul>
        <li>Make the sign-in process quick and easy</li>
        <li>Offer incentives for signing in (property updates, etc.)</li>
        <li>Display the sign-in form prominently</li>
        <li>Use tablets or computers at open houses</li>
        <li>Train staff to encourage sign-ins</li>
    </ul>

    <h3>Follow-up Strategies</h3>
    <ul>
        <li>Follow up within 24 hours of the open house</li>
        <li>Personalize follow-up based on visitor information</li>
        <li>Use multiple contact methods (email, phone, text)</li>
        <li>Provide additional property information</li>
        <li>Schedule follow-up appointments</li>
    </ul>

    <h3>Data Management</h3>
    <ul>
        <li>Regularly review and update visitor information</li>
        <li>Export data regularly for backup</li>
        <li>Clean up old or duplicate entries</li>
        <li>Track follow-up activities and outcomes</li>
        <li>Analyze visitor patterns and trends</li>
    </ul>

    <h2>Analytics and Reporting</h2>

    <h3>Visitor Analytics</h3>
    <p>Track key metrics for your open houses:</p>
    <ul>
        <li><strong>Total Visitors:</strong> Number of people who signed in</li>
        <li><strong>Conversion Rate:</strong> Percentage who became leads</li>
        <li><strong>Interest Distribution:</strong> Breakdown by interest level</li>
        <li><strong>Timeline Analysis:</strong> When visitors plan to buy</li>
        <li><strong>Property Performance:</strong> Which properties attract more visitors</li>
    </ul>

    <h3>Custom Reports</h3>
    <p>Generate reports for different purposes:</p>
    <ul>
        <li><strong>Weekly Reports:</strong> Regular updates on visitor activity</li>
        <li><strong>Property Reports:</strong> Performance by individual property</li>
        <li><strong>Lead Reports:</strong> Qualified leads and follow-up status</li>
        <li><strong>Trend Reports:</strong> Long-term visitor patterns</li>
    </ul>

    <h2>Integration with Other Tools</h2>

    <h3>CRM Integration</h3>
    <p>Connect visitor data with your CRM system:</p>
    <ul>
        <li>Automatic lead creation in your CRM</li>
        <li>Sync visitor information and notes</li>
        <li>Track follow-up activities</li>
        <li>Generate reports across systems</li>
    </ul>

    <h3>Email Marketing</h3>
    <p>Use visitor data for email campaigns:</p>
        <li>Welcome emails for new visitors</li>
        <li>Property updates and new listings</li>
        <li>Market updates and insights</li>
        <li>Follow-up sequences</li>
    </ul>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-blue-900 font-semibold mb-2">Pro Tips</h3>
        <ul class="text-blue-800 space-y-1">
            <li>• Follow up with high-interest visitors within 2 hours</li>
            <li>• Use visitor data to personalize your follow-up approach</li>
            <li>• Export visitor data weekly for backup and analysis</li>
            <li>• Track which properties generate the most qualified leads</li>
            <li>• Use visitor feedback to improve your open house presentations</li>
        </ul>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-200">
        <h2>Next Steps</h2>
        <p>Now that you understand visitor tracking, explore other features:</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <a href="/docs/subscriptions" class="block bg-indigo-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                Learn About Subscriptions
            </a>
            <a href="/docs/faq" class="block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                Frequently Asked Questions
            </a>
        </div>
    </div>
</div>
@endsection
