# Geocoding Setup Guide
m
This guide explains how to set up automatic geocoding for properties in the Open House platform using OpenStreetMap's free Nominatim service.

## Overview

The geocoding feature automatically converts property addresses to latitude and longitude coordinates when properties are created or updated. This enables properties to be displayed on maps throughout the application.

## Setup

### ✅ No API Key Required!

The system uses **OpenStreetMap Nominatim**, a completely free geocoding service that doesn't require any API keys or registration.

### How It Works

The geocoding service automatically:
1. Builds a full address from the property's address components
2. Sends the address to OpenStreetMap's Nominatim service
3. Stores the returned latitude and longitude coordinates
4. Logs any errors for debugging

## Address Components Used

The system uses these fields to build the full address:
- `street_address`
- `city`
- `state`
- `zip_code`

## When Geocoding Occurs

- **Creating a property**: Always attempts to geocode
- **Updating a property**: Only geocodes if address fields have changed

## Manual Geocoding

### Command Line Tool

Use the Artisan command to geocode existing properties:

```bash
# Geocode up to 50 properties (default)
php artisan properties:geocode

# Geocode a specific number of properties
php artisan properties:geocode --limit=100

# Dry run to see what would be geocoded
php artisan properties:geocode --dry-run
```

### Test the Service

Test the geocoding service with any address:

```bash
# Test with default address (White House)
php artisan test:geocoding

# Test with custom address
php artisan test:geocoding "123 Main St, Anytown, CA 90210"
```

### Command Options

- `--limit=50`: Number of properties to process (default: 50)
- `--dry-run`: Show what would be geocoded without making changes

## Service Information

- **Service**: OpenStreetMap Nominatim
- **Cost**: Completely free
- **Rate Limit**: 1 request per second
- **Attribution**: © OpenStreetMap contributors
- **Usage Policy**: [https://operations.osmfoundation.org/policies/nominatim/](https://operations.osmfoundation.org/policies/nominatim/)

## Error Handling

### Common Issues

1. **Incomplete Address**: Properties with missing address components are skipped
2. **Rate Limiting**: Built-in 1-second delays prevent hitting rate limits
3. **Invalid Address**: Failed geocoding attempts are logged
4. **Network Issues**: Connection problems are handled gracefully

### Logging

All geocoding activities are logged to Laravel's log files:
- Successful geocoding: Info level
- Failed geocoding: Warning level
- Network errors: Error level

## Database Schema

The `properties` table includes these fields for coordinates:

```sql
latitude DECIMAL(10,8)
longitude DECIMAL(11,8)
```

## Usage in Views

Properties with coordinates can be displayed on maps:

```php
// Check if property has coordinates
if ($property->hasCoordinates()) {
    // Display on map
    $coordinates = $property->coordinates; // Returns ['latitude' => x, 'longitude' => y]
}
```

## Map Integration

### OpenStreetMap Links

Generated coordinates can be used with OpenStreetMap:

```php
$mapsUrl = "https://www.openstreetmap.org/?mlat={$property->latitude}&mlon={$property->longitude}&zoom=15";
```

### Google Maps Links

Coordinates also work with Google Maps:

```php
$googleMapsUrl = "https://www.google.com/maps?q={$property->latitude},{$property->longitude}";
```

## Advantages of OpenStreetMap Nominatim

### ✅ Benefits

- **Completely Free**: No API keys, no costs, no usage limits
- **Open Source**: Transparent and community-driven
- **Global Coverage**: Worldwide address coverage
- **No Registration**: Start using immediately
- **Reliable**: Used by millions of applications worldwide

### ⚠️ Considerations

- **Rate Limiting**: 1 request per second (built-in delays handle this)
- **Accuracy**: May be slightly less accurate than commercial services for some addresses
- **Attribution**: Requires OpenStreetMap attribution (automatically handled)

## Troubleshooting

### Properties Not Geocoding

1. Verify the address components are complete
2. Check the logs for error messages
3. Run the manual geocoding command to test
4. Try the test command with a known address

### Rate Limiting

The system automatically handles rate limiting with 1-second delays between requests. If you need to process many properties, the command will take longer but will work reliably.

### Address Format Issues

- Ensure addresses are in a standard format
- Include city, state, and zip code for better accuracy
- Try different address variations if geocoding fails

## Security Notes

- No API keys to manage or secure
- No usage tracking or billing concerns
- Standard HTTP requests with proper User-Agent headers
- Respects OpenStreetMap's usage policy automatically

## Migration from Google Maps

If you were previously using Google Maps:

1. **No configuration changes needed** - the system works immediately
2. **No API key required** - remove any Google Maps API keys
3. **Same functionality** - all geocoding features work identically
4. **Better cost** - completely free vs. $5 per 1,000 requests

The system is now ready to automatically generate latitude and longitude coordinates for all properties using the free OpenStreetMap service! 🗺️
