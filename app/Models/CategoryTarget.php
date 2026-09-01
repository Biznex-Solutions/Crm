<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_deals',
        'status',
    ];

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
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

    public function users()
    {
        return $this->hasMany(User::class, 'category_target_id');
    }
}

