<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $property->title }} - Property Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .property-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .property-address {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .price {
            font-size: 32px;
            font-weight: bold;
            color: #059669;
            margin-bottom: 20px;
        }
        .main-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .gallery-collage {
            margin-bottom: 30px;
        }
        .gallery-table {
            width: 100%;
            border-collapse: collapse;
        }
        .gallery-table td {
            padding: 5px;
            vertical-align: top;
        }
        .gallery-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .gallery-image.large {
            height: 245px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }
        .detail-value {
            font-weight: 500;
            color: #1f2937;
        }
        .description {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .features {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .mls-info {
            background: #fef3c7;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .open-house {
            background: #fef2f2;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        @media print {
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="property-title">{{ $property->title }}</div>
        <div class="property-address">{{ $property->full_address }}</div>
        <div class="price">{{ $property->formatted_price }}</div>
    </div>

    @if($property->featured_image)
        <img src="{{ storage_path('app/public/' . $property->featured_image) }}" alt="{{ $property->title }}" class="main-image">
    @endif

    @if($property->gallery_images && count($property->gallery_images) > 0)
        <div class="gallery-collage">
            <table class="gallery-table">
                <tr>
                    @foreach(array_slice($property->gallery_images, 0, 3) as $index => $image)
                        <td style="width: {{ $index === 0 ? '50%' : '25%' }};">
                            <img src="{{ storage_path('app/public/' . $image) }}"
                                 alt="Gallery Image {{ $index + 1 }}"
                                 class="gallery-image {{ $index === 0 ? 'large' : '' }}">
                        </td>
                    @endforeach
                </tr>
                @if(count($property->gallery_images) > 3)
                    <tr>
                        @foreach(array_slice($property->gallery_images, 3, 3) as $index => $image)
                            <td style="width: 33.33%;">
                                <img src="{{ storage_path('app/public/' . $image) }}"
                                     alt="Gallery Image {{ $index + 4 }}"
                                     class="gallery-image">
                            </td>
                        @endforeach
                    </tr>
                @endif
            </table>
        </div>
    @endif

    <div class="section">
        <div class="section-title">Property Details</div>
        <div class="details-grid">
            @if($property->mls_number)
                <div class="detail-item">
                    <span class="detail-label">MLS Number:</span>
                    <span class="detail-value">{{ $property->mls_number }}</span>
                </div>
            @endif
            <div class="detail-item">
                <span class="detail-label">Property Type:</span>
                <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">{{ ucfirst($property->status) }}</span>
            </div>
            @if($property->bedrooms)
                <div class="detail-item">
                    <span class="detail-label">Bedrooms:</span>
                    <span class="detail-value">{{ $property->bedrooms }}</span>
                </div>
            @endif
            @if($property->bathrooms)
                <div class="detail-item">
                    <span class="detail-label">Bathrooms:</span>
                    <span class="detail-value">{{ $property->bathrooms }}</span>
                </div>
            @endif
            @if($property->square_feet)
                <div class="detail-item">
                    <span class="detail-label">Square Feet:</span>
                    <span class="detail-value">{{ number_format($property->square_feet) }}</span>
                </div>
            @endif
            @if($property->lot_size)
                <div class="detail-item">
                    <span class="detail-label">Lot Size:</span>
                    <span class="detail-value">{{ $property->formatted_lot_size }}</span>
                </div>
            @endif
            @if($property->year_built)
                <div class="detail-item">
                    <span class="detail-label">Year Built:</span>
                    <span class="detail-value">{{ $property->year_built }}</span>
                </div>
            @endif
            @if($property->garage_spaces)
                <div class="detail-item">
                    <span class="detail-label">Garage:</span>
                    <span class="detail-value">{{ $property->garage_spaces }}</span>
                </div>
            @endif
            @if($property->heating_type)
                <div class="detail-item">
                    <span class="detail-label">Heating:</span>
                    <span class="detail-value">{{ $property->heating_type }}</span>
                </div>
            @endif
            @if($property->cooling_type)
                <div class="detail-item">
                    <span class="detail-label">Cooling:</span>
                    <span class="detail-value">{{ $property->cooling_type }}</span>
                </div>
            @endif
            @if($property->flooring)
                <div class="detail-item">
                    <span class="detail-label">Flooring:</span>
                    <span class="detail-value">{{ $property->flooring }}</span>
                </div>
            @endif
        </div>
    </div>

    @if($property->description)
        <div class="section">
            <div class="section-title">Description</div>
            <div class="description">
                {!! $property->description !!}
            </div>
        </div>
    @endif

    @if($property->exterior_features || $property->interior_features || $property->community_features)
        <div class="section">
            <div class="section-title">Features</div>
            <div class="features">
                @if($property->exterior_features)
                    <div style="margin-bottom: 15px;">
                        <strong>Exterior Features:</strong><br>
                        {{ $property->exterior_features }}
                    </div>
                @endif
                @if($property->interior_features)
                    <div style="margin-bottom: 15px;">
                        <strong>Interior Features:</strong><br>
                        {{ $property->interior_features }}
                    </div>
                @endif
                @if($property->community_features)
                    <div>
                        <strong>Community Features:</strong><br>
                        {{ $property->community_features }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="section">
        <div class="section-title">Pricing & Financial Information</div>
        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">List Price:</span>
                <span class="detail-value">{{ $property->formatted_price }}</span>
            </div>
            @if($property->original_price && $property->original_price != $property->list_price)
                <div class="detail-item">
                    <span class="detail-label">Original Price:</span>
                    <span class="detail-value">${{ number_format($property->original_price) }}</span>
                </div>
            @endif
            @if($property->formatted_price_per_sqft !== 'N/A')
                <div class="detail-item">
                    <span class="detail-label">Price per Sq Ft:</span>
                    <span class="detail-value">{{ $property->formatted_price_per_sqft }}</span>
                </div>
            @endif
            @if($property->property_tax)
                <div class="detail-item">
                    <span class="detail-label">Property Tax:</span>
                    <span class="detail-value">{{ $property->property_tax }}</span>
                </div>
            @endif
            @if($property->hoa_fees)
                <div class="detail-item">
                    <span class="detail-label">HOA Fees:</span>
                    <span class="detail-value">{{ $property->hoa_fees }}</span>
                </div>
            @endif
        </div>
    </div>

    @if($property->listing_office || $property->listing_agent || $property->buyer_agent_commission)
        <div class="section">
            <div class="section-title">MLS Information</div>
            <div class="mls-info">
                <div class="details-grid">
                    @if($property->listing_office)
                        <div class="detail-item">
                            <span class="detail-label">Listing Office:</span>
                            <span class="detail-value">{{ $property->listing_office }}</span>
                        </div>
                    @endif
                    @if($property->listing_agent)
                        <div class="detail-item">
                            <span class="detail-label">Listing Agent:</span>
                            <span class="detail-value">{{ $property->listing_agent }}</span>
                        </div>
                    @endif
                    @if($property->buyer_agent_commission)
                        <div class="detail-item">
                            <span class="detail-label">Buyer Agent Commission:</span>
                            <span class="detail-value">{{ $property->buyer_agent_commission }}</span>
                        </div>
                    @endif
                    @if($property->list_date)
                        <div class="detail-item">
                            <span class="detail-label">List Date:</span>
                            <span class="detail-value">{{ $property->list_date->format('M j, Y') }}</span>
                        </div>
                    @endif
                    @if($property->expiration_date)
                        <div class="detail-item">
                            <span class="detail-label">Expiration Date:</span>
                            <span class="detail-value">{{ $property->expiration_date->format('M j, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if($property->has_open_house)
        <div class="section">
            <div class="section-title">Open House Information</div>
            <div class="open-house">
                <div class="details-grid">
                    @if($property->open_house_start)
                        <div class="detail-item">
                            <span class="detail-label">Start Time:</span>
                            <span class="detail-value">{{ $property->open_house_start->format('M j, Y g:i A') }}</span>
                        </div>
                    @endif
                    @if($property->open_house_end)
                        <div class="detail-item">
                            <span class="detail-label">End Time:</span>
                            <span class="detail-value">{{ $property->open_house_end->format('M j, Y g:i A') }}</span>
                        </div>
                    @endif
                </div>
                @if($property->open_house_notes)
                    <div style="margin-top: 15px;">
                        <strong>Notes:</strong><br>
                        {{ $property->open_house_notes }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Generated by Open House Management System</p>
        <p>Property ID: {{ $property->id }} | Generated on: {{ now()->format('M j, Y g:i A') }}</p>
    </div>
</body>
</html>
