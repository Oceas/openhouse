<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Property extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mls_number',
        'title',
        'description',
        'property_type',
        'status',
        'street_address',
        'city',
        'state',
        'zip_code',
        'county',
        'subdivision',
        'list_price',
        'original_price',
        'price_per_sqft',
        'bedrooms',
        'bathrooms',
        'half_bathrooms',
        'total_bathrooms',
        'square_feet',
        'lot_size',
        'lot_size_units',
        'year_built',
        'garage_spaces',
        'parking_spaces',
        'heating_type',
        'cooling_type',
        'appliances',
        'flooring',
        'roof_type',
        'exterior_features',
        'interior_features',
        'community_features',
        'listing_office',
        'listing_agent',
        'buyer_agent_commission',
        'list_date',
        'expiration_date',
        'days_on_market',
        'property_tax',
        'hoa_fees',
        'hoa_frequency',
        'has_open_house',
        'open_house_start',
        'open_house_end',
        'open_house_notes',
        'featured_image',
        'gallery_images',
        'virtual_tour_url',
        'video_url',
        'meta_title',
        'meta_description',
        'slug',
        'user_id',
    ];

    protected $casts = [
        'list_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'half_bathrooms' => 'integer',
        'total_bathrooms' => 'integer',
        'square_feet' => 'integer',
        'lot_size' => 'integer',
        'year_built' => 'integer',
        'gallery_images' => 'array',
        'has_open_house' => 'boolean',
        'open_house_start' => 'datetime',
        'open_house_end' => 'datetime',
        'list_date' => 'date',
        'expiration_date' => 'date',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the visitor sign-ins for this property.
     */
    public function visitorSignins(): HasMany
    {
        return $this->hasMany(VisitorSignin::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithOpenHouse($query)
    {
        return $query->where('has_open_house', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('property_type', $type);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('list_price', [$min, $max]);
    }

    public function scopeByBedrooms($query, $bedrooms)
    {
        return $query->where('bedrooms', '>=', $bedrooms);
    }

    public function scopeByBathrooms($query, $bathrooms)
    {
        return $query->where('total_bathrooms', '>=', $bathrooms);
    }

    // Accessors
    public function getFullAddressAttribute(): string
    {
        return "{$this->street_address}, {$this->city}, {$this->state} {$this->zip_code}";
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->list_price);
    }

    public function getFormattedPricePerSqftAttribute(): string
    {
        if (!$this->square_feet || $this->square_feet == 0) {
            return 'N/A';
        }
        $pricePerSqft = $this->list_price / $this->square_feet;
        return '$' . number_format($pricePerSqft, 2);
    }

    public function getFormattedLotSizeAttribute(): string
    {
        if (!$this->lot_size) {
            return 'N/A';
        }

        if ($this->lot_size_units === 'acres') {
            return number_format($this->lot_size, 2) . ' acres';
        }

        return number_format($this->lot_size) . ' sqft';
    }

    public function getIsOpenHouseActiveAttribute(): bool
    {
        if (!$this->has_open_house || !$this->open_house_start || !$this->open_house_end) {
            return false;
        }

        $now = now();
        return $now->between($this->open_house_start, $this->open_house_end);
    }

    public function getGalleryImagesArrayAttribute(): array
    {
        return $this->gallery_images ?? [];
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setTotalBathroomsAttribute($value)
    {
        $this->attributes['total_bathrooms'] = ($this->bathrooms ?? 0) + ($this->half_bathrooms ?? 0);
    }

    // Helper methods
    public function getPropertyTypeOptions(): array
    {
        return [
            'single_family' => 'Single Family',
            'condo' => 'Condo',
            'townhouse' => 'Townhouse',
            'multi_family' => 'Multi-Family',
            'land' => 'Land',
            'commercial' => 'Commercial',
            'rental' => 'Rental',
        ];
    }

    public function getStatusOptions(): array
    {
        return [
            'active' => 'Active',
            'pending' => 'Pending',
            'sold' => 'Sold',
            'withdrawn' => 'Withdrawn',
            'expired' => 'Expired',
        ];
    }

    public function getLotSizeUnitsOptions(): array
    {
        return [
            'sqft' => 'Square Feet',
            'acres' => 'Acres',
        ];
    }

    public function getHoaFrequencyOptions(): array
    {
        return [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'annually' => 'Annually',
        ];
    }

    // Boot method for automatic UUID and slug generation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (empty($property->id)) {
                $property->id = Uuid::uuid4()->toString();
            }
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });

        static::updating(function ($property) {
            if ($property->isDirty('title') && empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });
    }
}
