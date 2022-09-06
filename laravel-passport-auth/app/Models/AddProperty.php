<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddProperty extends Model
{
    use HasFactory;
     protected $fillable = ['p_title', 
     'price',
     'p_type',
     'area',
     'bedroom',
     'bathroom',
     'p_info',
     'loc_a',
     'loc_b',
     'area',
     'z_code',
     'city',
     'p_img'
    ];
}
