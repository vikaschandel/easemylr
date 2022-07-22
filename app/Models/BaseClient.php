<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name', 'email', 'phone', 'address', 'status', 'created_at', 'updated_at'
    ];
}
