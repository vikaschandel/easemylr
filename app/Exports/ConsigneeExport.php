<?php

namespace App\Exports;

use App\Models\Consignee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Session;
use Helper;

class ConsigneeExport implements FromCollection, WithHeadings,ShouldQueue
{
    /**
    * @return \Illuminate\Support\Collection
    */   
    public function collection()
    {
        ini_set('memory_limit', '2048M');
        set_time_limit ( 6000 );
        $arr = array();
        $query = Consignee::query();

        $consignee = $query->with('Consigner','State')->orderby('created_at','DESC')->get();

        if($consignee->count() > 0){
            foreach ($consignee as $key => $value){  
                if(!empty($value->State)){
                    if(!empty($value->State->name)){
                      $state = $value->State->name;
                    }else{
                      $state = '';
                    }
                }else{
                    $state = '';
                }

                if(!empty($value->Consigner)){
                    if(!empty($value->Consigner->nick_name)){
                      $consigner = $value->Consigner->nick_name;
                    }else{
                      $consigner = '';
                    }
                }else{
                    $consigner = '';
                }

                $arr[] = [
                    'nick_name' => $value->nick_name,
                    'consigner_id' => $consigner,
                    'contact_name' => $value->contact_name,
                    'phone' => $value->phone,
                    'postal_code' => $value->postal_code,
                    'city' => $value->city,
                    'district' => $value->district,
                    'state_id' => $state,
                ];
            }
        }                 
        return collect($arr);
    }
    public function headings(): array
    {
        return [
            'Consignee Nick Name',
            'Consigner',
            'Contact Person Name',
            'Mobile No.',
            'PIN Code',
            'City',
            'District',
            'State',
        ];
    }
}
