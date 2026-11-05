<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'principal_name',
        'level',
        'student_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'student_count' => 'integer',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function topups(): HasMany
    {
        return $this->hasMany(Topup::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function getFormattedStudentCountAttribute(): string
    {
        return number_format($this->student_count, 0, ',', '.');
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->address}";
    }
}
