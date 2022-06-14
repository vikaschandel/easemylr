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

class ConsigneeImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // dd($row);

        $getState = State::where('name',$row['state'])->first();
        $getLocation = Location::where('name',$row['location'])->first();
        $getConsigner = Consigner::where('nick_name',$row['consigner'])->first();

        if(empty($getConsigner)){
            $consigner = 'N/A';
        }
        else{
            $consigner = $getConsigner->id;
        }

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

        return new Consignee([
            'nick_name'         => $row['nick_name'],
            'legal_name'        => $row['legal_name'],
            'branch_id'         => $location,
            'consigner_id'      => $consigner,
            'dealer_type'       => $row['dealer_type'],
            'gst_number'        => $row['gst_number'],
            'contact_name'      => $row['contact_name'],
            'phone'             => $row['phone'],
            'email'             => $row['email'],
            'sales_officer_name' => $row['sales_officer_name'],
            'sales_officer_email' => $row['sales_officer_email'],
            'sales_officer_phone' => $row['sales_officer_phone'],
            'address_line1'     => $row['address_line1'],
            'address_line2'     => $row['address_line2'],
            'address_line3'     => $row['address_line3'],
            'city'              => $row['city'],
            'district'          => $row['district'],
            'postal_code'       => $row['postal_code'],
            'state_id'          => $state,
            'status'            => "1",
            'created_at'        => time(),

        ]);
    }
}
