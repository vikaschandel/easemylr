<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'baseclient_id', 'location_id', 'name', 'email', 'phone', 'address', 'status', 'created_at', 'updated_at'
    ];
}