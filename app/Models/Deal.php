<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Deal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'client_id',
        'property_id',
        'title',
        'description',
        'type',
        'stage',
        'value',
        'commission_rate',
        'commission_amount',
        'expected_close_date',
        'actual_close_date',
        'probability',
        'source',
        'notes',
        'activities',
        'assigned_to',
        'custom_fields',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'probability' => 'decimal:2',
        'activities' => 'array',
        'custom_fields' => 'array',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
    ];

    /**
     * Get the user that owns the deal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the client for the deal.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the property for the deal.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the communications for the deal.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    /**
     * Get the tasks for the deal.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the formatted value.
     */
    public function getFormattedValueAttribute(): string
    {
        return $this->value ? '$' . number_format($this->value) : 'Not specified';
    }

    /**
     * Get the formatted commission.
     */
    public function getFormattedCommissionAttribute(): string
    {
        return $this->commission_amount ? '$' . number_format($this->commission_amount) : 'Not calculated';
    }

    /**
     * Get the stage color for UI.
     */
    public function getStageColorAttribute(): string
    {
        return match($this->stage) {
            'prospecting' => 'gray',
            'qualification' => 'blue',
            'proposal' => 'yellow',
            'negotiation' => 'orange',
            'closing' => 'purple',
            'closed_won' => 'green',
            'closed_lost' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get the type options.
     */
    public static function getTypeOptions(): array
    {
        return [
            'buy' => 'Buy',
            'sell' => 'Sell',
            'rent' => 'Rent',
        ];
    }

    /**
     * Get the stage options.
     */
    public static function getStageOptions(): array
    {
        return [
            'prospecting' => 'Prospecting',
            'qualification' => 'Qualification',
            'proposal' => 'Proposal',
            'negotiation' => 'Negotiation',
            'closing' => 'Closing',
            'closed_won' => 'Closed Won',
            'closed_lost' => 'Closed Lost',
        ];
    }

    /**
     * Get the source options.
     */
    public static function getSourceOptions(): array
    {
        return [
            'referral' => 'Referral',
            'website' => 'Website',
            'open_house' => 'Open House',
            'cold_call' => 'Cold Call',
            'social_media' => 'Social Media',
            'advertisement' => 'Advertisement',
            'other' => 'Other',
        ];
    }

    /**
     * Scope to filter by stage.
     */
    public function scopeByStage($query, $stage)
    {
        return $query->where('stage', $stage);
    }

    /**
     * Scope to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by assigned agent.
     */
    public function scopeByAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope to get active deals.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('stage', ['closed_won', 'closed_lost']);
    }

    /**
     * Scope to get closed deals.
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('stage', ['closed_won', 'closed_lost']);
    }

    /**
     * Scope to get deals closing soon.
     */
    public function scopeClosingSoon($query, $days = 30)
    {
        return $query->where('expected_close_date', '<=', now()->addDays($days))
                    ->where('expected_close_date', '>=', now());
    }

    /**
     * Scope to get overdue deals.
     */
    public function scopeOverdue($query)
    {
        return $query->where('expected_close_date', '<', now())
                    ->whereNotIn('stage', ['closed_won', 'closed_lost']);
    }

    /**
     * Calculate commission amount.
     */
    public function calculateCommission(): float
    {
        if (!$this->value || !$this->commission_rate) {
            return 0;
        }
        return ($this->value * $this->commission_rate) / 100;
    }

    /**
     * Update commission amount.
     */
    public function updateCommission(): void
    {
        $this->update(['commission_amount' => $this->calculateCommission()]);
    }

    /**
     * Check if deal is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->expected_close_date &&
               $this->expected_close_date->isPast() &&
               !in_array($this->stage, ['closed_won', 'closed_lost']);
    }

    /**
     * Check if deal is closing soon.
     */
    public function isClosingSoon(int $days = 30): bool
    {
        return $this->expected_close_date &&
               $this->expected_close_date->isBetween(now(), now()->addDays($days));
    }

    /**
     * Get days until close.
     */
    public function getDaysUntilClose(): int
    {
        if (!$this->expected_close_date) {
            return 999;
        }
        return $this->expected_close_date->diffInDays(now());
    }

    /**
     * Mark as won.
     */
    public function markAsWon(): void
    {
        $this->update([
            'stage' => 'closed_won',
            'actual_close_date' => now(),
        ]);
    }

    /**
     * Mark as lost.
     */
    public function markAsLost(): void
    {
        $this->update([
            'stage' => 'closed_lost',
            'actual_close_date' => now(),
        ]);
    }

    /**
     * Add activity to the deal.
     */
    public function addActivity(string $activity, string $type = 'note'): void
    {
        $activities = $this->activities ?? [];
        $activities[] = [
            'type' => $type,
            'activity' => $activity,
            'timestamp' => now()->toISOString(),
        ];
        $this->update(['activities' => $activities]);
    }

    /**
     * Get total deal value for user.
     */
    public static function getTotalValueForUser(string $userId): float
    {
        return static::where('user_id', $userId)
                    ->where('stage', 'closed_won')
                    ->sum('value');
    }

    /**
     * Get total commission for user.
     */
    public static function getTotalCommissionForUser(string $userId): float
    {
        return static::where('user_id', $userId)
                    ->where('stage', 'closed_won')
                    ->sum('commission_amount');
    }
}
