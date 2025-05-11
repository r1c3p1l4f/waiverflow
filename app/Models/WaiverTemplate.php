<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaiverTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'content', 
        'is_active', 
        'version'
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function signedWaivers()
    {
        return $this->hasMany(SignedWaiver::class);
    }
}
