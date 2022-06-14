<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ConsigneeImport;
use App\Imports\VehiclesImport;
use App\Imports\ConsignerImport;
use Maatwebsite\Excel\Facades\Excel;
use URL;

class ImportCsvController extends Controller
{
    public $prefix;
    public function getBulkImport()
    {
        $this->prefix = request()->route()->getPrefix();
        return view('uploadcsv',['prefix'=>$this->prefix]);
    }

    public function uploadCsv(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
        if($request->hasFile('consigneesfile')){
            $data = Excel::import(new ConsigneeImport,request()->file('consigneesfile'));
            $url  =   URL::to($this->prefix.'/consignees');
        }
        if($request->hasFile('vehiclesfile')){
            $data = Excel::import(new VehiclesImport,request()->file('vehiclesfile'));
            $url  =   URL::to($this->prefix.'/vehicles');
        }
        if($request->hasFile('consignersfile')){
            $data = Excel::import(new ConsignerImport,request()->file('consignersfile'));
            $url  =   URL::to($this->prefix.'/consigners');
        }
        if($request->hasFile('driversfile')){
            $data = Excel::import(new DriverImport,request()->file('driversfile'));
            $url  =   URL::to($this->prefix.'/drivers');
        }
        if($data){            
            $response['success']    = true;
            $response['page']       = 'bulk-imports';
            $response['error']      = false;
            $response['success_message'] = "Consignees import successfully";
            $response['redirect_url'] = $url;
        }else{
            $response['success']       = false;
            $response['error']         = true;
            $response['error_message'] = "Can not import consignees please try again";
        }
        return response()->json($response);
    }

}
