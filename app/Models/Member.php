<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'logo_size',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('images/members/' . $this->logo);
        }
        return asset('images/members/placeholder.png');
    }
}