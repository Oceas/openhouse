<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'trial_ends_at' => 'datetime',
        ];
    }

    /**
     * Get the properties for the user.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get the teams the user belongs to.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withPivot('role', 'permissions')
                    ->withTimestamps();
    }

    /**
     * Get the team the user owns.
     */
    public function ownedTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'owner_id');
    }

    /**
     * Get the primary team for the user (owned team or first joined team).
     */
    public function primaryTeam(): ?Team
    {
        return $this->ownedTeam ?? $this->teams()->first();
    }

    /**
     * Check if user is part of any team.
     */
    public function hasTeam(): bool
    {
        return $this->ownedTeam()->exists() || $this->teams()->exists();
    }

    /**
     * Boot method for automatic UUID generation and trial setup
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = Uuid::uuid4()->toString();
            }

            // Set trial period to 14 days from now
            if (empty($user->trial_ends_at)) {
                $user->trial_ends_at = now()->addDays(14);
            }
        });
    }

    /**
     * Determine if the user has access to the platform
     */
    public function hasAccess(): bool
    {
        return $this->onTrial() || $this->subscribed('default');
    }

    /**
     * Determine if the user is on trial
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Get the number of trial days remaining
     */
    public function trialDaysRemaining(): int
    {
        if (!$this->onTrial()) {
            return 0;
        }

        return max(0, now()->diffInDays($this->trial_ends_at, false));
    }
}
