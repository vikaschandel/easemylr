<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Consigner;
use App\Models\State;
use App\Models\Location;

class ConsignerImport implements ToModel,WithHeadingRow
{
	/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $getState = State::where('name',$row['state'])->first();
        $getLocation = Location::where('name',$row['location'])->first();

        if(empty($getLocation)){
            $location = 'N/A';
        }
        else{
            $location = $getLocation->id;
        }
        
        if(empty($getState)){
            $state = 'N/A';
        }
        else{
            $state = $getState->id;
        }

        if(empty($row['status'])){
            $status = '0';
        }
        else{
            $status = $row['status'];
        }

        return new Consigner([
            'nick_name'    => $row['nick_name'],
            'legal_name'   => $row['legal_name'],
            'gst_number'   => $row['gst_number'],
            'contact_name' => $row['contact_name'],
            'phone'        => $row['phone'],
            'branch_id'    => $location,
            'email'        => $row['email'],
            'address'      => $row['address'],
            
            'city'         => $row['city'],
            'district'     => $row['district'],
            'postal_code'  => $row['postal_code'],
            'state_id'     => $state,
            'status'       => $status,
            'created_at'   => time(),
        ]);
    }
}
