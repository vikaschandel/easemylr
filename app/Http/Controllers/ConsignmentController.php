<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsignmentNote;
use App\Models\ConsignmentItem;
use App\Models\Consigner;
use App\Models\Consignee;
use App\Models\Branch;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Auth;
use DB;
use Crypt;
use Helper;
use Validator;
Use PDF;
use PDFMerger;

class ConsignmentController extends Controller
{

    public function __construct()
    {
      $this->title =  "Consignments Listing";
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
        $peritem = 20;
        $query = ConsignmentNote::query();
        $consignments = $query->orderby('id','DESC')->paginate($peritem);
        return view('consignments.consignment-list',['consignments'=>$consignments,'prefix'=>$this->prefix])
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
        $consigners = Consigner::select('id','nick_name')->get();
        $consignees = Consignee::select('id','nick_name')->get();
        $branchs = Branch::where('status','1')->select('id','consignment_note')->get();
        $vehicles = Vehicle::where('status','1')->select('id','regn_no')->get();
        $vehicletypes = VehicleType::where('status','1')->select('id','name')->get();
        return view('consignments.create-consignment',['prefix'=>$this->prefix,'consigners'=>$consigners,'consignees'=>$consignees,'branchs'=>$branchs,'vehicles'=>$vehicles,'vehicletypes'=>$vehicletypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try{
            DB::beginTransaction();

            $this->prefix = request()->route()->getPrefix();
            $authuser = Auth::user();
            $rules = array(
                'consigner_id' => 'required',
                'consignee_id' => 'required',
                'ship_to_id'   => 'required',
                'invoice_no'   => 'required',
            );
            $validator = Validator::make($request->all(),$rules);
        
            if($validator->fails())
            {
                $errors                 = $validator->errors();
                $response['success']    = false;
                $response['validation'] = false;
                $response['formErrors'] = true;
                $response['errors']     = $errors;
                return response()->json($response);
            }
            
            $consignmentsave['consigner_id']     = $request->consigner_id;
            $consignmentsave['consignee_id']     = $request->consignee_id;
            $consignmentsave['ship_to_id']       = $request->ship_to_id;
            //$consignmentsave['consignment_no']   = $request->consignment_no;
            $consignmentsave['consignment_date'] = $request->consignment_date;
            $consignmentsave['dispatch']         = $request->dispatch;
            $consignmentsave['invoice_no']       = $request->invoice_no;
            $consignmentsave['invoice_date']     = $request->invoice_date;
            $consignmentsave['invoice_amount']   = $request->invoice_amount;
            $consignmentsave['total_quantity']   = $request->total_quantity;
            $consignmentsave['total_weight']     = $request->total_weight;          
            $consignmentsave['total_gross_weight']= $request->total_gross_weight;          
            $consignmentsave['total_freight']     = $request->total_freight;          
            $consignmentsave['transporter_name']  = $request->transporter_name;          
            $consignmentsave['vehicle_type']      = $request->vehicle_type;          
            $consignmentsave['purchase_price']    = $request->purchase_price; 
            $consignmentsave['user_id']           = $authuser->id; 
            $consignmentsave['status']            = 1;

            $saveconsignment = ConsignmentNote::create($consignmentsave); 
            if($saveconsignment)
            {
                $consignment_no = str_pad($saveconsignment->id,8,"0", STR_PAD_LEFT);
                ConsignmentNote::where('id',$saveconsignment->id)->update(['consignment_no'=>$consignment_no]);

                // insert consignment items
                if(!empty($request->data)){ 
                    $get_data=$request->data;
                    foreach ($get_data as $key => $save_data ) { 
                      $save_data['consignment_id'] = $saveconsignment->id; 
                      $save_data['status']         = 1;
                      $saveconsignmentitems = ConsignmentItem::create($save_data);
                    }              
                }

                $response['success'] = true;
                $response['success_message'] = "Consignment Added successfully";
                $response['error'] = false;
                $response['resetform'] = true;
                $response['page'] = 'create-branch'; 
            }
            else{
                $response['success'] = false;
                $response['error_message'] = "Can not created consignment please try again";
                $response['error'] = true;
            }
            DB::commit();
        }catch(Exception $e){
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
        $id = $consignment;
        $auth = Auth::user();
        $query = ConsignmentNote::query();
        if ( ($auth->role_id == 1) || ($auth->role_id == 2) ) {
            $getconsignment = $query->orderBy('id','DESC')->get();
        } else {
            $getconsignment = $query->where('branch_id',$auth->branch_id)->orderBy('id','DESC')->get();
        }
        return view('consignments.view-consignment',['prefix'=>$this->prefix,'title'=>$this->title,'getconsignment'=>$getconsignment]);
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
    public function getConsigners(Request $request){
        $getconsigners = Consigner::select('address','gst_number','phone','city')->where(['id'=>$request->consigner_id,'status'=>'1'] )->first();
        if($getconsigners)
        {
            $response['success']         = true;
            $response['success_message'] = "Consigner list fetch successfully";
            $response['error']           = false;
            $response['data']            = $getconsigners;
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not fetch consigner list please try again";
            $response['error']           = true;
        }
    	return response()->json($response);
    }

    // get consigner address on change
    public function getConsignees(Request $request){
        $getconsignees = Consignee::select('address_line1','address_line2','address_line3','gst_number','phone')->where(['id'=>$request->consignee_id,'status'=>'1'] )->first();
       if($getconsignees)
        {
            $response['success']         = true;
            $response['success_message'] = "Consignee list fetch successfully";
            $response['error']           = false;
            $response['data']            = $getconsignees;
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not fetch consignee list please try again";
            $response['error']           = true;
        }
    	return response()->json($response);
    }

    public function get_cn_details(Request $request){
        $consignment_id = request()->consignment_id;
        $consignment_details = ConsignmentNote::select('consignment_no','consignment_date','dispatch','invoice_no','invoice_date','invoice_amount','total_quantity','total_weight','total_gross_weight','total_freight','transporter_name','vehicle_type','purchase_price')->where(['id'=>$consignment_id])->first();
        if($consignment_details)
        {
            $response['success']         = true;
            $response['success_message'] = "Consignment details fetch successfully";
            $response['error']           = false;
            $response['data']            = $consignment_details;
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not fetch consignment details please try again";
            $response['error']           = true;
        }
        return response()->json($response);
    }

    // getConsigndetails
    public function getConsigndetails(Request $request){
        $cn_id = $request->id;
        $cn_details = ConsignmentNote::where('id',$cn_id)->with('ConsignmentItems','ConsignerDetail','ConsigneeDetail','ShiptoDetail')->first();
        if($cn_details)
        {
            $response['success']         = true;
            $response['success_message'] = "Consignment details fetch successfully";
            $response['error']           = false;
            $response['data']            = $cn_details;
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not fetch consignment details please try again";
            $response['error']           = true;
        }
        return response()->json($response);
    }

    public function consignPrintview(Request $request){
        $cn_id = $request->id;
        $getdata = ConsignmentNote::where('id',$cn_id)->with('ConsignmentItems','ConsignerDetail','ConsigneeDetail','ShiptoDetail')->first();
       
        $data = json_decode(json_encode($getdata), true);
        $conr_add = '<strong>'.$data['consigner_detail']['nick_name'].'</strong><br>'.$data['consigner_detail']['address'].',<br>'.$data['consigner_detail']['district'].',<br>'.$data['consigner_detail']['city'].'- '.$data['consigner_detail']['postal_code'].',<strong><br>GST No. : </strong>'.$data['consigner_detail']['gst_number'].'' ;
        
        $consnee_add = '<strong>'.$data['consignee_detail']['nick_name'].'</strong><br>'.$data['consignee_detail']['address_line1'].' '.$data['consignee_detail']['address_line2'].' '.$data['consignee_detail']['address_line3'].',<br>'.$data['consignee_detail']['district'].',<br>'.$data['consignee_detail']['city'].' - '.$data['consignee_detail']['postal_code'].',<strong><br>GST No. : </strong>'.$data['consignee_detail']['gst_number'].'';

        $shiptoadd = '<strong>'.$data['consignee_detail']['nick_name'].'</strong><br>'.$data['consignee_detail']['address_line1'].' '.$data['consignee_detail']['address_line2'].' '.$data['consignee_detail']['address_line3'].',<br>'.$data['consignee_detail']['district'].',<br>'.$data['consignee_detail']['city'].' - '.$data['consignee_detail']['postal_code'].',<strong><br>GST No. : </strong>'.$data['consignee_detail']['gst_number'].'';

       
        if ($request->typeid == 1){
        $adresses = '<div style="width:50%; float:left; font-family:"Open Sans",sans-serif;" >
                        <table class="custom_table" width="100%">
                            <tr>
                                <td style="font-family:Open Sans,sans-serif">CONSIGNOR NAME & ADDRESS</td>
                            </tr>
                            <tr>
                                <td style="font-family:Open Sans,sans-serif"><span id="consignerAddress">'.$conr_add.'</span></td>
                            </tr>
                        </table>
                    </div>
                    <div style="width:50%; float:left; font-family:"Open Sans",sans-serif;">
                        <table class="custom_table" width="100%">
                            <tr>
                                <td style="font-family:Open Sans,sans-serif">CONSIGNEE NAME & ADDRESS</td>
                            </tr>
                            <tr>
                                <td style="font-family:Open Sans,sans-serif"><span id="consigneeAddress">'.$consnee_add.'</span></td>
                            </tr>
                        </table>
                    </div>';
                } else if ($request->typeid == 2){
                    $adresses = '<div style="width:33%; float:left; font-family:"Open Sans",sans-serif;" >
                                                    <table class="custom_table" width="100%">
                                                        <tr>
                                                            <td style="font-family:Open Sans,sans-serif">CONSIGNOR NAME & ADDRESS</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family:Open Sans,sans-serif"><span id="consignerAddress">'.$conr_add.'</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div style="width:33%; float:left; font-family:"Open Sans",sans-serif;">
                                                    <table class="custom_table" width="100%">
                                                        <tr>
                                                            <td style="font-family:Open Sans,sans-serif">CONSIGNEE NAME & ADDRESS</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family:Open Sans,sans-serif"><span id="consigneeAddress">'.$consnee_add.'</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div style="width:33%; float:left; font-family:"Open Sans",sans-serif;">
                                                    <table class="custom_table" width="100%">
                                                        <tr>
                                                            <td style="font-family:Open Sans,sans-serif">SHIP TO NAME & ADDRESS</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family:Open Sans,sans-serif"><span id="ship_to_Address">'.$shiptoadd.'</span></td>
                                                        </tr>
                                                    </table>
                                                </div>';
                 }
                
            for ($i=1; $i<5; $i++){
                if ($i == 1) {$type='ORIGINAL';} else if ($i == 2){$type='DUPLICATE';} else if ($i == 3){$type='TRIPLICATE';} else if ($i == 4){$type='QUADRUPLE';}

                    $html = '<div class="row">
                        <div class="row">
                            <div style="float: left; width: 50%; font-family:"Open Sans",sans-serif;">
                                <h1 class="m-b-md" style="color:#4e5e6a; font-family:eurostile;font-size:23px; "><b>Eternity Forwarders Private Limited</h1><div id="warehouse_address" style="font-family:Open Sans,sans-serif">'.'Plot No. B014/03712, Frontier Complex<br> Pabhat, Zirakpur <br> SAS Nagar - 140 603, Punjab <br> GST No. : 03AAGCE4639L1ZI <br> Email : csr.ludhiana@eternitysolutions.net <br> Phone No. : 7743006796'.'</div>
                                <hr>
                                <table class="custom_table" style="font-family:"Open Sans",sans-serif; padding:3px;">
                                    <tr>
                                        <td style="font-family:Open Sans,sans-serif"><strong>Consignment No.</strong></td>
                                        <td style="font-family:Open Sans,sans-serif"><span id="cons_no">'.$data['consignment_no'].'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:Open Sans,sans-serif"><strong>Consignment Date</strong></td>
                                        <td style="font-family:Open Sans,sans-serif"><span id="cons_date">'.$data['consignment_date'].'</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:Open Sans,sans-serif"><strong>Dispatch From</strong></td>
                                        <td style="font-family:Open Sans,sans-serif"><span id="dispatch">'.'Ludhiana'.'</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:Open Sans,sans-serif"><strong>Invoice No.</strong></td>
                                        <td style="font-family:Open Sans,sans-serif"><span id="cons_invoice_no">'.$data['invoice_no'].'</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:Open Sans,sans-serif"><strong>Invoice Date</strong></td>
                                        <td style="font-family:Open Sans,sans-serif"><span id="invoice_date">'.$data['invoice_date'].'</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:Open Sans,sans-serif"><strong>Value</strong></td>
                                        <td style="font-family:Open Sans,sans-serif">INR <span id="invoice_amount">'.$data['invoice_amount'].'</span></td>
                                    </tr>
                                    
                                </table>
                            </div>
                            <div style="float: right; width: 40%; font-family:"Open Sans",sans-serif;">
                                <div style="align-text:center; margin:0 auto">
                                    <div height="150px"> </div>
                                    <h2 style="font-family:Open Sans,sans-serif; margin:0px">CONSIGNMENT NOTE</h2>
                                    <p style="margin:0px">'.$type.'</p>
                                    <br>
                                    <img id="bar_code" height="100px" src="'.'BARA CODE'.'"/>
                                </div>
                            </div>
                        </div><!--row-->
                        <div class="row">
                            <div class="col-md-12">
                            <hr>
                            '.$adresses.'
                            
                            </div>
                            <div style="min-height:100px"><br></div>
                            <div style="width:100%; font-family:"Open Sans",sans-serif;">
                                <table id="items_table" width="100%" align="left" class="table items-table" BORDER CELLSPACING=0><thead>
                                <tr><th>Sr. No.</th><th>Description</th><th>Quantity</th><th>Net Weight</th><th>Gross Weight</th><th>Freight</th><th>Payment Terms</th>
                                </tr></thead><tbody>';
                                
                        foreach($data['consignment_items'] as $k => $dataitem){ 
                        $html .=  '<tr>'.
                                    '<td>'.$i.'</td>'.
                                    '<td>'.$dataitem['description'].'</td>'.
                                    '<td>'.$dataitem['packing_type'].$dataitem['quantity'].'</td>'.
                                    '<td>'.$dataitem['weight'] .' Kgs.</td>'.
                                    '<td>'.$dataitem['gross_weight'].' Kgs.</td>'.
                                    '<td>INR '.$dataitem['freight'].'</td>'.
                                    '<td>'.$dataitem['payment_type'].'</td>'.
                                    '</tr>';
                        }
                        $html .= '</tbody><tfoot>
                            <tr class="total_items">
                                <td colspan="2" style="border:solid 1px #A9A9A9;border-style:solid; font-family:Open Sans,sans-serif; padding:5px;"><strong>TOTAL</strong></td>
                                <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="qty" class="no-m">'.$data['total_quantity'].'</span></strong></td>
                                <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="net_weight" class="no-m">'.$data['total_weight'].'</span> Kgs.</strong></td>
                                <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="gross_weight" class="no-m">'.$data['total_gross_weight'].'</span> Kgs.</strong></td>
                                <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="currency">INR </span><span id="tot_amt">'.$data['total_freight'].'</span></strong></td>
                                <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"></td>
                            </tr>
                        </tfoot></table>
                                
                                
                            </div>
                            <div style="width:100%; text-align:right; font-family:Open Sans,sans-serif;">'.'122121'.'</div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <table width="100%">
                            <tr>
                                <td width="70%" ><strong> </strong></td>
                                <td width="30%" style="font-family:Open Sans,sans-serif"><strong></strong></td>
                                
                            </tr>
                            <tr>
                                <td rowspan="4" width="70%"> </td>
                                <td width="20%" style="font-family:Open Sans,sans-serif;"></td>
                                
                            </tr>
                            <tr>
                                <td width="30%" style="font-family:Open Sans,sans-serif"><strong></strong></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-family:Open Sans,sans-serif"></td>
                            </tr>
                            <tr>
                            <td width="30%" style="font-family:Open Sans,sans-serif"></td>
                            </tr>
                            </table>
                        </div><!--row-->
                        <div class="row" style="margin-top:50px; font-family:"Open Sans",sans-serif;">
                            <div style="width:55%; float:left; border-top:solid 1px #000000">
                                <h3 style="font-family:Open Sans,sans-serif; margin:0px;">Receiver&#39;s Signature</h3>
                                <p style="font-family:Open Sans,sans-serif; margin:0px;">Received the goods mentioned above in good condition.</p>
                            </div>
                            <div style="width:10%; float:left;">
                            </div>
                            <div style="width:45%; float:right; font-family:Open Sans,sans-serif; border-top:solid 1px #000000">
                                <h3 style="font-family:Open Sans,sans-serif; margin:0px;">For Eternity Forwarders Pvt. Ltd.</h3>
                            </div>
                        </div>
                    </div>';

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($html);
                $pdf->setPaper('A4', 'portrait');
                $pdf->save(public_path().'/consignment-pdf/congn.pdf')->stream('congn.pdf');
                $pdf_name[] = 'congn.pdf';
            }
            $pdfMerger = PDFMerger::init();
            foreach($pdf_name as $pdf){
                // echo'<pre>'; print_r($pdf); die;
                $pdfMerger->addPDF(public_path().'/consignment-pdf/'.$pdf);
            }
            $pdfMerger->merge();
            $pdfMerger->save("all.pdf");
            
            return $pdfMerger->download('all.pdf');      
    }

}
