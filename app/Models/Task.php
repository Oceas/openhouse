<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'client_id',
        'deal_id',
        'property_id',
        'title',
        'description',
        'type',
        'priority',
        'status',
        'due_date',
        'completed_at',
        'assigned_to',
        'notes',
        'reminders',
        'custom_fields',
    ];

    protected $casts = [
        'reminders' => 'array',
        'custom_fields' => 'array',
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public static function getTypeOptions(): array
    {
        return [
            'call' => 'Phone Call',
            'email' => 'Email',
            'meeting' => 'Meeting',
            'showing' => 'Property Showing',
            'follow_up' => 'Follow Up',
            'proposal' => 'Proposal',
            'contract' => 'Contract',
            'closing' => 'Closing',
            'other' => 'Other',
        ];
    }

    public static function getPriorityOptions(): array
    {
        return [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    }

    public function isOverdue(): bool
    {
        return $this->due_date &&
               $this->due_date->isPast() &&
               $this->status !== 'completed';
    }

    public function isDueToday(): bool
    {
        return $this->due_date &&
               $this->due_date->isToday() &&
               $this->status !== 'completed';
    }

    public function isDueSoon(int $days = 3): bool
    {
        return $this->due_date &&
               $this->due_date->isBetween(now(), now()->addDays($days)) &&
               $this->status !== 'completed';
    }
}
