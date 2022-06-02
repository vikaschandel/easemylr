<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignmentItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'consignment_id',
        'description',
        'packing_type',
        'quantity',
        'weight',
        'gross_weight',
        'freight',
        'payment_type',
        'status',
        'created_at',
        'updated_at'
    ];
}
