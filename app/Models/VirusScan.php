<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirusScan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email_id',
        'sender_email',
        'recipient_email',
        'subject',
        'scan_result',
        'threat_type',
        'threat_name',
        'file_name',
        'file_hash',
        'scan_engine',
        'quarantined',
        'scanned_at',
    ];

    protected $casts = [
        'quarantined' => 'boolean',
        'scanned_at' => 'datetime',
    ];

    // Scopes
    public function scopeThreatDetected($query)
    {
        return $query->where('scan_result', 'threat_detected');
    }

    public function scopeClean($query)
    {
        return $query->where('scan_result', 'clean');
    }

    public function scopeQuarantined($query)
    {
        return $query->where('quarantined', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scanned_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('scanned_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('scanned_at', now()->month)
                    ->whereYear('scanned_at', now()->year);
    }

    // Accessors
    public function getScanResultBadgeAttribute()
    {
        return match($this->scan_result) {
            'clean' => 'bg-green-100 text-green-800',
            'threat_detected' => 'bg-red-100 text-red-800',
            'suspicious' => 'bg-yellow-100 text-yellow-800',
            'error' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getThreatTypeIconAttribute()
    {
        return match($this->threat_type) {
            'virus' => 'fas fa-bug',
            'malware' => 'fas fa-skull-crossbones',
            'phishing' => 'fas fa-fish',
            'spam' => 'fas fa-ban',
            'suspicious_link' => 'fas fa-link',
            'suspicious_attachment' => 'fas fa-paperclip',
            default => 'fas fa-shield-alt'
        };
    }
}
