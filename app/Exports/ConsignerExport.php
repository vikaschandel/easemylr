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

        $consigner = $query->with('State')->orderby('created_at','DESC')->get();

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

                $arr[] = [
                    'nick_name' => $value->nick_name,
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
            'Consigner Nick Name',
            'Contact Person Name',
            'Mobile No.',
            'PIN Code',
            'City',
            'District',
            'State',
        ];
    }
}
