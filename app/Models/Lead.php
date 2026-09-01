<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_source_id',
        'category_target_id',
        'name',
        'email',
        'phone',
        'whatsapp',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function categoryTarget()
    {
        return $this->belongsTo(CategoryTarget::class, 'category_target_id');
    }

    public function followups()
    {
        return $this->hasMany(LeadFollowup::class)->latest();
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('whatsapp', 'like', "%{$term}%")
                  ->orWhere('notes', 'like', "%{$term}%");
            });
        }
        return $query;
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status && in_array($status, ['new', 'contacted', 'in_progress', 'won', 'lost'])) {
            $query->where('status', $status);
        }
        return $query;
    }

    public function scopeFilterSource($query, $sourceId)
    {
        if ($sourceId) {
            $query->where('lead_source_id', $sourceId);
        }
        return $query;
    }

    public function scopeFilterCategory($query, $categoryId)
    {
        if ($categoryId) {
            $query->where('category_target_id', $categoryId);
        }
        return $query;
    }

    public function scopeFilterUser($query, $userId)
    {
        if ($userId) {
            $query->where('user_id', $userId);
        }
        return $query;
    }
}
