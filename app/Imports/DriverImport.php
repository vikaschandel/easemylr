<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Driver;

class DriverImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Driver([
            'name'           => $row['name'],
            'phone'          => (float)$row['phone'],
            'license_number' => $row['license_number'],
            'license_image'  => $row['license_image'],
            'status'         => "1",
            'created_at'     => time(),

        ]);

        // return new Bank([
        //     'broker_id'      => $row['broker_id'],
        //     'bank_name'      => $row['bank_name'],
        //     'branch_name'    => $row['branch_name'],
        //     'ifsc'           => $row['ifsc'],
        //     'account_number' => $row['account_number'],
        //     'account_holdername' => $row['account_holdername'],
        //     'status'         => "1",
        //     'created_at'     => time(),
        // ]);

    }
}
