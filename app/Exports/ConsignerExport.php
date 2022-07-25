<?php

namespace App\Exports;

use App\Models\Consigner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Session;
use Helper;

class ConsignerExport implements FromCollection, WithHeadings,ShouldQueue
{
    /**
    * @return \Illuminate\Support\Collection
    */   
    public function collection()
    {
        ini_set('memory_limit', '2048M');
        set_time_limit ( 6000 );
        $arr = array();
        $query = Consigner::query();

        $consigner = $query->with('State','RegClient')->orderby('created_at','DESC')->get();

        if($consigner->count() > 0){
            foreach ($consigner as $key => $value){  
                if(!empty($value->State)){
                    if(!empty($value->State->name)){
                      $state = $value->State->name;
                    }else{
                      $state = '';
                    }
                }else{
                    $state = '';
                }
                if(!empty($value->RegClient)){
                    if(!empty($value->RegClient->name)){
                      $RegClient = $value->RegClient->name;
                    }else{
                      $regClient = '';
                    }
                }else{
                    $regClient = '';
                }

                $arr[] = [
                    'id' => $value->id,
                    'nick_name' => $value->nick_name,
                    'legal_name' => $value->legal_name,
                    'gst_number' => $value->gst_number,
                    'contact_name' => $value->contact_name,
                    'phone' => $value->phone,
                    'regionalclient_id' => $regClient,
                    'email' => $value->email,
                    'address_line1' => $value->address_line1,
                    'address_line2' => $value->address_line2,
                    'address_line3' => $value->address_line3,
                    'address_line4' => $value->address_line4,
                    'postal_code' => $value->postal_code,
                    'city' => $value->city,
                    'district' => $value->district,
                    'postal_code' => $value->postal_code,
                    'state_id' => $state,
                ];
            }
        }                 
        return collect($arr);
    }
    public function headings(): array
    {
        return [
            'id',
            'Consigner Nick Name',
            'Consigner Legal Name',
            'GST Number',            
            'Contact Person Name',
            'Mobile No.',
            'Regional Client Name',
            'Email',
            'Address Line1',
            'Address Line2',
            'Address Line3',
            'Address Line4',
            'PIN Code',
            'City',
            'District',
            'State',
        ];
    }
}
