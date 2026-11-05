<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'action_url',
        'is_read',
        'read_at',
        'expires_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'info' => 'Informasi',
            'success' => 'Sukses',
            'warning' => 'Peringatan',
            'error' => 'Error',
            default => ucfirst($this->type),
        };
    }

    public function getIconClassAttribute(): string
    {
        return match($this->type) {
            'info' => 'fas fa-info-circle text-blue-500',
            'success' => 'fas fa-check-circle text-green-500',
            'warning' => 'fas fa-exclamation-triangle text-yellow-500',
            'error' => 'fas fa-times-circle text-red-500',
            default => 'fas fa-bell text-gray-500',
        };
    }

    public static function createForUser($userId, string $title, string $message, string $type = 'info', string $actionUrl = null, string $icon = null): static
    {
        return static::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
            'icon' => $icon,
        ]);
    }
}
