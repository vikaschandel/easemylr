<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaseClient;
use App\Models\RegionalClient;
use DB;
use URL;
use Helper;
use Hash;
use Crypt;
use Validator;
use Illuminate\Support\Arr;

class ClientController extends Controller
{
    public $prefix;
    public $title;

    public function __construct()
    {
      $this->title =  "Clients";
      $this->segment = \Request::segment(2);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
        $query = BaseClient::query();
        $clients = $query->orderby('id','DESC')->get();
        return view('clients.client-list',['clients'=>$clients,'prefix'=>$this->prefix,'title'=>$this->title])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->prefix = request()->route()->getPrefix();
        $this->pagetitle =  "Create";
        $locations = Helper::getLocations();

        return view('clients.create-client',['locations'=>$locations, 'prefix'=>$this->prefix, 'title'=>$this->title, 'pagetitle'=>$this->pagetitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
        $rules = array(
            'client_name' => 'required',
            // 'name' => 'required',
            // 'login_id' => 'required|unique:users,login_id',
        );

        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails())
        {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }
        if(!empty($request->client_name)){
            $client['client_name']   = $request->client_name;
        }
        $client['status']     = "1";

        $saveclient = BaseClient::create($client); 
        $data = $request->all();

        if($saveclient)
        {
            if(!empty($request->data)){ 
                $get_data = $request->data;
                foreach ($get_data as $key => $save_data ) { 
                    $save_data['baseclient_id'] = $saveclient->id;
                    $save_data['location_id'] = $save_data['location_id'];
                    $save_data['status'] = "1";
                    $saveregclients = RegionalClient::create($save_data);
                }
            }

            
            $url    =   URL::to($this->prefix.'/clients');
            $response['success'] = true;
            $response['success_message'] = "Clients Added successfully";
            $response['error'] = false;
            // $response['resetform'] = true;
            $response['page'] = 'client-create';
            $response['redirect_url'] = $url;
        }else{
            $response['success'] = false;
            $response['error_message'] = "Can not created client please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
