<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Communication extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'client_id',
        'deal_id',
        'property_id',
        'type',
        'direction',
        'subject',
        'content',
        'duration',
        'scheduled_at',
        'completed_at',
        'status',
        'notes',
        'attachments',
        'external_id',
        'metadata',
    ];

    protected $casts = [
        'attachments' => 'array',
        'metadata' => 'array',
        'scheduled_at' => 'datetime',
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
            'email' => 'Email',
            'phone' => 'Phone Call',
            'text' => 'Text Message',
            'meeting' => 'Meeting',
            'showing' => 'Property Showing',
            'open_house' => 'Open House',
            'follow_up' => 'Follow Up',
            'proposal' => 'Proposal',
            'contract' => 'Contract',
            'other' => 'Other',
        ];
    }

    public static function getDirectionOptions(): array
    {
        return [
            'inbound' => 'Inbound',
            'outbound' => 'Outbound',
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'scheduled' => 'Scheduled',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'no_show' => 'No Show',
        ];
    }
}
