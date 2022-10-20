<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Property;
class ImageProperty extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'filename'
    ];


    public function user(){
        return $this->belongsTo(Property::class);
    }
}
