<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSheet extends Model
{
    use HasFactory;
    protected $table = 'transaction_sheets';
    protected $fillable = [
        'consignment_id','consignee_id','consignment_no','consignment_date','city','pincode','total_quantity', 'total_weight','order_no','vehicle_no', 'driver_name','driver_no','status','drs_no','branch_id','created_at','updated_at'
    ];

    public function ConsignmentDetail()
    {
        return $this->hasOne('App\Models\ConsignmentNote','id','consignment_no');
    }

    public function consigneeDetail()
    {
        return $this->hasOne('App\Models\Consignee','nick_name','consignee_id');
    }
}
