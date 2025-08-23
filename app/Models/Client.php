<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Client extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'job_title',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'client_type',
        'status',
        'budget_min',
        'budget_max',
        'preferences',
        'notes',
        'source',
        'lead_score',
        'last_contacted_at',
        'next_follow_up_at',
        'assigned_to',
        'tags',
        'custom_fields',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'preferences' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'lead_score' => 'decimal:1',
        'last_contacted_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
    ];

    /**
     * Get the user that owns the client.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deals for the client.
     */
    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    /**
     * Get the communications for the client.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    /**
     * Get the tasks for the client.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the visitor sign-ins for the client.
     */
    public function visitorSignins(): HasMany
    {
        return $this->hasMany(VisitorSignin::class, 'email', 'email');
    }

    /**
     * Get the full name of the client.
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
     * Get the status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'inactive' => 'gray',
            'prospect' => 'blue',
            'lead' => 'yellow',
            'customer' => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get the client type options.
     */
    public static function getClientTypeOptions(): array
    {
        return [
            'buyer' => 'Buyer',
            'seller' => 'Seller',
            'both' => 'Buyer & Seller',
        ];
    }

    /**
     * Get the status options.
     */
    public static function getStatusOptions(): array
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'prospect' => 'Prospect',
            'lead' => 'Lead',
            'customer' => 'Customer',
        ];
    }

    /**
     * Get the source options.
     */
    public static function getSourceOptions(): array
    {
        return [
            'website' => 'Website',
            'referral' => 'Referral',
            'social_media' => 'Social Media',
            'open_house' => 'Open House',
            'cold_call' => 'Cold Call',
            'advertisement' => 'Advertisement',
            'other' => 'Other',
        ];
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by client type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('client_type', $type);
    }

    /**
     * Scope to filter by assigned agent.
     */
    public function scopeByAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope to get clients that need follow-up.
     */
    public function scopeNeedsFollowUp($query)
    {
        return $query->where('next_follow_up_at', '<=', now());
    }

    /**
     * Scope to get clients contacted recently.
     */
    public function scopeContactedRecently($query, $days = 7)
    {
        return $query->where('last_contacted_at', '>=', now()->subDays($days));
    }

    /**
     * Calculate and update lead score.
     */
    public function calculateLeadScore(): float
    {
        $score = 0;

        // Base score for having contact info
        if ($this->email) $score += 1;
        if ($this->phone) $score += 1;

        // Score for budget information
        if ($this->budget_min || $this->budget_max) $score += 2;

        // Score for preferences
        if ($this->preferences) $score += 1;

        // Score for recent activity
        if ($this->last_contacted_at && $this->last_contacted_at->diffInDays(now()) <= 30) {
            $score += 2;
        }

        // Score for deal activity
        $activeDeals = $this->deals()->whereIn('stage', ['proposal', 'negotiation', 'closing'])->count();
        $score += $activeDeals * 3;

        // Score for communication frequency
        $recentCommunications = $this->communications()
            ->where('completed_at', '>=', now()->subDays(30))
            ->count();
        $score += min($recentCommunications, 5);

        return min($score, 10.0);
    }

    /**
     * Update lead score.
     */
    public function updateLeadScore(): void
    {
        $this->update(['lead_score' => $this->calculateLeadScore()]);
    }

    /**
     * Mark as contacted.
     */
    public function markAsContacted(): void
    {
        $this->update(['last_contacted_at' => now()]);
    }

    /**
     * Schedule follow-up.
     */
    public function scheduleFollowUp(Carbon $date): void
    {
        $this->update(['next_follow_up_at' => $date]);
    }

    /**
     * Get days since last contact.
     */
    public function getDaysSinceLastContact(): int
    {
        if (!$this->last_contacted_at) {
            return 999; // High number for never contacted
        }
        return $this->last_contacted_at->diffInDays(now());
    }

    /**
     * Check if follow-up is overdue.
     */
    public function isFollowUpOverdue(): bool
    {
        return $this->next_follow_up_at && $this->next_follow_up_at->isPast();
    }

    /**
     * Get total deal value.
     */
    public function getTotalDealValue(): float
    {
        return $this->deals()->where('stage', '!=', 'closed_lost')->sum('value');
    }

    /**
     * Get total commission earned.
     */
    public function getTotalCommission(): float
    {
        return $this->deals()->where('stage', 'closed_won')->sum('commission_amount');
    }
}
