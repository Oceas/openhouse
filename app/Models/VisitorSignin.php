<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class VisitorSignin extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'property_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'current_home_status',
        'timeline_to_buy',
        'budget_min',
        'budget_max',
        'additional_notes',
        'source',
        'interested_in_similar_properties',
        'interested_in_financing_info',
        'interested_in_market_analysis',
        'ip_address',
        'user_agent',
        'signed_in_at',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'interested_in_similar_properties' => 'boolean',
        'interested_in_financing_info' => 'boolean',
        'interested_in_market_analysis' => 'boolean',
        'signed_in_at' => 'datetime',
    ];

    /**
     * Get the property that the visitor signed in for.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the full name of the visitor.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the formatted budget range.
     */
    public function getBudgetRangeAttribute(): string
    {
        if ($this->budget_min && $this->budget_max) {
            return '$' . number_format($this->budget_min) . ' - $' . number_format($this->budget_max);
        } elseif ($this->budget_min) {
            return '$' . number_format($this->budget_min) . '+';
        } elseif ($this->budget_max) {
            return 'Up to $' . number_format($this->budget_max);
        }
        return 'Not specified';
    }

    /**
     * Get the formatted address.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([$this->address, $this->city, $this->state, $this->zip_code]);
        return implode(', ', $parts);
    }

    /**
     * Get timeline options for forms.
     */
    public static function getTimelineOptions(): array
    {
        return [
            'immediately' => 'Immediately',
            '1-3_months' => '1-3 months',
            '3-6_months' => '3-6 months',
            '6_months_plus' => '6+ months',
            'just_browsing' => 'Just browsing',
        ];
    }

    /**
     * Get home status options for forms.
     */
    public static function getHomeStatusOptions(): array
    {
        return [
            'own' => 'Own',
            'rent' => 'Rent',
            'looking' => 'Looking to buy',
            'other' => 'Other',
        ];
    }

    /**
     * Get source options for forms.
     */
    public static function getSourceOptions(): array
    {
        return [
            'zillow' => 'Zillow',
            'realtor' => 'Realtor.com',
            'redfin' => 'Redfin',
            'social_media' => 'Social Media',
            'friend_family' => 'Friend/Family',
            'drive_by' => 'Drive by',
            'sign' => 'Open house sign',
            'agent' => 'Agent referral',
            'other' => 'Other',
        ];
    }

    /**
     * Boot method for automatic UUID generation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($visitorSignin) {
            if (empty($visitorSignin->id)) {
                $visitorSignin->id = Uuid::uuid4()->toString();
            }
            if (empty($visitorSignin->signed_in_at)) {
                $visitorSignin->signed_in_at = now();
            }
        });
    }
}
