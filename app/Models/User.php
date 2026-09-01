<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status', 'phone', 'designation', 'category_target_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('designation', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }
        return $query;
    }

    public function scopeFilterRole($query, $role)
    {
        if ($role && in_array($role, ['admin', 'employee'])) {
            $query->where('role', $role);
        }
        return $query;
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status && in_array($status, ['active', 'inactive'])) {
            $query->where('status', $status);
        }
        return $query;
    }

    public function categoryTarget()
    {
        return $this->belongsTo(CategoryTarget::class, 'category_target_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function followups()
    {
        return $this->hasMany(LeadFollowup::class);
    }
}

