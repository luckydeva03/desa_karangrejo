<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 
        'status', 'replied_at', 'reply'
    ];

    protected $casts = [
        'replied_at' => 'datetime'
    ];

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeUnread($query)
    {
        return $query->whereIn('status', ['new', 'read']);
    }

    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    public function markAsReplied($reply = null)
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
            'reply' => $reply
        ]);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => 'primary',
            'read' => 'warning',
            'replied' => 'success',
            default => 'secondary'
        };
    }
}