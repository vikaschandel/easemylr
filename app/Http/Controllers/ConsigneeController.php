<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consignee;
use App\Models\Branch;
use App\Models\State;
use App\Models\Consigner;
use DB;
use URL;
use Auth;
use Helper;
use Validator;

class ConsigneeController extends Controller
{
    public function __construct()
    {
      $this->title =  "Consignees";
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
        $query = Consignee::query();
        $authuser = Auth::user();
        $cc = explode(',',$authuser->branch_id);
        if($authuser->role_id == 2){
            $consignees = DB::table('consignees')->select('consignees.*', 'consigners.nick_name as consigner_id')
                        ->join('consigners', 'consigners.id', '=', 'consignees.consigner_id')
                        ->get();
         //echo "<pre>"; print_r($consignees); die;
        }else{
            $consignees = $query->orderBy('id','DESC')->with(['Consigner'])->get();
        }
        return view('consignees.consignee-list',['consignees'=>$consignees,'prefix'=>$this->prefix,'title'=>$this->title])
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->prefix = request()->route()->getPrefix();
        // $consigners = Helper::getConsigners();
        $authuser = Auth::user();
        $cc = explode(',',$authuser->branch_id);
        if($authuser->role_id == 2){
            $consigners = Consigner::whereIn('branch_id',$cc)->orderby('nick_name','ASC')->pluck('nick_name','id');
        }else{
            $consigners = Consigner::where('status',1)->orderby('nick_name','ASC')->pluck('nick_name','id');
        }
        $branches = Helper::getLocations();
        $states = Helper::getStates();
        return view('consignees.create-consignee',['consigners'=>$consigners, 'branches'=>$branches, 'states'=>$states, 'prefix'=>$this->prefix, 'title'=>$this->title, 'pagetitle'=>'Create']);
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
        $authuser = Auth::user();
        $rules = array(
            'nick_name' => 'required',
            // 'email' => 'required|unique:consignees',
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
        $consigneesave['nick_name']           = $request->nick_name;
        $consigneesave['legal_name']          = $request->legal_name;
        $consigneesave['gst_number']          = $request->gst_number;
        $consigneesave['contact_name']        = $request->contact_name;
        $consigneesave['phone']               = $request->phone;
        $consigneesave['consigner_id']        = $request->consigner_id;
        $consigneesave['branch_id']           = $request->branch_id;
        $consigneesave['dealer_type']         = $request->dealer_type;
        $consigneesave['email']               = $request->email;
        $consigneesave['sales_officer_name']  = $request->sales_officer_name;
        $consigneesave['sales_officer_email'] = $request->sales_officer_email;
        $consigneesave['sales_officer_phone'] = $request->sales_officer_phone;
        $consigneesave['address_line1']       = $request->address_line1;
        $consigneesave['address_line2']       = $request->address_line2;
        $consigneesave['address_line3']       = $request->address_line3;
        $consigneesave['address_line4']       = $request->address_line4;
        $consigneesave['city']                = $request->city;
        $consigneesave['district']            = $request->district;
        $consigneesave['postal_code']         = $request->postal_code;
        $consigneesave['state_id']            = $request->state_id;
        $consigneesave['user_id']             = $authuser->id;

        $saveconsignee = Consignee::create($consigneesave); 
        if($saveconsignee)
        {
            $response['success'] = true;
            $response['success_message'] = "Consignee Added successfully";
            $response['error'] = false;
            $response['page'] = 'consignee-create'; 
            $response['redirect_url'] = URL::to($this->prefix.'/consignees');
            // $response['resetform'] = true;
        }else{
            $response['success'] = false;
            $response['error_message'] = "Can not created consignee please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consigner  $consigner
     * @return \Illuminate\Http\Response
     */
    public function show($consignee)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($consignee);
        $getconsignee = Consignee::where('id',$id)->with('GetConsigner','GetBranch','GetState')->first();
        return view('consignees.view-consignee',['prefix'=>$this->prefix,'title'=>$this->title,'getconsignee'=>$getconsignee,'pagetitle'=>'View Details']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consigner  $consigner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($id);      
        $states = Helper::getStates();
        $branches = Helper::getLocations();  
        // $consigners = Helper::getConsigners(); 
        $authuser = Auth::user();
        $cc = explode(',',$authuser->branch_id);
        if($authuser->role_id == 2){
            $consigners = Consigner::whereIn('branch_id',$cc)->orderby('nick_name','ASC')->pluck('nick_name','id');
        }else{
            $consigners = Consigner::where('status',1)->orderby('nick_name','ASC')->pluck('nick_name','id');
        }      
        $getconsignee = Consignee::where('id',$id)->first();
        return view('consignees.update-consignee')->with(['prefix'=>$this->prefix, 'getconsignee'=>$getconsignee,'states'=>$states,'branches'=>$branches,'consigners'=>$consigners,'title'=>$this->title,'pagetitle'=>'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consigner  $consigner
     * @return \Illuminate\Http\Response
     */
    public function updateConsignee(Request $request)
    {
        try { 
            $this->prefix = request()->route()->getPrefix();
             $rules = array(
              'nick_name' => 'required',
            //   'email'  => 'required',
            );

            $validator = Validator::make($request->all(),$rules);

            if($validator->fails())
            {
                $errors                  = $validator->errors();
                $response['success']     = false;
                $response['formErrors']  = true;
                $response['errors']      = $errors;
                return response()->json($response);
            }

            $consigneesave['nick_name']           = $request->nick_name;
            $consigneesave['legal_name']          = $request->legal_name;
            $consigneesave['gst_number']          = $request->gst_number;
            $consigneesave['contact_name']        = $request->contact_name;
            $consigneesave['phone']               = $request->phone;
            $consigneesave['consigner_id']        = $request->consigner_id;
            $consigneesave['branch_id']           = $request->branch_id;
            $consigneesave['dealer_type']         = $request->dealer_type;
            $consigneesave['email']               = $request->email;
            $consigneesave['sales_officer_name']  = $request->sales_officer_name;
            $consigneesave['sales_officer_email'] = $request->sales_officer_email;
            $consigneesave['sales_officer_phone'] = $request->sales_officer_phone;
            $consigneesave['address_line1']       = $request->address_line1;
            $consigneesave['address_line2']       = $request->address_line2;
            $consigneesave['address_line3']       = $request->address_line3;
            $consigneesave['address_line4']       = $request->address_line4;
            $consigneesave['city']                = $request->city;
            $consigneesave['district']            = $request->district;
            $consigneesave['postal_code']         = $request->postal_code;
            $consigneesave['state_id']            = $request->state_id;
            // $consigneesave['status']              = $request->status;
            
            Consignee::where('id',$request->consignee_id)->update($consigneesave);
            $url    =   URL::to($this->prefix.'/consignees');

            $response['page'] = 'consignee-update';
            $response['success'] = true;
            $response['success_message'] = "Consignee Updated Successfully";
            $response['error'] = false;
            // $response['html'] = $html;
            $response['redirect_url'] = $url;
        }catch(Exception $e) {
            $response['error'] = false;
            $response['error_message'] = $e;
            $response['success'] = false;
            $response['redirect_url'] = $url;   
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consigner  $consigner
     * @return \Illuminate\Http\Response
     */
    public function deleteConsignee(Request $request)
    {
        Consignee::where('id',$request->consigneeid)->delete();

        $response['success']         = true;
        $response['success_message'] = 'Consignee deleted successfully';
        $response['error']           = false;
        return response()->json($response);
    }
}
