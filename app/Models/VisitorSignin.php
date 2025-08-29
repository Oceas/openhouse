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
        'lead_status',
        'notes',
        'last_contacted_at',
        'next_follow_up_at',
        'contact_attempts',
        'assigned_to',
        'lead_score',
        'interaction_history',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'interested_in_similar_properties' => 'boolean',
        'interested_in_financing_info' => 'boolean',
        'interested_in_market_analysis' => 'boolean',
        'signed_in_at' => 'datetime',
        'last_contacted_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
        'lead_score' => 'decimal:1',
        'interaction_history' => 'array',
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
     * Get all signins for this visitor across all properties.
     */
    public function getAllSigninsForVisitor(): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('email', $this->email)
            ->orderBy('signed_in_at', 'desc')
            ->get();
    }

    /**
     * Get the total number of properties this visitor has signed in for.
     */
    public function getTotalPropertiesVisitedAttribute(): int
    {
        return static::where('email', $this->email)
            ->distinct('property_id')
            ->count('property_id');
    }

    /**
     * Get the total number of signins for this visitor.
     */
    public function getTotalSigninsAttribute(): int
    {
        return static::where('email', $this->email)->count();
    }

    /**
     * Check if this is a repeat visitor.
     */
    public function getIsRepeatVisitorAttribute(): bool
    {
        return static::where('email', $this->email)->count() > 1;
    }

    /**
     * Get the first signin for this visitor.
     */
    public function getFirstSigninAttribute(): ?self
    {
        return static::where('email', $this->email)
            ->orderBy('signed_in_at', 'asc')
            ->first();
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
     * Get lead status options.
     */
    public static function getLeadStatusOptions(): array
    {
        return [
            'new' => 'New Lead',
            'contacted' => 'Contacted',
            'qualified' => 'Qualified',
            'showing_scheduled' => 'Showing Scheduled',
            'offer_made' => 'Offer Made',
            'closed' => 'Closed',
            'lost' => 'Lost',
        ];
    }

    /**
     * Get lead status color classes.
     */
    public function getLeadStatusColorAttribute(): string
    {
        return match($this->lead_status) {
            'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            'contacted' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'qualified' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'showing_scheduled' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
            'offer_made' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
            'closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'lost' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        };
    }

    /**
     * Calculate lead score based on various factors.
     */
    public function calculateLeadScore(): float
    {
        $score = 0.0;

        // Interest level scoring
        if ($this->interested_in_similar_properties) $score += 2.0;
        if ($this->interested_in_financing_info) $score += 1.5;
        if ($this->interested_in_market_analysis) $score += 1.5;

        // Timeline scoring
        $timelineScore = match($this->timeline_to_buy) {
            'immediately' => 3.0,
            '1-3_months' => 2.5,
            '3-6_months' => 2.0,
            '6_months_plus' => 1.0,
            'just_browsing' => 0.5,
            default => 0.0,
        };
        $score += $timelineScore;

        // Budget scoring (if they have a budget, they're more serious)
        if ($this->budget_min || $this->budget_max) $score += 1.0;

        // Contact attempts (more attempts = higher score)
        $score += min($this->contact_attempts * 0.5, 2.0);

        // Repeat visit scoring (higher interest = higher score)
        $totalSignins = $this->total_signins;
        if ($totalSignins > 1) {
            $score += min(($totalSignins - 1) * 1.0, 3.0); // Up to 3 points for repeat visits
        }

        // Multiple properties visited (shows broader interest)
        $totalProperties = $this->total_properties_visited;
        if ($totalProperties > 1) {
            $score += min(($totalProperties - 1) * 0.5, 2.0); // Up to 2 points for multiple properties
        }

        return min($score, 10.0);
    }

    /**
     * Update lead score.
     */
    public function updateLeadScore(): void
    {
        $this->lead_score = $this->calculateLeadScore();
        $this->save();
    }

    /**
     * Add interaction to history.
     */
    public function addInteraction(string $type, string $description, ?string $userId = null): void
    {
        $history = $this->interaction_history ?? [];
        $history[] = [
            'type' => $type,
            'description' => $description,
            'user_id' => $userId,
            'timestamp' => now()->toISOString(),
        ];
        $this->interaction_history = $history;
        $this->save();
    }

    /**
     * Mark as contacted.
     */
    public function markAsContacted(string $method = 'email'): void
    {
        $this->lead_status = 'contacted';
        $this->last_contacted_at = now();
        $this->contact_attempts++;
        $this->addInteraction('contact', "Contacted via {$method}");
        $this->save();
    }

    /**
     * Schedule follow-up.
     */
    public function scheduleFollowUp(\Carbon\Carbon $date, string $reason = 'Follow-up'): void
    {
        $this->next_follow_up_at = $date;
        $this->addInteraction('follow_up_scheduled', $reason);
        $this->save();
    }

    /**
     * Check if follow-up is overdue.
     */
    public function isFollowUpOverdue(): bool
    {
        return $this->next_follow_up_at && $this->next_follow_up_at->isPast();
    }

    /**
     * Get days since last contact.
     */
    public function getDaysSinceLastContact(): ?int
    {
        return $this->last_contacted_at ? $this->last_contacted_at->diffInDays(now()) : null;
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
