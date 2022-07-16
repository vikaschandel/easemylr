<?php

namespace App\Http\Controllers;

use App\Models\BranchAddress;
use App\Models\Consignee;
use App\Models\Consigner;
use App\Models\ConsignmentItem;
use App\Models\ConsignmentNote;
use App\Models\Driver;
use App\Models\Location;
use App\Models\TransactionSheet;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Auth;
use DB;
use Illuminate\Http\Request;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use QrCode;
use Storage;
use Validator;

class ConsignmentController extends Controller
{

    public function __construct()
    {
        $this->title = "Consignments";
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
        // $peritem = 20;
        $query = ConsignmentNote::query();
        $authuser = Auth::user();
        $cc = explode(',', $authuser->branch_id);
        if ($authuser->role_id == 2) {
            $consignments = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_id', 'consignees.nick_name as consignee_id', 'consignees.city as city', 'consignees.postal_code as pincode')
                ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
                ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            // ->join('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
            // ->join('drivers', 'drivers.id', '=', 'consignment_notes.driver_id')
                ->whereIn('consignment_notes.branch_id', $cc)
                ->get(['consignees.city']);

            // $consignments = $query->whereIn('branch_id',$cc)->orderby('id','DESC')->get();
        } else {
            $consignments = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_id', 'consignees.nick_name as consignee_id', 'consignees.city as city', 'consignees.postal_code as pincode')
                ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
                ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            // ->join('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
            // ->join('drivers', 'drivers.id', '=', 'consignment_notes.driver_id')
                ->get(['consignees.city']);

            // $consignments = $query->orderby('id','DESC')->get();
        }
        if ($request->ajax()) {
            if (isset($request->updatestatus)) {
                ConsignmentNote::where('id', $request->id)->update(['status' => $request->status, 'reason_to_cancel' => $request->reason_to_cancel]);
                ConsignmentItem::where('consignment_id', $request->id)->update(['status' => $request->status]);
            }

            $url = $this->prefix . '/consignments';
            $response['success'] = true;
            $response['success_message'] = "Consignment updated successfully";
            $response['error'] = false;
            $response['page'] = 'consignment-updateupdate';
            $response['redirect_url'] = $url;

            return response()->json($response);
        }
        return view('consignments.consignment-list', ['consignments' => $consignments, 'prefix' => $this->prefix, 'title' => $this->title])
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function consignment_list(){
        
        
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->prefix = request()->route()->getPrefix();
        $authuser = Auth::user();
        $cc = explode(',', $authuser->branch_id);

        $location_vehcleno = Location::whereIn('id', $cc)->first();
        if ($location_vehcleno) {
            $with_vehicle_no = $location_vehcleno->with_vehicle_no;
        } else {
            $with_vehicle_no = 0;
        }
        if ($authuser->role_id == 2) {
            $consigners = Consigner::select('id', 'nick_name')->whereIn('branch_id', $cc)->get();
            $consignees = Consignee::select('id', 'nick_name')->where('user_id', $authuser->id)->get();
            // $consignees = Consignee::select('id','nick_name')->whereIn('branch_id',$cc)->get();
            $getconsignment = Location::select('id', 'name', 'consignment_no')->whereIn('id', $cc)->latest('id')->first();
            if (!empty($getconsignment->consignment_no)) {
                $con_series = $getconsignment->consignment_no;
            } else {
                $con_series = '';
            }
            // $con_series = $getconsignment->consignment_no;
            $cn = ConsignmentNote::select('id', 'consignment_no', 'branch_id')->whereIn('branch_id', $cc)->latest('id')->first();
            if ($cn) {
                if (!empty($cn->consignment_no)) {
                    $cc = explode('-', $cn->consignment_no);
                    $getconsignmentno = @$cc[1] + 1;
                    $consignmentno = $cc[0] . '-' . $getconsignmentno;
                } else {
                    $consignmentno = $con_series . '-1';
                }
            } else {
                $consignmentno = $con_series . '-1';
            }
        }

        // $cc = explode('-',$cn->consignment_no);
        // $getconsignmentno = $cc[1] + 1;
        // $consignmentno = $cc[0].'-'.$getconsignmentno;
        else {
            $consigners = Consigner::select('id', 'nick_name')->get();
            $consignees = Consignee::select('id', 'nick_name')->get();
            $consignmentno = "";
        }

        $locations = Location::where('status', '1')->select('id', 'consignment_no')->get();
        $vehicles = Vehicle::where('status', '1')->select('id', 'regn_no')->get();
        $drivers = Driver::where('status', '1')->select('id', 'name', 'phone')->get();
        $vehicletypes = VehicleType::where('status', '1')->select('id', 'name')->get();

        return view('consignments.create-consignment', ['prefix' => $this->prefix, 'consigners' => $consigners, 'consignees' => $consignees, 'locations' => $locations, 'vehicles' => $vehicles, 'vehicletypes' => $vehicletypes, 'consignmentno' => $consignmentno, 'drivers' => $drivers, 'with_vehicle_no' => $with_vehicle_no]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->prefix = request()->route()->getPrefix();
            $rules = array(
                'consigner_id' => 'required',
                'consignee_id' => 'required',
                'ship_to_id' => 'required',
                'invoice_no' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $response['success'] = false;
                $response['validation'] = false;
                $response['formErrors'] = true;
                $response['errors'] = $errors;
                return response()->json($response);
            }
            $authuser = Auth::user();
            $cc = explode(',', $authuser->branch_id);

            $location_vehcleno = Location::whereIn('id', $cc)->first();
            if ($location_vehcleno) {
                $with_vehicle_no = $location_vehcleno->with_vehicle_no;
            } else {
                $with_vehicle_no = 0;
            }

            if (empty($request->vehicle_id || $request->req_vehicle_id)) {
                $status = '2';
            } else {
                $status = '1';
            }


            $getconsignment = Location::select('id', 'name', 'consignment_no')->whereIn('id', $cc)->latest('id')->first();
            if (!empty($getconsignment->consignment_no)) {
                $con_series = $getconsignment->consignment_no;
            } else {
                $con_series = '';
            }
            // $con_series = $getconsignment->consignment_no;
            $cn = ConsignmentNote::select('id', 'consignment_no', 'branch_id')->whereIn('branch_id', $cc)->latest('id')->first();
            if ($cn) {
                if (!empty($cn->consignment_no)) {
                    $cc = explode('-', $cn->consignment_no);
                    $getconsignmentno = @$cc[1] + 1;
                    $consignmentno = $cc[0] . '-' . $getconsignmentno;
                } else {
                    $consignmentno = $con_series . '-1';
                }
            } else {
                $consignmentno = $con_series . '-1';
            }

            $consignmentsave['consigner_id'] = $request->consigner_id;
            $consignmentsave['consignee_id'] = $request->consignee_id;
            $consignmentsave['ship_to_id'] = $request->ship_to_id;
            $consignmentsave['consignment_date'] = $request->consignment_date;
            $consignmentsave['consignment_no'] = $consignmentno;
            $consignmentsave['dispatch'] = $request->dispatch;
            $consignmentsave['invoice_no'] = $request->invoice_no;
            $consignmentsave['invoice_date'] = $request->invoice_date;
            $consignmentsave['invoice_amount'] = $request->invoice_amount;
            $consignmentsave['total_quantity'] = $request->total_quantity;
            $consignmentsave['total_weight'] = $request->total_weight;
            $consignmentsave['total_gross_weight'] = $request->total_gross_weight;
            $consignmentsave['total_freight'] = $request->total_freight;
            // $consignmentsave['transporter_name']  = $request->transporter_name;
            // $consignmentsave['vehicle_type']      = $request->vehicle_type;
            $consignmentsave['purchase_price'] = $request->purchase_price;
            $consignmentsave['user_id'] = $authuser->id;
            // $consignmentsave['vehicle_id']        = $request->vehicle_id;
            $consignmentsave['driver_id'] = $request->driver_id;
            $consignmentsave['branch_id'] = $authuser->branch_id;
            $consignmentsave['order_id'] = $request->order_id;
            $consignmentsave['status'] = $status;
            $consignmentsave['delivery_status'] = 1;

            if ($with_vehicle_no == '1') {
                $consignmentsave['vehicle_id'] = $request->req_vehicle_id;
                $consignmentsave['transporter_name'] = $request->req_transporter_name;
                $consignmentsave['vehicle_type'] = $request->req_vehicle_type;
            } else {
                $consignmentsave['vehicle_id'] = $request->vehicle_id;
                $consignmentsave['transporter_name'] = $request->transporter_name;
                $consignmentsave['vehicle_type'] = $request->vehicle_type;
            }

            $saveconsignment = ConsignmentNote::create($consignmentsave);

            if ($saveconsignment) {
                // $consignment_no = str_pad($saveconsignment->id,8,"0", STR_PAD_LEFT);
                // ConsignmentNote::where('id',$saveconsignment->id)->update(['consignment_no'=>$consignment_no]);

                // insert consignment items
                if (!empty($request->data)) {
                    $get_data = $request->data;
                    foreach ($get_data as $key => $save_data) {
                        $save_data['consignment_id'] = $saveconsignment->id;
                        $save_data['status'] = 1;
                        $saveconsignmentitems = ConsignmentItem::create($save_data);
                    }
                }
                $url = $this->prefix . '/consignments';
                $response['success'] = true;
                $response['success_message'] = "Consignment Added successfully";
                $response['error'] = false;
                // $response['resetform'] = true;
                $response['page'] = 'create-consignment';
                $response['redirect_url'] = $url;
            } else {
                $response['success'] = false;
                $response['error_message'] = "Can not created consignment please try again";
                $response['error'] = true;
            }
            DB::commit();
        } catch (Exception $e) {
            $response['error'] = false;
            $response['error_message'] = $e;
            $response['success'] = false;
            $response['redirect_url'] = $url;
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($consignment)
    {
        $this->prefix = request()->route()->getPrefix();
        $query = ConsignmentNote::query();
        $authuser = Auth::user();
        $cc = explode(',', $authuser->branch_id);
        if ($authuser->role_id == 2) {
            $getconsignment = $query->whereIn('branch_id', $cc)->orderby('id', 'DESC')->get();
        } else {
            $getconsignment = $query->orderby('id', 'DESC')->get();
        }
        $branch_add = BranchAddress::first();
        $locations = Location::whereIn('id', $cc)->first();
        return view('consignments.view-consignment', ['prefix' => $this->prefix, 'getconsignment' => $getconsignment, 'branch_add' => $branch_add, 'locations' => $locations]);
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

    // get consigner address on change
    public function getConsigners(Request $request)
    {
        $getconsigners = Consigner::select('address_line1', 'address_line2', 'address_line3', 'address_line4', 'gst_number', 'phone', 'city', 'branch_id')->with('GetBranch')->where(['id' => $request->consigner_id, 'status' => '1'])->first();

        $getConsignees = Consignee::select('id', 'nick_name')->where(['consigner_id' => $request->consigner_id])->get();
        if ($getconsigners) {
            $response['success'] = true;
            $response['success_message'] = "Consigner list fetch successfully";
            $response['error'] = false;
            $response['data'] = $getconsigners;
            $response['consignee'] = $getConsignees;
        } else {
            $response['success'] = false;
            $response['error_message'] = "Can not fetch consigner list please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

    // get consigner address on change
    public function getConsignees(Request $request)
    {
        $getconsignees = Consignee::select('address_line1', 'address_line2', 'address_line3', 'address_line4', 'gst_number', 'phone')->where(['id' => $request->consignee_id, 'status' => '1'])->first();

        if ($getconsignees) {
            $response['success'] = true;
            $response['success_message'] = "Consignee list fetch successfully";
            $response['error'] = false;
            $response['data'] = $getconsignees;
        } else {
            $response['success'] = false;
            $response['error_message'] = "Can not fetch consignee list please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

    // getConsigndetails
    public function getConsigndetails(Request $request)
    {
        $cn_id = $request->id;
        $cn_details = ConsignmentNote::where('id', $cn_id)->with('ConsignmentItems', 'ConsignerDetail', 'ConsigneeDetail', 'ShiptoDetail', 'VehicleDetail', 'DriverDetail')->first();
        if ($cn_details) {
            $response['success'] = true;
            $response['success_message'] = "Consignment details fetch successfully";
            $response['error'] = false;
            $response['data'] = $cn_details;
        } else {
            $response['success'] = false;
            $response['error_message'] = "Can not fetch consignment details please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

    public function consignPrintview(Request $request)
    {
        $query = ConsignmentNote::query();
        $authuser = Auth::user();
        $cc = explode(',', $authuser->branch_id);
        $branch_add = BranchAddress::first();
        $locations = Location::whereIn('id', $cc)->first();

        $cn_id = $request->id;
        $getdata = ConsignmentNote::where('id', $cn_id)->with('ConsignmentItems', 'ConsignerDetail', 'ConsigneeDetail', 'ShiptoDetail', 'VehicleDetail', 'DriverDetail')->first();
        $data = json_decode(json_encode($getdata), true);

        if ($data['consigner_detail']['nick_name'] != null) {
            $nick_name = '<p><b>' . $data['consigner_detail']['nick_name'] . '</b></p>';
        } else {
            $nick_name = '';
        }
        if ($data['consigner_detail']['address_line1'] != null) {
            $address_line1 = '<p>' . $data['consigner_detail']['address_line1'] . '</p>';
        } else {
            $address_line1 = '';
        }
        if ($data['consigner_detail']['address_line2'] != null) {
            $address_line2 = '<p>' . $data['consigner_detail']['address_line2'] . '</p>';
        } else {
            $address_line2 = '';
        }
        if ($data['consigner_detail']['address_line3'] != null) {
            $address_line3 = '<p>' . $data['consigner_detail']['address_line3'] . '</p>';
        } else {
            $address_line3 = '';
        }
        if ($data['consigner_detail']['address_line4'] != null) {
            $address_line4 = '<p>' . $data['consigner_detail']['address_line4'] . '</p>';
        } else {
            $address_line4 = '';
        }
        if ($data['consigner_detail']['district'] != null) {
            $district = '<p>' . $data['consigner_detail']['district'] . '</p>';
        } else {
            $district = '';
        }
        if ($data['consigner_detail']['gst_number'] != null) {
            $gst_number = '<p>GST No: ' . $data['consigner_detail']['gst_number'] . '</p>';
        } else {
            $gst_number = '';
        }
        if ($data['consigner_detail']['phone'] != null) {
            $phone = '<p>Phone No: ' . $data['consigner_detail']['phone'] . '</p>';
        } else {
            $phone = '';
        }

        $conr_add = '<p>' . 'CONSIGNOR NAME & ADDRESS' . '</p>
            ' . $nick_name . ' ' . $address_line1 . ' ' . $address_line2 . ' ' . $address_line3 . ' ' . $address_line4 . '
            ' . $district . ' ' . $gst_number . ' ' . $phone;

        if ($data['consignee_detail']['nick_name'] != null) {
            $nick_name = '<p><b>' . $data['consignee_detail']['nick_name'] . '</b></p>';
        } else {
            $nick_name = '';
        }
        if ($data['consignee_detail']['address_line1'] != null) {
            $address_line1 = '<p>' . $data['consignee_detail']['address_line1'] . '</p>';
        } else {
            $address_line1 = '';
        }
        if ($data['consignee_detail']['address_line2'] != null) {
            $address_line2 = '<p>' . $data['consignee_detail']['address_line2'] . '</p>';
        } else {
            $address_line2 = '';
        }
        if ($data['consignee_detail']['address_line3'] != null) {
            $address_line3 = '<p>' . $data['consignee_detail']['address_line3'] . '</p>';
        } else {
            $address_line3 = '';
        }
        if ($data['consignee_detail']['address_line4'] != null) {
            $address_line4 = '<p>' . $data['consignee_detail']['address_line4'] . '</p>';
        } else {
            $address_line4 = '';
        }
        if ($data['consignee_detail']['district'] != null) {
            $district = '<p>' . $data['consignee_detail']['district'] . '</p>';
        } else {
            $district = '';
        }
        if ($data['consignee_detail']['gst_number'] != null) {
            $gst_number = '<p>GST No: ' . $data['consignee_detail']['gst_number'] . '</p>';
        } else {
            $gst_number = '';
        }
        if ($data['consignee_detail']['phone'] != null) {
            $phone = '<p>Phone No: ' . $data['consignee_detail']['phone'] . '</p>';
        } else {
            $phone = '';
        }

        $consnee_add = '<p>' . 'CONSIGNEE NAME & ADDRESS' . '</p>
        ' . $nick_name . ' ' . $address_line1 . ' ' . $address_line2 . ' ' . $address_line3 . ' ' . $address_line4 . '
        ' . $district . ' ' . $gst_number . ' ' . $phone;

        if ($data['shipto_detail']['nick_name'] != null) {
            $nick_name = '<p><b>' . $data['shipto_detail']['nick_name'] . '</b></p>';
        } else {
            $nick_name = '';
        }
        if ($data['shipto_detail']['address_line1'] != null) {
            $address_line1 = '<p>' . $data['shipto_detail']['address_line1'] . '</p>';
        } else {
            $address_line1 = '';
        }
        if ($data['shipto_detail']['address_line2'] != null) {
            $address_line2 = '<p>' . $data['shipto_detail']['address_line2'] . '</p>';
        } else {
            $address_line2 = '';
        }
        if ($data['shipto_detail']['address_line3'] != null) {
            $address_line3 = '<p>' . $data['shipto_detail']['address_line3'] . '</p>';
        } else {
            $address_line3 = '';
        }
        if ($data['shipto_detail']['address_line4'] != null) {
            $address_line4 = '<p>' . $data['shipto_detail']['address_line4'] . '</p>';
        } else {
            $address_line4 = '';
        }
        if ($data['shipto_detail']['district'] != null) {
            $district = '<p>' . $data['shipto_detail']['district'] . '</p>';
        } else {
            $district = '';
        }
        if ($data['shipto_detail']['gst_number'] != null) {
            $gst_number = '<p>GST No: ' . $data['shipto_detail']['gst_number'] . '</p>';
        } else {
            $gst_number = '';
        }
        if ($data['shipto_detail']['phone'] != null) {
            $phone = '<p>Phone No: ' . $data['shipto_detail']['phone'] . '</p>';
        } else {
            $phone = '';
        }

        $shiptoadd = '<p>' . 'SHIP TO NAME & ADDRESS' . '</p>
        ' . $nick_name . ' ' . $address_line1 . ' ' . $address_line2 . ' ' . $address_line3 . ' ' . $address_line4 . '
        ' . $district . ' ' . $gst_number . ' ' . $phone;

        $generate_qrcode = QrCode::size(150)->generate('Eternity Forwarders Pvt. Ltd.');
        $output_file = '/qr-code/img-' . time() . '.svg';
        Storage::disk('public')->put($output_file, $generate_qrcode);
        $fullpath = storage_path('app/public/' . $output_file);
        //echo'<pre>'; print_r($fullpath);
        //  dd($generate_qrcode);
        if ($request->typeid == 1) {
            $adresses = '<table width="100%">
                    <tr>
                        <td style="width:50%">' . $conr_add . '</td>
                        <td style="width:50%">' . $consnee_add . '</td>
                    </tr>
                </table>';
        } else if ($request->typeid == 2) {
            $adresses = '<table width="100%">
                        <tr>
                            <td style="width:33%">' . $conr_add . '</td>
                            <td style="width:33%">' . $consnee_add . '</td>
                            <td style="width:33%">' . $shiptoadd . '</td>
                        </tr>
                    </table>';
        }
        for ($i = 1; $i < 5; $i++) {
            if ($i == 1) {$type = 'ORIGINAL';} elseif ($i == 2) {$type = 'DUPLICATE';} elseif ($i == 3) {$type = 'TRIPLICATE';} elseif ($i == 4) {$type = 'QUADRUPLE';}

            $html = '<!DOCTYPE html>
                    <html lang="en">
                        <head>
                            <title>PDF</title>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <style>
                                .aa{
                                    border: 1px solid black;
                                    border-collapse: collapse;
                                }
                                .bb{
                                    border: 1px solid black;
                                    border-collapse: collapse;
                                }
                                .cc{
                                    border: 1px solid black;
                                    border-collapse: collapse;
                                }
                                h2.l {
                                    margin-left: 90px;
                                    margin-top: 132px;
                                    margin-bottom: 2px;
                                }
                                p.l {
                                    margin-left: 90px;
                                }
                                img#set_img {
                                    margin-left: 25px;
                                    margin-bottom: 100px;
                                }

                                p {
                                    margin-top: 2px;
                                    margin-bottom: 2px;
                                }
                                h4 {
                                    margin-top: 2px;
                                    margin-bottom: 2px;
                                }
                                body {
                                    font-family: Arial, Helvetica, sans-serif;
                                    font-size: 14px;
                                }
                            </style>
                        </head>

                        <body>
                        <div class="container">
                            <div class="row">';

            $html .= '<h2>' . $branch_add->name . '</h2>
                                <table width="100%">
                                    <tr>
                                        <td width="50%">
                                            <p>Plot No. ' . $branch_add->address . '</p>
                                            <p>' . $branch_add->district . ' - ' . $branch_add->postal_code . ',' . $branch_add->state . '</p>
                                            <p>GST No. : ' . $branch_add['gst_number'] . '</p>
                                            <p>Email : ' . @$locations->email . '</p>
                                            <p>Phone No. : ' . @$locations->phone . '' . '</p>
                                            <br>
                                            <span>
                                                <hr id="s" style="width:100%;">
                                                </hr>
                                            </span>
                                        </td>
                                        <td width="50%">
                                            <h2 class="l">CONSIGNMENT NOTE</h2>
                                            <p class="l">' . $type . '</p>
                                        </td>
                                    </tr>
                                </table></div></div>';
            $html .= '<div class="row"><div class="col-sm-6">
                                <table width="100%">
                                <tr>
                            <td width="30%">
                                <p><b>Consignment No.</b></p>
                                <p><b>Consignment Date</b></p>
                                <p><b>Dispatch From</b></p>
                                <p><b>Invoice No.</b></p>
                                <p><b>Invoice Date</b></p>
                                <p><b>Value INR</b></p>
                                <p><b>Vehicle No.</b></p>
                                <p><b>Driver Name</b></p>
                            </td>
                            <td width="30%">';
            if (@$data['consignment_no'] != '') {
                $html .= '<p>' . $data['id'] . '</p>';
            } else {
                $html .= '<p>N/A</p>';
            }
            if (@$data['consignment_date'] != '') {
                $html .= '<p>' . date('d-m-Y', strtotime($data['consignment_date'])) . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }
            if (@$data['consigner_detail']['city'] != '') {
                $html .= '<p> ' . $data['consigner_detail']['city'] . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }
            if (@$data['invoice_no'] != '') {
                $html .= '<p>' . $data['invoice_no'] . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }
            if (@$data['invoice_date'] != '') {
                $html .= '<p>' . date('d-m-Y', strtotime($data['invoice_date'])) . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }
            if (@$data['invoice_amount'] != '') {
                $html .= '<p>' . $data['invoice_amount'] . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }
            if (@$data['vehicle_detail']['regn_no'] != '') {
                $html .= '<p>' . $data['vehicle_detail']['regn_no'] . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }
            if (@$data['driver_detail']['name'] != '') {
                $html .= '<p>' . ucwords($data['driver_detail']['name']) . '</p>';
            } else {
                $html .= '<p> N/A </p>';
            }

            $html .= '</td>
                            <td width="50%" colspan="3" style="text-align: center;">
                            <img src= "' . $fullpath . '" alt="barcode">
                            </td>
                        </tr>
                    </table>
                </div>
                <span><hr id="e"></hr></span>
            </div>
            <div class="main">' . $adresses . '</div>
            <span><hr id="e"></hr></span><br>';
            $html .= '<div class="bb">
                <table class="aa" width="100%">
                    <tr>
                        <th class="cc">Sr.No.</th>
                        <th class="cc">Description</th>
                        <th class="cc">Quantity</th>
                        <th class="cc">Net Weight</th>
                        <th class="cc">Gross Weight</th>
                        <th class="cc">Freight</th>
                        <th class="cc">Payment Terms</th>
                    </tr>';
            ///
            foreach ($data['consignment_items'] as $k => $dataitem) {
                $html .= '<tr>' .
                    '<td class="cc">' . $i . '</td>' .
                    '<td class="cc">' . $dataitem['description'] . '</td>' .
                    '<td class="cc">' . $dataitem['packing_type'] . ' ' . $dataitem['quantity'] . '</td>' .
                    '<td class="cc">' . $dataitem['weight'] . ' Kgs.</td>' .
                    '<td class="cc">' . $dataitem['gross_weight'] . ' Kgs.</td>' .
                    '<td class="cc">INR ' . $dataitem['freight'] . '</td>' .
                    '<td class="cc">' . $dataitem['payment_type'] . '</td>' .
                    '</tr>';
            }
            $html .= '<tr><td colspan="2" class="cc"><b>TOTAL</b></td>
                            <td class="cc">' . $data['total_quantity'] . '</td>
                            <td class="cc">' . $data['total_weight'] . ' Kgs.</td>
                            <td class="cc">' . $data['total_gross_weight'] . ' Kgs.</td>
                            <td class="cc"></td>
                            <td class="cc"></td>
                        </tr></table></div><br><br>
                        <span><hr id="e"></hr></span>';

            $html .= '<div class="nn">
                                <table  width="100%">
                                    <tr>
                                        <td>
                                            <h4><b>Receivers Signature</b></h4>
                                            <p>Received the goods mentioned above in good condition.</p>
                                        </td>
                                        <td>
                                        <h4><b>For Eternity Forwarders Pvt. Ltd.</b></h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </body>
                    </html>';

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->save(public_path() . '/consignment-pdf/congn-' . $i . '.pdf')->stream('congn-' . $i . '.pdf');
            $pdf_name[] = 'congn-' . $i . '.pdf';
        }
        $pdfMerger = PDFMerger::init();
        foreach ($pdf_name as $pdf) {
            $pdfMerger->addPDF(public_path() . '/consignment-pdf/' . $pdf);
        }
        $pdfMerger->merge();
        $pdfMerger->save("all.pdf", "browser");
        $file = new Filesystem;
        $file->cleanDirectory('pdf');
    }

    public function unverifiedList(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
        $authuser = Auth::user();
        $cc = explode(',', $authuser->branch_id);
        //echo'<pre>';print_r($cc);die;
        if ($authuser->role_id == 2) {
            $consignments = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_id', 'consignees.nick_name as consignee_id', 'consignees.city as city', 'consignees.postal_code as pincode')
                ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
                ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            // ->join('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
            // ->join('drivers', 'drivers.id', '=', 'consignment_notes.driver_id')
                ->where('consignment_notes.status', '=', '2')
                ->whereIn('consignment_notes.branch_id', $cc)
                ->get(['consignees.city']);
            //echo'<pre>';print_r($consignments);die;
        } else {
            $consignments = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_id', 'consignees.nick_name as consignee_id', 'consignees.city as city', 'consignees.postal_code as pincode')
                ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
                ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            // ->join('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
            // ->join('drivers', 'drivers.id', '=', 'consignment_notes.driver_id')
                ->where('consignment_notes.status', '=', '2')
                ->get(['consignees.city']);
        }
        //echo'<pre>'; print_r($consignments); die;

        // if($authuser->role_id == 2){
        //  $consignments = ConsignmentNote::where('status', '=', '2')->whereIn('branch_id', $cc)->get();
        // }else{
        // $consignments = ConsignmentNote::where('status', '=', '2')->get();
        // }
        $vehicles = Vehicle::where('status', '1')->select('id', 'regn_no')->get();
        $drivers = Driver::where('status', '1')->select('id', 'name', 'phone')->get();
        $vehicletypes = VehicleType::where('status', '1')->select('id', 'name')->get();
        return view('consignments.unverified-list', ['consignments' => $consignments, 'prefix' => $this->prefix, 'title' => $this->title, 'vehicles' => $vehicles, 'drivers' => $drivers, 'vehicletypes' => $vehicletypes])
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function updateUnverifiedLr(Request $request)
    {

        $consignerId = $request->transaction_id;
        //echo'<pre>';print_r($consignerId);die;
        $cc = explode(',', $consignerId);
        $addvechileNo = $request->vehicle_id;
        $adddriverId = $request->driver_id;
        $vehicleType = $request->vehicle_type;
        $transporterName = $request->transporter_name;

        $consigner = DB::table('consignment_notes')->whereIn('id', $cc)->update(['vehicle_id' => $addvechileNo, 'driver_id' => $adddriverId, 'transporter_name' => $transporterName, 'vehicle_type' => $vehicleType, 'delivery_status' => '2']);
        //echo'hii';

        $consignees = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_id', 'consignees.nick_name as consignee_id', 'vehicles.regn_no as vehicle_id', 'consignees.city as city', 'consignees.postal_code as pincode', 'drivers.name as driver_id', 'drivers.phone as driver_phone')
            ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
            ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            ->join('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
            ->join('drivers', 'drivers.id', '=', 'consignment_notes.driver_id')
            ->whereIn('consignment_notes.id', $cc)
            ->get(['consignees.city']);
        //echo'<pre>'; print_r($consignees); die;

        $simplyfy = json_decode(json_encode($consignees), true);
        foreach ($simplyfy as $value) {
            $consignment_no = $value['consignment_no'];
            $vehicle_no = $value['vehicle_id'];
            $consignee_id = $value['consignee_id'];
            $consignment_date = $value['consignment_date'];
            $city = $value['city'];
            $pincode = $value['pincode'];
            $total_quantity = $value['total_quantity'];
            $total_weight = $value['total_weight'];
            $driverName = $value['driver_id'];
            $driverPhone = $value['driver_phone'];

        }

        $transaction = DB::table('transaction_sheets')->whereIn('consignment_no', $cc)->update(['vehicle_no' => $vehicle_no, 'driver_name' => $driverName, 'driver_no' => $driverPhone, 'status' => '2']);

        $createTask = $this->createTookanTasks($simplyfy);

        $response['success'] = true;
        $response['success_message'] = "Data Imported successfully";
        return response()->json($response);

    }    

    public function createTookanTasks($taskDetails) {
       
        $authuser = Auth::user();
        $cc = explode(',',$authuser->branch_id);
        $teamIDarr= Location::select('team_id')->whereIn('id',$cc)->first();
        $tid = json_decode(json_encode($teamIDarr), true);

        foreach ($taskDetails as $task){

            $td = '{
                "api_key": "50666282f31751191c4f723c1410224319e5cdfb2fd5723e5a19",
                "order_id": "'.$task['order_id'].'",
                "job_description": "DSR-'.$task['id'].'",
                "customer_email": "'.$task['email'].'",
                "customer_username": "'.$task['consignee_name'].'",
                "customer_phone": "'.$task['phone'].'",
                "customer_address": "'.$task['pincode'].','.$task['city'].',India",
                "latitude": "",
                "longitude": "",
                "job_delivery_datetime": "'.$task['edd'].' 21:00:00",
                "custom_field_template": "Template_1",
                "meta_data": [
                    {
                        "label": "Invoice Amount",
                        "data": "'.$task['invoice_amount'].'"
                    },
                    {
                        "label": "Quantity",
                        "data": "'.$task['total_weight'].'"
                    }
                ],
                "team_id": "'.$tid['team_id'].'",
                "auto_assignment": "1",
                "has_pickup": "0",
                "has_delivery": "1",
                "layout_type": "0",
                "tracking_link": 1,
                "timezone": "-330",
                "fleet_id": "1428606",
                "notify": 1,
                "tags": "",
                "geofence": 0
            }';

           //echo "<pre>";print_r($td);echo "</pre>";die;

            //die;

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.tookanapp.com/v2/create_task',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>$td,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));
            
            $response[] = curl_exec($curl);
            
            curl_close($curl);

        }

        return $response;
        
    }

    public function transactionSheet()
    {
        $this->prefix = request()->route()->getPrefix();
        $vehicles = Vehicle::where('status', '1')->select('id', 'regn_no')->get();
        $drivers = Driver::where('status', '1')->select('id', 'name', 'phone')->get();
        $vehicletypes = VehicleType::where('status', '1')->select('id', 'name')->get();
        $authuser = Auth::user();
        $cc = $authuser->branch_id;
        if ($authuser->role_id == 2) {

            $transaction = TransactionSheet::select('drs_no', 'created_at', 'vehicle_no', 'driver_name', 'driver_no', 'status')->where('branch_id', '=', $cc)->distinct()->get();
        } else {
            $transaction = TransactionSheet::all();
        }

        return view('consignments.transaction-sheet', ['prefix' => $this->prefix, 'title' => $this->title, 'transaction' => $transaction, 'vehicles' => $vehicles, 'drivers' => $drivers, 'vehicletypes' => $vehicletypes]);
    }

    public function getTransactionDetails(Request $request)
    {
        $id = $_GET['cat_id'];

        $transcationview = DB::table('transaction_sheets')->select('*')->where('drs_no', $id)->orderby('order_no', 'asc')->get();
        $result = json_decode(json_encode($transcationview), true);
        //echo'<pre>'; print_r($result);
        //   foreach($simplfy as $value){

        //        $result[] = $value;
        //   }

        //  $col  = 'order_no';
        //  $sort = array();
        //  foreach ($result as $i => $obj) {
        //    $sort[$i] = $obj->{$col};
        //  }

        //  $sorted_db = array_multisort($sort, SORT_ASC, $result);

        // //  echo'<pre>'; print_r($result);
        // //  die;

        $response['fetch'] = $result;
        $response['success'] = true;
        $response['success_message'] = "Data Imported successfully";
        echo json_encode($response);

    }
    public function printTransactionsheet(Request $request)
    {
        //echo'<pre>'; print_r(); die;
        $id = $request->id;
        $transcationview = TransactionSheet::select('*')->with('ConsignmentDetail')->where('drs_no', $id)->orderby('order_no', 'asc')->get();

        $simplyfy = json_decode(json_encode($transcationview), true);

        $details = $simplyfy[0];

        $pay = url('assets/img/LOGO_Frowarders.jpg');
        //echo'<pre>'; print_r($pay); die;
        //<img src="" alt="logo" alt="" width="80" height="70">
        $drsDate = date('d-m-Y', strtotime($details['created_at']));
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
        <div class="row">
                            <div class="col-sm-12">
 
                                <h1 style="text-align:center;">Delivery Run Sheet</h1>
                                <table>
                                <tr>
                                <td>
                                    <label>DRS No :</label>
                                </td>
                                <td >
                                    <label id="sss">DRS-' . $details['drs_no'] . '</label>
                                </td>
                            </tr>
                            <tr>
                            <td>
                                <label>Date:</label>
                            </td>
                            <td >
                                <label id="sss">' . $drsDate . '</label>
                            </td>
                        </tr>
                                    <tr>
                                        <td>
                                            <label>Vehicle No :</label>
                                        </td>
                                        <td >
                                            <label id="sss">' . $details['vehicle_no'] . '</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Driver Name :</label>
                                        </td>
                                        <td style="width: 300px;">
                                            <label id="ppp" >' . @$details['driver_name'] . '</label>
                                        </td>
 
                                        <td >
                                            <label>Driver Number :</label>
                                        </td>
                                        <td width: 131px;>
                                            <label id="nnn">' . @$details['driver_no'] . '</label>
                                        </td>
                                    </tr>
                                </table>
                                <div>
 
                                </div>
                                      <div class="table-responsive " style="margin-top:10px;">
                                    <table id="sheet" class="table table-hover tb" style="width:100%;  border: 1px solid; border-collapse: collapse;">
                                        <thead>
                                            <tr  style=" border: 1px solid; border-collapse: collapse;">
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Order ID</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">LR No</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Consignment Date</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Consignee Name</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">City</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Pin Code</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Number Of Boxes</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Net Weight</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">EDD</th>
                                                <th  style=" border: 1px solid; border-collapse: collapse;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
         //echo'<pre>'; print_r($transactionDecode);
         $i = 0;
         $total_Boxes = 0;
         $total_weight = 0;
 
         foreach ($simplyfy as $dataitem) {
 
             $i++;
             $total_Boxes += $dataitem['total_quantity'];
             $total_weight += $dataitem['total_weight'];
             //echo'<pre>'; print_r($dataitem['consignment_no']); die;
             $html .= '      <tr  style=" border: 1px solid; border-collapse: collapse;">
                                  <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . @$dataitem['consignment_detail']['order_id'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['consignment_no'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['consignment_date'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['consignee_id'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['city'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['pincode'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['total_quantity'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $dataitem['total_weight'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . @$dataitem['consignment_detail']['edd'] . '</td>
                                                <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                            </tr>';
         }
 
         $html .= ' </tbody>
                                        <tfoot>
                                              <tr  style=" border: 1px solid; border-collapse: collapse;">
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">Total: ' . $i . '</td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $total_Boxes . '</td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;">' . $total_weight . '</td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                                   <td  style=" border: 1px solid; border-collapse: collapse; text-align:center;"></td>
                                              </tr>
 
                                        </tfoot>
                                    </table>
 
                                  </div>
 
 
                                   <div class="row" style="padding: 5px;">
                                        <div class="col-sm-12">
 
                                            <hr></hr>
                                        </div>
        </body>
        </html>';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('print.pdf');

    }

    public function updateEDD(Request $request)
    {
        //echo'<pre>'; print_r($_POST); die;
        $edd = $_POST['drs_edd'];
        $consignmentId = $_POST['consignment_id'];

        $consigner = DB::table('consignment_notes')->where('id', $consignmentId)->update(['edd' => $edd]);
        if ($consigner) {
            //echo'ok';
            return response()->json(['success' => 'EDD Updated Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function CreateEdd(Request $request)
    {

        $consignmentId = $_POST['consignmentID'];
        $authuser = Auth::user();
        $cc = $authuser->branch_id;

        $consigner = DB::table('consignment_notes')->whereIn('id', $consignmentId)->update(['status' => '1']);
        $consignment = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_id', 'consignees.nick_name as consignee_id', 'consignees.city as city', 'consignees.postal_code as pincode')
            ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
            ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            ->whereIn('consignment_notes.id', $consignmentId)
            ->get(['consignees.city']);

        $simplyfy = json_decode(json_encode($consignment), true);
        //echo'<pre>'; print_r($simplyfy); die;

        $no_of_digit = 5;
        $drs = DB::table('transaction_sheets')->select('drs_no')->latest('drs_no')->first();
        $drs_no = json_decode(json_encode($drs), true);
        if (empty($drs_no) || $drs_no == null) {
            $drs_no['drs_no'] = 0;
        }
        $number = $drs_no['drs_no'] + 1;
        $drs_no = str_pad($number, $no_of_digit, "0", STR_PAD_LEFT);

        $i = 0;
        foreach ($simplyfy as $value) {
            $i++;
            $unique_id = $value['id'];
            $consignment_no = $value['consignment_no'];
            $consignee_id = $value['consignee_id'];
            $consignment_date = $value['consignment_date'];
            $city = $value['city'];
            $pincode = $value['pincode'];
            $total_quantity = $value['total_quantity'];
            $total_weight = $value['total_weight'];

            //echo'<pre>'; print_r($data); die;

            $transaction = DB::table('transaction_sheets')->insert(['drs_no' => $drs_no, 'consignment_no' => $unique_id, 'branch_id' => $cc, 'consignee_id' => $consignee_id, 'consignment_date' => $consignment_date, 'city' => $city, 'pincode' => $pincode, 'total_quantity' => $total_quantity, 'total_weight' => $total_weight, 'order_no' => $i, 'status' => '1']);
        }

        $response['success'] = true;
        $response['success_message'] = "Data Imported successfully";
        return response()->json($response);

    }

    public function updateSuffle(Request $request)
    {
        $page_id = $request->page_id_array;
        for ($count = 0; $count < count($page_id); $count++) {
            $drs = DB::table('transaction_sheets')->where('id', $page_id[$count])->update(['order_no' => $count + 1]);
        }

    }
    public function view_saveDraft(Request $request)
    {
        //echo'hi';
        $id = $_GET['draft_id'];
        $transcationview = TransactionSheet::select('*')->with('ConsignmentDetail')->where('drs_no', $id)->orderby('order_no', 'asc')->get();
        $result = json_decode(json_encode($transcationview), true);
        //echo'<pre>'; print_r($result); die;

        $response['fetch'] = $result;
        $response['success'] = true;
        $response['success_message'] = "Data Imported successfully";
        echo json_encode($response);

    }

    public function updateDelivery(Request $request)
    {
        $id = $_GET['draft_id'];
        $transcationview = TransactionSheet::select('*')->with('ConsignmentDetail')->where('drs_no', $id)->get();
        $result = json_decode(json_encode($transcationview), true);
       // echo'<pre>'; print_r($result); die;
        $response['fetch'] = $result;
        $response['success'] = true;
        $response['success_message'] = "Data Imported successfully";
        echo json_encode($response);

    }

    public function updateDeliveryStatus(Request $request)
    {
        //echo'<pre>'; print_r($_POST); die;
        $consignmentId = $_POST['consignment_no'];
        $cc = explode(',', $consignmentId);
    
        $consigner = DB::table('consignment_notes')->whereIn('id', $cc)->update(['delivery_status' => '3']);

        $drs = DB::table('transaction_sheets')->whereIn('consignment_no', $cc)->update(['status' => '3']);

        $response['success'] = true;
        $response['success_message'] = "Data Imported successfully";
        return response()->json($response);

    }
    ////////////////////////////////////////////////////
    public function consignmentReports()
    {
        $this->prefix = request()->route()->getPrefix();

        $query = ConsignmentNote::query();
        $authuser = Auth::user();
        $cc = explode(',', $authuser->branch_id);
        if ($authuser->role_id == 2) {
            $consignments = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_nickname', 'consignees.nick_name as consignee_nickname', 'consignees.city as city', 'consignees.postal_code as pincode',  'consignees.district as district', 'states.name as state', 'vehicles.regn_no as vechile_number','consigners.city as consigners_city')
                ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
                ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
                ->leftjoin('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
                ->join('states', 'states.id', '=', 'consignees.state_id')
                ->whereIn('consignment_notes.branch_id', $cc)
                ->get(['consignees.city']);

        } else {
            $consignments = DB::table('consignment_notes')->select('consignment_notes.*', 'consigners.nick_name as consigner_nickname', 'consignees.nick_name as consignee_nickname', 'consignees.city as city', 'consignees.postal_code as pincode',  'consignees.district as district', 'states.name as state','vehicles.regn_no as vechile_number','consigners.city as consigners_city')
            ->join('consigners', 'consigners.id', '=', 'consignment_notes.consigner_id')
            ->join('consignees', 'consignees.id', '=', 'consignment_notes.consignee_id')
            ->leftjoin('vehicles', 'vehicles.id', '=', 'consignment_notes.vehicle_id')
            ->join('states', 'states.id', '=', 'consignees.state_id')
            ->get(['consignees.city']);

        }
          //echo'<pre>'; print_r($consignments); die;
        

           return view ('consignments.consignment-report', ['consignments' => $consignments, 'prefix' => $this->prefix]);
        

    }

    public function updateDeliveryDateOneBy(Request $request)
    {
       
        $delivery_date = $_POST['delivery_date'];
        $consignmentId = $_POST['consignment_id'];
        $consigner = DB::table('consignment_notes')->where('id', $consignmentId)->update(['delivery_date' => $delivery_date]);
        if ($consigner) {
            //echo'ok';
            return response()->json(['success' => 'Delivery Date Updated Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

/////////////////Web Hooks/////////////////////////////
    public function agent_webhooks(Request $data)
    {
        if (!empty($data)) {
            echo 'no data found';
        } else {
            echo '<pre>';
            print_r($data);die;
        }
    }

}
