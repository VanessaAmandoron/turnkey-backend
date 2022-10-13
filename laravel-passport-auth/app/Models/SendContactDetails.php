<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SendContactDetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_number',
    ];
}
