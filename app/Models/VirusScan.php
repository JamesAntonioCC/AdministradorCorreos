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

    protected $dates = ['deleted_at'];

    // Scopes
    public function scopeClean($query)
    {
        return $query->where('scan_result', 'clean');
    }

    public function scopeThreats($query)
    {
        return $query->where('scan_result', '!=', 'clean');
    }

    public function scopeQuarantined($query)
    {
        return $query->where('quarantined', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scanned_at', today());
    }

    // Accessors
    public function getResultTextAttribute()
    {
        return match($this->scan_result) {
            'clean' => 'Limpio',
            'threat_detected' => 'Amenaza Detectada',
            'suspicious' => 'Sospechoso',
            'error' => 'Error',
            default => 'Desconocido'
        };
    }

    public function getThreatTypeTextAttribute()
    {
        return match($this->threat_type) {
            'virus' => 'Virus',
            'malware' => 'Malware',
            'spam' => 'Spam',
            'phishing' => 'Phishing',
            'suspicious' => 'Sospechoso',
            default => $this->threat_type
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->scan_result) {
            'clean' => 'green',
            'threat_detected' => 'red',
            'suspicious' => 'yellow',
            'error' => 'gray',
            default => 'gray'
        };
    }
}
