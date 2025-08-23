<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'slug',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    // Relationships
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withPivot('role', 'permissions')
                    ->withTimestamps();
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function visitorSignins(): HasMany
    {
        return $this->hasMany(VisitorSignin::class);
    }

    // Helper methods
    public function hasUser(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    public function getUserRole(User $user): ?string
    {
        $pivot = $this->users()->where('user_id', $user->id)->first()?->pivot;
        return $pivot ? $pivot->role : null;
    }

    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    public function isAdmin(User $user): bool
    {
        return $this->getUserRole($user) === 'admin' || $this->isOwner($user);
    }

    public function canInviteUsers(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function canManageProperties(User $user): bool
    {
        return $this->hasUser($user);
    }

    public function canViewAnalytics(User $user): bool
    {
        return $this->hasUser($user);
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopeForUser($query, User $user)
    {
        return $query->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orWhere('owner_id', $user->id);
    }

    // Static methods
    public static function createForUser(User $user, array $data): self
    {
        $team = self::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'owner_id' => $user->id,
            'slug' => $data['name'],
        ]);

        // Add the user as owner
        $team->users()->attach($user->id, ['role' => 'owner']);

        return $team;
    }
}
