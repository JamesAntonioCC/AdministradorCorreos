<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailAlias extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'alias_email',
        'mailbox_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relaciones
    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class);
    }

    // Accessors
    public function getAliasUsernameAttribute()
    {
        return explode('@', $this->alias_email)[0];
    }

    public function getAliasDomainAttribute()
    {
        return explode('@', $this->alias_email)[1];
    }

    public function getForwardsToAttribute()
    {
        return $this->mailbox->email;
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
