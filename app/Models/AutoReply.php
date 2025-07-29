<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mailbox_id',
        'subject',
        'message',
        'active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relaciones
    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class);
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

    public function scopeCurrent($query)
    {
        $now = now();
        return $query->where('active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $now);
            });
    }

    // Accessors
    public function getIsCurrentlyActiveAttribute()
    {
        if (!$this->active) {
            return false;
        }

        $now = now();
        
        $startValid = !$this->start_date || $this->start_date <= $now;
        $endValid = !$this->end_date || $this->end_date >= $now;
        
        return $startValid && $endValid;
    }
}
