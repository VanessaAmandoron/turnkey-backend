<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendContactDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_number',
    ];
}
