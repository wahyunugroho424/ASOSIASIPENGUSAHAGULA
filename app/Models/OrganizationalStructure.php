<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructure extends Model
{
    protected $fillable = [
        'section', 'title', 'name', 'icon', 'photo',
        'color', 'sort_order', 'is_active',
        'created_by', 'updated_by',
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

    public function scopeBySection($query, string $section)
    {
        return $query->where('section', $section);
    }

    /**
     * URL foto. Fallback ke avatar placeholder jika belum ada foto.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name)
             . '&background=16a34a&color=ffffff&size=200&bold=true&rounded=true';
    }
}