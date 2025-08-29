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

    <h2>Open House Management</h2>

    <h3>Setting Up Open Houses</h3>
    <p>Plan and manage your open house events:</p>
    <ul>
        <li><strong>Schedule Events:</strong> Set date and time for open houses</li>
        <li><strong>Visitor Expectations:</strong> Estimate expected attendance</li>
        <li><strong>Marketing Materials:</strong> Create promotional content</li>
        <li><strong>Follow-up Plans:</strong> Plan your post-event strategy</li>
    </ul>

    <h3>During Open Houses</h3>
    <p>Make the most of your open house events:</p>
    <ul>
        <li><strong>Digital Sign-in:</strong> Encourage all visitors to sign in</li>
        <li><strong>Engage Visitors:</strong> Answer questions and provide information</li>
        <li><strong>Collect Feedback:</strong> Get visitor impressions and feedback</li>
        <li><strong>Qualify Leads:</strong> Assess visitor interest and readiness</li>
    </ul>

    <h2>Follow-up Strategies</h2>

    <h3>Immediate Follow-up (Same Day)</h3>
    <p>Connect with visitors quickly:</p>
    <ul>
        <li><strong>Thank You Messages:</strong> Send personalized thank you emails</li>
        <li><strong>Property Information:</strong> Provide additional property details</li>
        <li><strong>Next Steps:</strong> Outline the buying process</li>
        <li><strong>Contact Information:</strong> Provide your direct contact details</li>
    </ul>

    <h3>Ongoing Nurturing</h3>
    <p>Build relationships with potential buyers:</p>
    <ul>
        <li><strong>Regular Updates:</strong> Keep them informed about the property</li>
        <li><strong>Market Information:</strong> Share relevant market insights</li>
        <li><strong>Similar Properties:</strong> Suggest other properties they might like</li>
        <li><strong>Personal Touch:</strong> Send personalized messages and calls</li>
    </ul>

    <h2>Analytics and Reporting</h2>

    <h3>Visitor Analytics</h3>
    <p>Track the performance of your open houses:</p>
    <ul>
        <li><strong>Attendance Numbers:</strong> Track how many people visit</li>
        <li><strong>Sign-in Rates:</strong> Percentage of visitors who sign in</li>
        <li><strong>Lead Quality:</strong> Assess the quality of generated leads</li>
        <li><strong>Conversion Rates:</strong> Track visitor-to-lead conversions</li>
    </ul>

    <h3>Performance Metrics</h3>
    <p>Monitor key performance indicators:</p>
    <ul>
        <li><strong>Open House Success:</strong> Which events generate the most leads</li>
        <li><strong>Property Interest:</strong> Which properties attract the most visitors</li>
        <li><strong>Follow-up Effectiveness:</strong> Track follow-up response rates</li>
        <li><strong>Lead Conversion:</strong> Monitor lead-to-client conversion rates</li>
    </ul>

    <h2>Data Export and Integration</h2>

    <h3>Exporting Visitor Data</h3>
    <p>Export visitor information for external use:</p>
    <ul>
        <li><strong>CSV Format:</strong> Download visitor lists in spreadsheet format</li>
        <li><strong>CRM Integration:</strong> Import data into your CRM system</li>
        <li><strong>Email Marketing:</strong> Use data for email campaigns</li>
        <li><strong>Reporting:</strong> Create custom reports and analysis</li>
    </ul>

    <h3>Data Management</h3>
    <p>Keep your visitor data organized:</p>
    <ul>
        <li><strong>Regular Cleanup:</strong> Remove outdated or duplicate entries</li>
        <li><strong>Data Backup:</strong> Regularly backup your visitor data</li>
        <li><strong>Privacy Compliance:</strong> Ensure compliance with data protection laws</li>
        <li><strong>Data Security:</strong> Protect visitor information appropriately</li>
    </ul>

    <h2>Best Practices</h2>

    <h3>Maximizing Sign-ins</h3>
    <ul>
        <li>Make the sign-in process quick and easy</li>
        <li>Offer incentives for signing in (property details, market updates)</li>
        <li>Have tablets or computers available for digital sign-in</li>
        <li>Train your team to encourage sign-ins</li>
        <li>Follow up with visitors who don't sign in</li>
    </ul>

    <h3>Improving Lead Quality</h3>
    <ul>
        <li>Ask qualifying questions during the sign-in process</li>
        <li>Engage visitors in conversation to assess interest</li>
        <li>Provide valuable information to build trust</li>
        <li>Follow up promptly with qualified leads</li>
        <li>Track and analyze your follow-up success rates</li>
    </ul>

    <h3>Technology Tips</h3>
    <ul>
        <li>Ensure reliable internet connection at open houses</li>
        <li>Have backup sign-in methods available</li>
        <li>Test the sign-in process before each event</li>
        <li>Keep devices charged and ready</li>
        <li>Train staff on the visitor tracking system</li>
    </ul>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">Pro Tip</h3>
        <p class="text-blue-800">The key to successful visitor tracking is making it a seamless part of the open house experience. Encourage all visitors to sign in by explaining the benefits they'll receive, such as property updates and market information.</p>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-yellow-900 mb-2">Important Note</h3>
        <p class="text-yellow-800">Always respect visitor privacy and comply with local data protection laws. Be transparent about how you'll use their information and provide clear opt-out options.</p>
    </div>
</div>
@endsection
