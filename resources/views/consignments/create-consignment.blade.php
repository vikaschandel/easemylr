@extends('layouts.main')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">
                        <h5>Create Consignment</h5>
                    </div>
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <form class="general_form" method="POST" action="{{url($prefix.'/consignments')}}" id="createconsignment">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Select Consignor</label>
                                            <div class="col-sm-12">
                                                <select id="select_consigner" class="form-control" type="text" name="consigner_id">
                                                    <option value="">Select Consignor</option>
                                                    @foreach($consigners as $consigner)
                                                    <option value="{{$consigner->id}}">{{$consigner->nick_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="container" style="padding-top:10px">
                                                    <div id="consigner_address">
                                                        <!-- <strong>FRONTIER AGROTECH PRIVATE LIMITED </strong><br/>KHASRA NO-390, RELIANCE ROAD <br/>GRAM BHOVAPUR <br/>HAPUR-245304 <br/><strong>GST No. : </strong>09AACCF3772B1ZU<br/><strong>Phone No. : </strong>9115115612 -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Select Consignee</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" type="text" name="consignee_id" id="select_consignee">
                                                    <option value="">Select Consignee</option>
                                                    @foreach($consignees as $consignee)
                                                    <option value="{{$consignee->id}}">{{$consignee->nick_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- <input type="hidden" name="consignee_id" id="consignee_id" /> -->
                                                <div class="container" style="padding-top:10px">
                                                    <div id="consignee_address">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Ship To</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" type="text" name="ship_to_id" id="select_ship_to">
                                                    <option value="">Select Ship To</option>
                                                    @foreach($consignees as $consignee)
                                                    <option value="{{$consignee->id}}">{{$consignee->nick_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- <input type="hidden" name="ship_to_id" id="ship_to_id" /> -->
                                                <div class="container" style="padding-top:10px">
                                                    <div id="ship_to_address">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="panel info-box panel-white">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="form-row mb-0">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Select Series</label>
                                                    <select id="selwarehouse" class="form-control" id="warehouse" name="warehouse" value="">
                                                        <option value="">Select Series</option>
                                                        @foreach($branchs as $branch)
                                                        <option value="{{$branch->consignment_note}}">{{$branch->consignment_note}}
                                                        </option>
                                                        @endforeach      
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Consignor's Invoice No.</label>
                                                    <input type="text" class="form-control" id="consignerinvoice" placeholder="Enter Consignor's Invoice No." value="" name="invoice_no">
                                                </div>
                                            </div>
                                            <div class="form-row mb-0">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Consignment No.</label>
                                                    <input type="text" class="form-control" id="consignment_no" name="consignment_no" value="" placeholder="C-94MHRG" readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Invoice Date</label>
                                                    <input type="date" class="form-control date-picker" id="date" placeholder="" value="05/12/2022" name="invoice_date">
                                                </div>
                                            </div>
                                            <div class="form-row mb-0">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Consignment Date</label>
                                                    <input type="date" class="form-control date-picker" id="consignDate" name="consignment_date" placeholder="" value="<?php echo date("d-m-Y")?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Value (INR)</label>
                                                    <!-- <span class="input-group-addon">INR</span> -->
                                                    <input type="text" class="form-control" id="invoice_amount" placeholder="Enter Value in INR" value="" name="invoice_amount">
                                                </div>
                                            </div>
                                            <div class="form-row mb-0">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Dispatch From</label>
                                                    <input type="text" class="form-control" id="dispatch"
                                                    name="dispatch_form" value="" placeholder="" readonly>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleFormControlInput2">Vehicle No.</label>
                                                    <select class="js-states form-control vehicle" id="vehicle_no" value="" name="vehicle_no" tabindex="-1" style="width: 100%">
                                                        <option value="">Select vehicle no</option>
                                                        @foreach($vehicles as $vehicle)
                                                        <option value="{{$vehicle->id}}">{{$vehicle->regn_no}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Row -->
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <div class="col-sm-12">
                                            <table id="items_table" class="table table-striped primary-items">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th width="20%">Description</th>
                                                        <th width="10%">Mode of Packing</th>
                                                        <th width="10%">Quantity</th>
                                                        <th width="10%">Net Weight</th>
                                                        <th width="10%">Gross Weight</th>
                                                        <th width="10%">Freight</th>
                                                        <th width="15%">Payment Terms</th>
                                                        <th width="10%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><div class="srno">1</div></td>
                                                        <td>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control sel1" id="description-1" value="Pesticide" name="data[1][description]" list="json-datalist" onkeyup="showResult(this.value)">
                                                            <datalist id="json-datalist"></datalist>
                                                        </div>
                                                        </td>
                                                        <td><div class="form-group">
                                                            <input type="text" class="form-control mode" id="mode-1" value="Case/s" name="data[1][packing_type]">
                                                        </div></td>
                                                        <td> <input type="number" class="form-control qnt" value="" name="data[1][quantity]"></td>
                                                        <td> <input type="number" class="form-control net" value="" name="data[1][weight]"></td>
                                                        <td> <input type="number" class="form-control gross" value="" name="data[1][gross_weight]"></td>
                                                        <td> <input type="text" class="form-control frei" value="" name="data[1][freight]"></td>
                                                        <td>
                                                            <select class="form-control term" name="data[1][payment_type]">
                                                                <option value=""></option>
                                                                <option value="To be Billed">To be Billed</option>
                                                                <option value="To Pay">To Pay</option>
                                                                <option value="Paid">Paid</option>
                                                            </select>
                                                        </td>

                                                        <td> <button type="button" class="btn btn-default btn-rounded insert-more"> + </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table id="items_table2" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="20%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="15%"></th>
                                                        <th width="10%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input type="hidden" name="total_quantity" id="total_quantity" value="">
                                                    <input type="hidden" name="total_weight" id="total_weight" value="">
                                                    <input type="hidden" name="total_gross_weight" id="total_gross_weight" value="">
                                                    <input type="hidden" name="total_freight" id="total_freight" value="">

                                                    <tr>
                                                        <th scope="row" colspan="3">TOTAL</th>
                                                        <td align="center"><span id="tot_qty"><?php echo "0";?></span></td>
                                                        <td align="center"><span id="tot_nt_wt"><?php echo "0";?></span> Kgs.</td>
                                                        <td align="center"><span id="tot_gt_wt"><?php echo "0";?></span> Kgs.</td>
                                                        <td align="center">INR <span id="tot_frt"><?php echo "0";?></span></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row mb-0">
                                    <div class="form-group col-md-4">
                                        <label for="exampleFormControlInput2">Transporter Name</label>
                                        <input type="text" class="form-control" id="Transporter" name="transporter_name"  value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="exampleFormControlInput2">Vehicle Type</label>
                                        <input type="text" class="form-control" id="vehicle_type" name="vehicle_type"  value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="exampleFormControlInput2">Purchase Price</label>
                                        <input type="text" class="form-control" id="purchase_price" name="purchase_price"  value="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- Row -->
                        
                        <button type="submit" class="mt-4 mb-4 btn btn-primary">Submit</button>
                        <a class="btn btn-primary" href="{{url($prefix.'/consignments') }}"> Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection