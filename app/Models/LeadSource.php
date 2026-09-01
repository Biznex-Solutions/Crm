<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
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
}
