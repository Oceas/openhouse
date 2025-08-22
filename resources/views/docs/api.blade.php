@extends('docs.layout')

@section('title', 'API Reference')
@section('description', 'Integrate Open House with your applications using our REST API.')

@section('content')
<div class="doc-content">
    <h1>API Reference</h1>

    <p>Open House provides a comprehensive REST API that allows you to integrate property management and visitor tracking into your applications. This documentation covers all available endpoints and authentication methods.</p>

    <h2>Authentication</h2>

    <h3>API Keys</h3>
    <p>All API requests require authentication using API keys:</p>
    <ul>
        <li><strong>API Key Location:</strong> Include in the Authorization header</li>
        <li><strong>Format:</strong> <code>Bearer YOUR_API_KEY</code></li>
        <li><strong>Security:</strong> Keep your API key secure and never expose it in client-side code</li>
    </ul>

    <h3>Getting Your API Key</h3>
    <ol>
        <li>Log into your Open House account</li>
        <li>Go to Account Settings</li>
        <li>Click "API Keys"</li>
        <li>Generate a new API key</li>
        <li>Copy and store the key securely</li>
    </ol>

    <h3>Example Request</h3>
    <pre><code>curl -H "Authorization: Bearer YOUR_API_KEY" \
     https://api.openhouse.com/v1/properties</code></pre>

    <h2>Base URL</h2>
    <p>All API endpoints are relative to the base URL:</p>
    <pre><code>https://api.openhouse.com/v1</code></pre>

    <h2>Properties API</h2>

    <h3>List Properties</h3>
    <p>Retrieve a list of all properties for the authenticated user.</p>

    <h4>Endpoint</h4>
    <pre><code>GET /properties</code></pre>

    <h4>Parameters</h4>
    <ul>
        <li><code>page</code> (optional): Page number for pagination (default: 1)</li>
        <li><code>per_page</code> (optional): Number of properties per page (default: 20, max: 100)</li>
        <li><code>status</code> (optional): Filter by status (active, pending, sold)</li>
        <li><code>search</code> (optional): Search in property title and address</li>
    </ul>

    <h4>Response</h4>
    <pre><code>{
  "data": [
    {
      "id": "uuid",
      "title": "Beautiful Family Home",
      "price": 450000,
      "address": "123 Main St",
      "city": "Anytown",
      "state": "CA",
      "zip_code": "90210",
      "status": "active",
      "created_at": "2024-01-15T10:30:00Z",
      "updated_at": "2024-01-15T10:30:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 50,
    "last_page": 3
  }
}</code></pre>

    <h3>Get Property</h3>
    <p>Retrieve a specific property by ID.</p>

    <h4>Endpoint</h4>
    <pre><code>GET /properties/{id}</code></pre>

    <h4>Response</h4>
    <pre><code>{
  "data": {
    "id": "uuid",
    "title": "Beautiful Family Home",
    "price": 450000,
    "address": "123 Main St",
    "city": "Anytown",
    "state": "CA",
    "zip_code": "90210",
    "description": "Rich text description...",
    "property_type": "single_family",
    "bedrooms": 3,
    "bathrooms": 2,
    "square_feet": 2000,
    "lot_size": "0.25 acres",
    "year_built": 2010,
    "mls_number": "MLS123456",
    "status": "active",
    "featured_image": "https://...",
    "gallery_images": ["https://...", "https://..."],
    "public_url": "https://openhouse.com/p/property-slug",
    "created_at": "2024-01-15T10:30:00Z",
    "updated_at": "2024-01-15T10:30:00Z"
  }
}</code></pre>

    <h3>Create Property</h3>
    <p>Create a new property listing.</p>

    <h4>Endpoint</h4>
    <pre><code>POST /properties</code></pre>

    <h4>Request Body</h4>
    <pre><code>{
  "title": "Beautiful Family Home",
  "price": 450000,
  "address": "123 Main St",
  "city": "Anytown",
  "state": "CA",
  "zip_code": "90210",
  "description": "Rich text description...",
  "property_type": "single_family",
  "bedrooms": 3,
  "bathrooms": 2,
  "square_feet": 2000,
  "lot_size": "0.25 acres",
  "year_built": 2010,
  "mls_number": "MLS123456",
  "status": "active"
}</code></pre>

    <h4>Response</h4>
    <pre><code>{
  "data": {
    "id": "uuid",
    "title": "Beautiful Family Home",
    "price": 450000,
    "address": "123 Main St",
    "city": "Anytown",
    "state": "CA",
    "zip_code": "90210",
    "description": "Rich text description...",
    "property_type": "single_family",
    "bedrooms": 3,
    "bathrooms": 2,
    "square_feet": 2000,
    "lot_size": "0.25 acres",
    "year_built": 2010,
    "mls_number": "MLS123456",
    "status": "active",
    "created_at": "2024-01-15T10:30:00Z",
    "updated_at": "2024-01-15T10:30:00Z"
  }
}</code></pre>

    <h3>Update Property</h3>
    <p>Update an existing property.</p>

    <h4>Endpoint</h4>
    <pre><code>PUT /properties/{id}</code></pre>

    <h4>Request Body</h4>
    <p>Include only the fields you want to update.</p>
    <pre><code>{
  "price": 475000,
  "status": "pending"
}</code></pre>

    <h3>Delete Property</h3>
    <p>Delete a property (this action cannot be undone).</p>

    <h4>Endpoint</h4>
    <pre><code>DELETE /properties/{id}</code></pre>

    <h4>Response</h4>
    <pre><code>{
  "message": "Property deleted successfully"
}</code></pre>

    <h2>Visitor Tracking API</h2>

    <h3>List Visitors</h3>
    <p>Retrieve visitors for a specific property.</p>

    <h4>Endpoint</h4>
    <pre><code>GET /properties/{property_id}/visitors</code></pre>

    <h4>Parameters</h4>
    <ul>
        <li><code>page</code> (optional): Page number for pagination</li>
        <li><code>per_page</code> (optional): Number of visitors per page</li>
        <li><code>interest_level</code> (optional): Filter by interest level (high, medium, low)</li>
        <li><code>date_from</code> (optional): Filter by sign-in date (YYYY-MM-DD)</li>
        <li><code>date_to</code> (optional): Filter by sign-in date (YYYY-MM-DD)</li>
    </ul>

    <h4>Response</h4>
    <pre><code>{
  "data": [
    {
      "id": "uuid",
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "+1234567890",
      "interest_level": "high",
      "timeline": "1-3 months",
      "financing": "cash",
      "notes": "Interested in the backyard",
      "signed_in_at": "2024-01-15T14:30:00Z",
      "created_at": "2024-01-15T14:30:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 25,
    "last_page": 2
  }
}</code></pre>

    <h3>Get Visitor</h3>
    <p>Retrieve a specific visitor by ID.</p>

    <h4>Endpoint</h4>
    <pre><code>GET /properties/{property_id}/visitors/{visitor_id}</code></pre>

    <h3>Create Visitor</h3>
    <p>Create a new visitor sign-in record.</p>

    <h4>Endpoint</h4>
    <pre><code>POST /properties/{property_id}/visitors</code></pre>

    <h4>Request Body</h4>
    <pre><code>{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "interest_level": "high",
  "timeline": "1-3 months",
  "financing": "cash",
  "notes": "Interested in the backyard"
}</code></pre>

    <h2>File Upload API</h2>

    <h3>Upload Property Images</h3>
    <p>Upload images for a property.</p>

    <h4>Endpoint</h4>
    <pre><code>POST /properties/{property_id}/images</code></pre>

    <h4>Request</h4>
    <p>Use multipart/form-data to upload files.</p>
    <ul>
        <li><code>featured_image</code> (optional): Set as featured image</li>
        <li><code>gallery_images[]</code> (optional): Array of gallery images</li>
    </ul>

    <h4>Response</h4>
    <pre><code>{
  "data": {
    "featured_image": "https://...",
    "gallery_images": ["https://...", "https://..."]
  }
}</code></pre>

    <h2>Export API</h2>

    <h3>Export Property Data</h3>
    <p>Export property data in various formats.</p>

    <h4>Endpoint</h4>
    <pre><code>GET /properties/{id}/export</code></pre>

    <h4>Parameters</h4>
    <ul>
        <li><code>format</code> (required): Export format (pdf, csv, json)</li>
        <li><code>include_images</code> (optional): Include images in export (default: true)</li>
    </ul>

    <h3>Export Visitor Data</h3>
    <p>Export visitor data for a property.</p>

    <h4>Endpoint</h4>
    <pre><code>GET /properties/{property_id}/visitors/export</code></pre>

    <h4>Parameters</h4>
    <ul>
        <li><code>format</code> (required): Export format (pdf, csv, json)</li>
        <li><code>date_from</code> (optional): Filter by date range</li>
        <li><code>date_to</code> (optional): Filter by date range</li>
    </ul>

    <h2>Error Handling</h2>

    <h3>Error Response Format</h3>
    <p>All errors follow a consistent format:</p>
    <pre><code>{
  "error": {
    "message": "Error description",
    "code": "ERROR_CODE",
    "details": {
      "field": "Additional error details"
    }
  }
}</code></pre>

    <h3>Common Error Codes</h3>
    <ul>
        <li><code>401</code>: Unauthorized (invalid API key)</li>
        <li><code>403</code>: Forbidden (insufficient permissions)</li>
        <li><code>404</code>: Not found (resource doesn't exist)</li>
        <li><code>422</code>: Validation error (invalid request data)</li>
        <li><code>429</code>: Rate limit exceeded</li>
        <li><code>500</code>: Internal server error</li>
    </ul>

    <h3>Rate Limiting</h3>
    <p>API requests are rate limited to ensure fair usage:</p>
    <ul>
        <li><strong>Limit:</strong> 1000 requests per hour per API key</li>
        <li><strong>Headers:</strong> Rate limit info included in response headers</li>
        <li><strong>Exceeded:</strong> Returns 429 status code when limit exceeded</li>
    </ul>

    <h2>SDKs and Libraries</h2>

    <h3>Official SDKs</h3>
    <p>We provide official SDKs for popular programming languages:</p>
    <ul>
        <li><strong>JavaScript/Node.js:</strong> <code>npm install openhouse-api</code></li>
        <li><strong>PHP:</strong> <code>composer require openhouse/api</code></li>
        <li><strong>Python:</strong> <code>pip install openhouse-api</code></li>
        <li><strong>Ruby:</strong> <code>gem install openhouse-api</code></li>
    </ul>

    <h3>Example Usage (JavaScript)</h3>
    <pre><code>const OpenHouse = require('openhouse-api');

const client = new OpenHouse({
  apiKey: 'YOUR_API_KEY'
});

// List properties
const properties = await client.properties.list();

// Create a property
const property = await client.properties.create({
  title: 'Beautiful Home',
  price: 450000,
  address: '123 Main St',
  city: 'Anytown',
  state: 'CA',
  zip_code: '90210'
});</code></pre>

    <h2>Webhooks</h2>

    <h3>Setting Up Webhooks</h3>
    <p>Receive real-time notifications when events occur:</p>
    <ul>
        <li><strong>Property Created:</strong> When a new property is created</li>
        <li><strong>Property Updated:</strong> When a property is modified</li>
        <li><strong>Visitor Signed In:</strong> When a visitor signs in</li>
        <li><strong>Subscription Events:</strong> Billing and subscription changes</li>
    </ul>

    <h3>Webhook Configuration</h3>
    <pre><code>POST /webhooks
{
  "url": "https://your-app.com/webhooks/openhouse",
  "events": ["property.created", "visitor.signed_in"],
  "secret": "your-webhook-secret"
}</code></pre>

    <h3>Webhook Payload</h3>
    <pre><code>{
  "event": "property.created",
  "timestamp": "2024-01-15T10:30:00Z",
  "data": {
    "property": {
      "id": "uuid",
      "title": "Beautiful Home",
      "price": 450000
    }
  }
}</code></pre>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-blue-900 font-semibold mb-2">Pro Tips</h3>
        <ul class="text-blue-800 space-y-1">
            <li>• Always handle rate limiting in your applications</li>
            <li>• Use webhooks for real-time updates instead of polling</li>
            <li>• Implement proper error handling for all API calls</li>
            <li>• Cache responses when appropriate to reduce API calls</li>
            <li>• Test your integration in our sandbox environment first</li>
        </ul>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-200">
        <h2>Next Steps</h2>
        <p>Ready to integrate with Open House?</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <a href="{{ route('register') }}" class="block bg-indigo-600 text-white px-6 py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                Get API Access
            </a>
            <a href="/docs/faq" class="block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                Frequently Asked Questions
            </a>
        </div>
    </div>
</div>
@endsection
