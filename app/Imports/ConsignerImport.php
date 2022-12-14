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
        $getState = State::where('name',$row['state'])->first();
        $getLocation = Location::where('name',$row['location'])->first();

        if(!empty($getLocation)){
            $location = $getLocation->id;
        }
        else{
            $location = 'N/A';
        }
        
        if(!empty($getState)){
            $state = $getState->id;
        }
        else{
            $state = 'N/A';
        }

        $consigner = Consigner::where('nick_name', $row['nick_name'])->where('branch_id', $location)->first();
        if(empty($consigner)){
            
            return new Consigner([
                'nick_name'    => $row['nick_name'],
                'legal_name'   => $row['legal_name'],
                'gst_number'   => $row['gst_number'],
                'contact_name' => $row['contact_name'],
                'phone'        => (float)$row['phone'],
                'branch_id'    => $location,
                'email'        => $row['email'],
                'address_line1'=> $row['address_line1'],
                'address_line2'=> $row['address_line2'],
                'address_line3'=> $row['address_line3'],
                'address_line4'=> $row['address_line4'], 
                'city'         => $row['city'],
                'district'     => $row['district'],
                'postal_code'  => $row['postal_code'],
                'state_id'     => $state,
                'status'       => 1,
                'created_at'   => time(),
            ]);
        }
    }
}
