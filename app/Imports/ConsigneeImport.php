<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Consignee;
use App\Models\Consigner;
use App\Models\Location;
use App\Models\State;
use App\Models\User;
use Auth;

class ConsigneeImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $getState = State::where('name',$row['state'])->first();
        //$getLocation = Location::where('name',$row['location'])->first();
        $getConsigner = Consigner::where('nick_name',$row['consigner'])->first();
        //$getUser   = User::where('name',$row['user'])->first();
        $getuser = Auth::user();


        // if(empty($getUser)){
        //     $user_name = '';
        // }else{
        //     $user_name = $getUser->id;
        // }

        if(empty($getConsigner)){
            $consigner = '';
        }
        else{
            $consigner = $getConsigner->id;
        }

        // if(empty($getLocation)){
        //     $location = '';
        // }
        // else{
        //     $location = $getLocation->id;
        // }

        if(empty($getState)){
            $state = '';
        }
        else{
            $state = $getState->id;
        }

        if($row['dealer_type'] == 'Registered'){
            $dealer_type = 1;
        }
        else{
            $dealer_type = 0;
        }

        return new Consignee([
            'nick_name'         => $row['nick_name'],
            'legal_name'        => $row['legal_name'],
            'user_id'           => $getuser->id,
            'consigner_id'      => $consigner,
            'dealer_type'       => $dealer_type,
            'gst_number'        => $row['gst_number'],
            'contact_name'      => $row['contact_name'],
            'phone'             => $row['phone'],
            'email'             => $row['email'],
            'address_line1'     => $row['address_line1'],
            'address_line2'     => $row['address_line2'],
            'address_line3'     => $row['address_line3'],
            'address_line4'     => $row['address_line4'],
            'city'              => $row['city'],
            'district'          => $row['district'],
            'postal_code'       => $row['postal_code'],
            'state_id'          => $state,
            'status'            => "1",
            'created_at'        => time(),

        ]);
    }
}
