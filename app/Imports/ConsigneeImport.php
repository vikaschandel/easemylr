<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Consignee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConsigneeImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        

        return new Consignee([
            'nick_name'    => $row['nick_name'],
            'consigner_id' => $row['consigner'], 
            'contact_name' => $row['contact_name'],
            'phone'        => $row['mobile'],
            'email'        => $row['email'],
            'district'     => $row['district'],

        ]);
    }
}
