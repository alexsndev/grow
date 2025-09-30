<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'demand_id', 'path', 'original_name', 'mime_type', 'size'
    ];

    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/'.$this->path);
    }
}
