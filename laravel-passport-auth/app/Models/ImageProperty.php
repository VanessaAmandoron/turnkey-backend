<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class ImageProperty extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'name',
    ];

    public function property(){
        return $this->belongsTo(Property::class);
    }
}
