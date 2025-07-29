<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forwarder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'source_email',
        'destination_email',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relaciones
    public function sourceMailbox()
    {
        return $this->belongsTo(Mailbox::class, 'source_email', 'email');
    }

    public function destinationMailbox()
    {
        return $this->belongsTo(Mailbox::class, 'destination_email', 'email');
    }

    // Accessors
    public function getSourceUsernameAttribute()
    {
        return explode('@', $this->source_email)[0];
    }

    public function getSourceDomainAttribute()
    {
        return explode('@', $this->source_email)[1];
    }

    public function getDestinationUsernameAttribute()
    {
        return explode('@', $this->destination_email)[0];
    }

    public function getDestinationDomainAttribute()
    {
        return explode('@', $this->destination_email)[1];
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
