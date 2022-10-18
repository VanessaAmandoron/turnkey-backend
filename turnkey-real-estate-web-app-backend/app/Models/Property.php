<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PropertyImage;

class Property extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'price',
        'type',
        'area',
        'bedroom',
        'bathroom',
        'description',
        'address_1',
        'address_2',
        'zip_code',
        'city',
        // 'propert_imgs',
        'availability'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function image(){
        return $this->hasMany(PropertyImage::class);
    }
}
