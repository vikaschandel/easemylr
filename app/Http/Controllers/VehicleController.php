<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Driver;
use DB;
use URL;
use Helper;
use Hash;
use Crypt;
use Validator;
use DataTables;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
        if ($request->ajax()) {
            $data = Vehicle::orderby('id','DESC')->get();
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('regn_date', function($row)
            {
                return Helper::ShowFormatDate($row->regn_date); // show date in dd-mm-yyyy format
            })
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.URL::to($this->prefix.'/vehicles/'.Crypt::encrypt($row->id).'/edit').'" class="edit btn btn-primary btn-sm">Edit</a>';
                $actionBtn .= '&nbsp;&nbsp;';
                $actionBtn .= '<a href="'.URL::to($this->prefix.'/vehicles/'.Crypt::encrypt($row->id).'').'" class="view btn btn-info btn-sm">View</a>';
                $actionBtn .= '&nbsp;&nbsp;';
                $actionBtn .= '<button type="button" name="delete" data-id="'.$row->id.'" data-action="'.URL::to($this->prefix.'/vehicles/delete-vehicle').'" class="delete btn btn-danger btn-sm delete_vehicle">Delete</button>';
                return $actionBtn;
            })
          ->rawColumns(['action'])
                ->make(true);
        }

        return view('vehicles.vehicle-list',['prefix'=>$this->prefix]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->prefix = request()->route()->getPrefix();
        $vehicles = Vehicle::all();
        $states = Helper::getStates();
        return view('vehicles.create-vehicle',['vehicles'=>$vehicles,'states'=>$states,'prefix'=>$this->prefix]);
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
            'regn_no' => 'required|unique:vehicles',
            'mfg' => 'required',
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

        $vehiclesave['regn_no']        = $request->regn_no;
        $vehiclesave['mfg']            = $request->mfg;
        $vehiclesave['make']           = $request->make;
        $vehiclesave['engine_no']      = $request->engine_no;
        $vehiclesave['chassis_no']     = $request->chassis_no;
        $vehiclesave['gross_vehicle_weight'] = $request->gross_vehicle_weight;
        $vehiclesave['unladen_weight'] = $request->unladen_weight;
        $vehiclesave['body_type']      = $request->body_type;
        $vehiclesave['state_id']       = $request->state_id;
        $vehiclesave['regndate']       = $request->regndate;
        $vehiclesave['hypothecation']  = $request->hypothecation;
        $vehiclesave['ownership']      = $request->ownership;
        $vehiclesave['status']         = '1';
        
        $savevehicle = Vehicle::create($vehiclesave); 
        if($savevehicle)
        {
            $response['success']         = true;
            $response['success_message'] = "Vehicle Added successfully";
            $response['error']           = false;
            // $response['resetform']       = true;
            $response['page']            = 'vehicle-create';
            $response['redirect_url']    = URL::to('/'.$this->prefix.'/vehicles');
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not created vehicle please try again";
            $response['error']           = true;
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($vehicle)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($vehicle);
        $getvehicle = Vehicle::where('id',$id)->first();
        return view('vehicles.view-vehicle',['prefix'=>$this->prefix,'getvehicle'=>$getvehicle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($id);
        $states = Helper::getStates();
        $getvehicle = Vehicle::where('id',$id)->first();
        return view('vehicles.update-vehicle')->with(['prefix'=>$this->prefix,'getvehicle'=>$getvehicle,'states'=>$states]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateVehicle(Request $request)
    {
        try { 
            $this->prefix = request()->route()->getPrefix();
             $rules = array(
                'regn_no' => 'required|unique:vehicles,regn_no,' . $request->vehicle_id,
                'mfg' => 'required',
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

            $vehiclesave['regn_no']        = $request->regn_no;
            $vehiclesave['mfg']            = $request->mfg;
            $vehiclesave['make']           = $request->make;
            $vehiclesave['engine_no']      = $request->engine_no;
            $vehiclesave['chassis_no']     = $request->chassis_no;
            $vehiclesave['gross_vehicle_weight'] = $request->gross_vehicle_weight;
            $vehiclesave['unladen_weight'] = $request->unladen_weight;
            $vehiclesave['body_type']      = $request->body_type;
            $vehiclesave['state_id']       = $request->state_id;
            $vehiclesave['regndate']       = $request->regndate;
            $vehiclesave['hypothecation']  = $request->hypothecation;
            $vehiclesave['ownership']      = $request->ownership;
            $vehiclesave['status']         = '1';
            
            Vehicle::where('id',$request->vehicle_id)->update($vehiclesave);
            
            $response['success'] = true;
            $response['error'] = false;
            $response['page'] = 'vehicle-update';
            $response['success_message'] = "Vehicle Updated Successfully";
            $response['redirect_url'] = URL::to($this->prefix.'/vehicles');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteVehicle(Request $request)
    {
        Vehicle::where('id',$request->vehicleid)->delete();

        $response['success']         = true;
        $response['success_message'] = 'Vehicle deleted successfully';
        $response['error']           = false;
        return response()->json($response);
    }

    // not use yet
    public function getDrivers(Request $request){
        $getdrivers = Driver::select('name','phone','license_number')->where(['id'=>$request->driver_id,'status'=>'1'] )->first();
        if($getdrivers)
        {
            $response['success']         = true;
            $response['success_message'] = "Driver list fetch successfully";
            $response['error']           = false;
            $response['data']            = $getdrivers;
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not fetch driver list please try again";
            $response['error']           = true;
        }
    	return response()->json($response);
    }
}
