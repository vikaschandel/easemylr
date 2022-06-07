<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ConsigneeImport;
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
        $data = Excel::import(new ConsigneeImport,request()->file('consigneesfile'));
        if($data){
            $url    =   URL::to($this->prefix.'/consignees');
            $response['success']    = true;
            $response['page']       = 'import-consignees';
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
