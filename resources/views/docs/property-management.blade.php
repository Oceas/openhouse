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
        <li><strong>Write Description:</strong> Use the rich text editor for detailed descriptions</li>
        <li><strong>Save Property:</strong> Click "Create Property" to save</li>
    </ol>

    <h3>Required Fields</h3>
    <p>The following fields are required when creating a property:</p>
    <ul>
        <li><strong>Title:</strong> A compelling property title</li>
        <li><strong>Price:</strong> Property listing price</li>
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
        <li><strong>Map Coordinates:</strong> Latitude and longitude for mapping</li>
        <li><strong>Custom Fields:</strong> Add any additional information</li>
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

    <h2>Rich Text Descriptions</h2>

    <h3>Using the Editor</h3>
    <p>Our rich text editor allows you to create compelling property descriptions:</p>
    <ul>
        <li><strong>Formatting:</strong> Bold, italic, underline, and more</li>
        <li><strong>Lists:</strong> Bulleted and numbered lists</li>
        <li><strong>Links:</strong> Add clickable links</li>
        <li><strong>Headings:</strong> Organize content with headers</li>
        <li><strong>Undo/Redo:</strong> Easy editing with keyboard shortcuts</li>
    </ul>

    <h3>Description Best Practices</h3>
    <ul>
        <li>Start with a compelling headline</li>
        <li>Highlight key features and amenities</li>
        <li>Include neighborhood information</li>
        <li>Mention nearby attractions and schools</li>
        <li>Use descriptive, engaging language</li>
        <li>Keep paragraphs short and scannable</li>
    </ul>

    <h2>Property Status Management</h2>

    <h3>Status Options</h3>
    <ul>
        <li><strong>Active:</strong> Property is available for sale</li>
        <li><strong>Pending:</strong> Offer accepted, under contract</li>
        <li><strong>Sold:</strong> Property has been sold</li>
    </ul>

    <h3>Status Updates</h3>
    <p>Keep your property status current to maintain accurate listings and avoid confusion with potential buyers.</p>

    <h2>Public Property Pages</h2>

    <h3>Automatic Generation</h3>
    <p>Every property automatically gets a public page with a unique URL:</p>
    <ul>
        <li><strong>URL Format:</strong> <code>yourdomain.com/p/property-slug</code></li>
        <li><strong>SEO Optimized:</strong> Search engine friendly URLs</li>
        <li><strong>Mobile Responsive:</strong> Looks great on all devices</li>
        <li><strong>Social Sharing:</strong> Easy to share on social media</li>
    </ul>

    <h3>Public Page Features</h3>
    <ul>
        <li>Professional photo carousel with lightbox</li>
        <li>Complete property details and description</li>
        <li>Contact information and inquiry forms</li>
        <li>Visitor sign-in integration</li>
        <li>Map integration (if coordinates provided)</li>
    </ul>

    <h2>Property Editing</h2>

    <h3>Making Changes</h3>
    <p>You can edit any property at any time:</p>
    <ol>
        <li>Navigate to the property in your dashboard</li>
        <li>Click the "Edit" button</li>
        <li>Make your changes</li>
        <li>Save the updates</li>
    </ol>

    <h3>Bulk Operations</h3>
    <p>For managing multiple properties:</p>
    <ul>
        <li>Select multiple properties using checkboxes</li>
        <li>Update status for multiple properties at once</li>
        <li>Export property data for external use</li>
    </ul>

    <h2>Property Analytics</h2>

    <h3>View Tracking</h3>
    <p>Track how your properties are performing:</p>
    <ul>
        <li><strong>Page Views:</strong> Number of times the public page was viewed</li>
        <li><strong>Visitor Sign-ins:</strong> Number of visitors who signed in</li>
        <li><strong>Inquiries:</strong> Contact form submissions</li>
        <li><strong>Time on Page:</strong> How long visitors spend viewing</li>
    </ul>

    <h2>Export and Integration</h2>

    <h3>PDF Export</h3>
    <p>Generate professional PDF brochures for each property:</p>
    <ul>
        <li>Include all property details and photos</li>
        <li>Professional formatting and layout</li>
        <li>Perfect for printing and sharing</li>
        <li>Customizable templates</li>
    </ul>

    <h3>Data Export</h3>
    <p>Export property data for use in other systems:</p>
    <ul>
        <li>CSV format for spreadsheet applications</li>
        <li>Include all property fields and images</li>
        <li>Perfect for MLS integration</li>
        <li>Backup your property data</li>
    </ul>

    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-8">
        <h3 class="text-green-900 font-semibold mb-2">Pro Tips</h3>
        <ul class="text-green-800 space-y-1">
            <li>• Use descriptive, keyword-rich titles for better SEO</li>
            <li>• Upload at least 10-15 high-quality images per property</li>
            <li>• Update property status promptly to maintain accuracy</li>
            <li>• Include virtual tour links when available</li>
            <li>• Write detailed descriptions that highlight unique features</li>
        </ul>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-200">
        <h2>Next Steps</h2>
        <p>Now that you understand property management, learn about visitor tracking:</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <a href="/docs/visitor-tracking" class="block bg-indigo-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                Learn About Visitor Tracking
            </a>
            <a href="/docs/api" class="block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                API Reference
            </a>
        </div>
    </div>
</div>
@endsection
