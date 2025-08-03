<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrganizationalMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id', 'name', 'position', 'department', 'description',
        'photo', 'phone', 'email', 'sort_order', 'status'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Relationships
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Accessors
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::disk('public')->url($this->photo);
        }
        return asset('images/default-avatar.png'); // Default avatar if no photo
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    public function scopeByPage($query, $pageId)
    {
        return $query->where('page_id', $pageId);
    }

    // Methods
    public function getInitials()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2); // Maximum 2 initials
    }
}
