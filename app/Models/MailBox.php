<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mailbox extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'quota',
        'storage_used',
        'active',
        'last_login',
    ];

    protected $casts = [
        'active' => 'boolean',
        'quota' => 'integer',
        'storage_used' => 'integer',
        'last_login' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at']; // Added for SoftDeletes

    // Relaciones
    public function aliases()
    {
        return $this->hasMany(EmailAlias::class);
    }

    public function forwardersAsSource()
    {
        return $this->hasMany(Forwarder::class, 'source_email', 'email');
    }

    public function forwardersAsDestination()
    {
        return $this->hasMany(Forwarder::class, 'destination_email', 'email');
    }

    public function autoReplies()
    {
        return $this->hasMany(AutoReply::class);
    }

    // Accessors
    public function getUsagePercentageAttribute()
    {
        if (!$this->quota) {
            return 0; // Unlimited
        }
        
        return round(($this->storage_used / ($this->quota * 1024 * 1024)) * 100, 2);
    }

    public function getFormattedStorageUsedAttribute()
    {
        return $this->formatBytes($this->storage_used);
    }

    public function getFormattedQuotaAttribute()
    {
        if (!$this->quota) {
            return 'Unlimited';
        }
        
        return $this->formatBytes($this->quota * 1024 * 1024);
    }

    // Métodos auxiliares
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public function getUsername()
    {
        return explode('@', $this->email)[0];
    }

    public function getDomain()
    {
        return explode('@', $this->email)[1];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }
}
