<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSheet extends Model
{
    use HasFactory;
    protected $table = 'transaction_sheets';
    protected $fillable = [
        'consignment_id','transaction_details', 'vehicle_no', 'driver_name','driver_no','status',
    ];

    public function ConsignmentDetail()
    {
        return $this->hasOne('App\Models\ConsignmentNote','id','consignment_id');
    }
}
