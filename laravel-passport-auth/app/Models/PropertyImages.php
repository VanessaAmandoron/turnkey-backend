<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImages extends Model
{
    use HasFactory;
    protected $fillable = [
        'img',
        
    ];

    protected $table = 'property_images';
    
    public function properties()
        {
            return $this->belongsTo(Property::class);
        }
}

