@extends('layouts.main')
@section('content')
<style>
    .form-seteing {
        width: 224px;
         margin-top: 10px; 
        height: 29px;
        background-color: #f5f6f7;
        border: none;
    }
    .form-group label, label {
    font-size: 12px; 
    color: black;
    letter-spacing: 1px;
    font-weight: bold;
    }
    

    .table>thead>tr>th {

        background: white;

    }
    .table>thead>tr>th {

        padding: 10px 7px 6px 8px;

}
label.error{
    color: red;
    font-weight: bold;
}


   
    .seteing {
    width: 130px;
    
}
.sete{
    width: 170px;
    
}

   
</style>
<div class="layout-px-spacing">
    <div class="row layout-top-spacing" style="background-color: aliceblue;">
        <div class=" col-sm-12  layout-spacing">
        <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{$prefix.'/consignments'}}">Consignments</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Create Consignment</a></li>
                    </ol>
                </nav>
            </div>

            <form class="general_form" method="POST" action="{{url($prefix.'/consignments')}}" id="createconsignment"
                style="margin: auto; ">
                <div class="row">
                    <div class="col-sm-4">

                        <div class="panel info-box panel-white">
                            <div class="panel-body" style="padding: 10px;">

                                <div class="row con1 form-group" style="background: white; padding: 0px;">
                                    <div class=" col-sm-3" style="margin-top:3px;" >
                                        <label class=" control-label" style="font-weight: bold;">Select
                                            Consignor<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-9" style="margin-top:3px;" >
                                        <select id="select_consigner" class="basic form-seteing" type="text"
                                            name="consigner_id">
                                            <option value="">Select Consignor</option>
                                            @foreach($consigners as $consigner)
                                            <option value="{{$consigner->id}}">{{$consigner->nick_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        

                                    </div>
                                    <div class="container" style="padding-top:10px">
                                        <div id="consigner_address">
                                            <!-- <strong>FRONTIER AGROTECH PRIVATE LIMITED </strong><br/>KHASRA NO-390, RELIANCE ROAD <br/>GRAM BHOVAPUR <br/>HAPUR-245304 <br/><strong>GST No. : </strong>09AACCF3772B1ZU<br/><strong>Phone No. : </strong>9115115612 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class=" col-sm-4">
                        <div class="panel info-box panel-white">
                            <div class="panel-body" style="padding: 10px;">
                                <div class="row con1 form-group" style="background: white; ">
                                    <div class=" col-sm-3" >
                                        <label class=" control-label" style="font-weight: bold;">Select
                                            Consignee<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-9" >
                                        <select class="basic form-seteing" type="text" name="consignee_id"
                                            id="select_consignee">
                                            <option value="">Select Consignee</option>
                                            
                                        </select>

                                    </div>
                                    <!-- <input type="hidden" name="consignee_id" id="consignee_id" /> -->
                                    <div class="container" style="padding-top:10px">
                                        <div id="consignee_address">

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-sm-4">
                        <div class="panel info-box panel-white">
                            <div class="panel-body" style="padding: 10px;">
                                <div class="row con1 form-group" style="background: white; ">
                                    <div class=" col-sm-3" style="margin-top:2px;">
                                        <label class=" control-label" style="font-weight: bold;">Ship To<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-9" style="margin-top:2px;">
                                        <select class="basic form-seteing" type="text" name="ship_to_id"
                                            id="select_ship_to">
                                            <option value="">Select Ship To</option>
                                            <!-- @foreach($consignees as $consignee)
                                            <option value="{{$consignee->id}}">{{$consignee->nick_name}}
                                            </option>
                                            @endforeach -->
                                        </select>

                                    </div>
                                    <!-- <input type="hidden" name="consignee_id" id="consignee_id" /> -->
                                    <div class="container" style="padding-top:11px">
                                        <div id="ship_to_address">

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row -->
                <div class="row" style=" padding: 11px;" style="background:#c4c9d4;">
                    <div class=" col-sm-6">

                        <div class="panel info-box panel-white">
                            <div class="panel-body">

                                <div class="row con1 form-group" style="background: white; height: 188px; ">
                                    <div class=" col-sm-12" style="margin-top: 7px;">
                                        <?php $auth_user = Auth::user();
                                        if($auth_user->role_id ==1){ ?>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Select Series</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <select id="selwarehouse" class="form-seteing" id="warehouse" name="warehouse" value="" disabled>
                                                    <option value="">Select Series</option>
                                                    @foreach($locations as $location)
                                                    <option value="{{$location->consignment_no}}">
                                                        {{$location->consignment_no}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Consignment No.</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <input type="text" class="form-seteing" id="consignment_no"
                                                    name="consignment_no" value="{{$consignmentno ?? ''}}" placeholder="C-94MHRG" readonly style="border:none;">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Consignment Date</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <input type="date" class="form-seteing date-picker" id="consignDate" name="consignment_date" placeholder="" value="<?php echo date('d-m-Y'); ?>">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Dispatch From</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <input type="text" class="form-seteing" id="dispatch" name="dispatch_form" value="" placeholder="" readonly
                                                    style="border:none;">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- .////////////////////////////////////////////// -->
                    <div class=" col-sm-6" style="margin-bottom:10px;">

                        <div class="panel info-box panel-white">
                            <div class="panel-body">

                                <div class="row con1 form-group" style="background: white; height: 188px;">
                                    <div class=" col-sm-12" style="margin-top:2px;">
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:15px;">
                                                <label for="exampleFormControlInput2">Consignor's Invoice
                                                    No.<span class="text-danger">*</span></label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <input type="text" class="form-seteing" id="consignerinvoice"
                                                    placeholder="Enter Consignor's Invoice No." value=""
                                                    name="invoice_no">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Invoice Date</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <input type="date" class="form-seteing date-picker" id="date"
                                                    placeholder="" value="05/12/2022" name="invoice_date">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Value</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">

                                                <input type="text" class="form-seteing" id="invoice_amount"
                                                    placeholder="Enter Value in INR" value="" name="invoice_amount">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-sm-4" style="margin-top:10px;">
                                                <label for="exampleFormControlInput2">Vehicle No.</label>
                                            </div>
                                            <div class=" col-sm-8" style="margin-top:2px;">
                                                <select class="js-states vehicle form-seteing" id="vehicle_no" name="vehicle_id" tabindex="-1">
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

                    </div>

                </div><!-- Row -->
                <div class="row" >
                    <div class="col-sm-12" >
                        <div style="overflow-x:auto; background-color: white;">
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
                                        <td>
                                            <div class="srno">1</div>
                                        </td>
                                        <td>
                                            
                                                <input type="text" class="seteing sel1" id="description-1"
                                                    value="Pesticide" name="data[1][description]" list="json-datalist"
                                                    onkeyup="showResult(this.value)">
                                                <datalist id="json-datalist"></datalist>
                                        
                                        </td>
                                        <td>
                                            
                                                <input type="text" class="seteing mode" id="mode-1" value="Case/s"
                                                    name="data[1][packing_type]">
                                            
                                        </td>
                                        <td> <input type="number" class="seteing qnt" value=""
                                                name="data[1][quantity]"></td>
                                        <td> <input type="number" class="seteing net" value=""
                                                name="data[1][weight]"></td>
                                        <td> <input type="number" class="seteing gross" value=""
                                                name="data[1][gross_weight]"></td>
                                        <td> <input type="text" class="seteing frei" value=""
                                                name="data[1][freight]"></td>
                                        <td>
                                            <select class="seteing term" name="data[1][payment_type]">
                                                <option value=""></option>
                                                <option value="To be Billed">To be Billed
                                                </option>
                                                <option value="To Pay">To Pay</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>

                                        <td> <button type="button" class="btn btn-default btn-rounded insert-more">
                                                + </button>
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
                                        <td align="center"><span id="tot_qty">
                                                <?php echo "0";?>
                                            </span></td>
                                        <td align="center"><span id="tot_nt_wt">
                                                <?php echo "0";?>
                                            </span> Kgs.</td>
                                        <td align="center"><span id="tot_gt_wt">
                                                <?php echo "0";?>
                                            </span> Kgs.</td>
                                        <td align="center">INR <span id="tot_frt">
                                                <?php echo "0";?>
                                            </span></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 15px;">
                    <div class=" col-sm-1">
                        <label for="exampleFormControlInput2">Transporter <br>Name<span class="text-danger">*</span></label>
                    </div>
                    <div class=" col-sm-2">
                        <input type="text" class="sete" id="Transporter" name="transporter_name" value="">
                    </div>
                    <div class=" col-sm-1">
                        <label for="exampleFormControlInput2">Vehicle Type<span class="text-danger">*</span></label>
                    </div>
                    <div class=" col-sm-2">
                        
                        <select class="basic sete" id="vehicle_type" name="vehicle_type"
                            tabindex="-1">
                            <option value="">Select vehicle type</option>
                            @foreach($vehicletypes as $vehicle)
                            <option value="{{$vehicle->id}}">{{$vehicle->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-sm-1">
                        <label for="exampleFormControlInput2">Driver Name</label>
                    </div>
                    <div class=" col-sm-2">
                        <select class="basic sete" id="driver_id" name="driver_id" tabindex="-1">
                            <option value="">Select driver</option>
                            @foreach($drivers as $driver)
                            <option value="{{$driver->id}}">{{ucfirst($driver->name) ?? '-'}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-sm-1">
                        <label for="exampleFormControlInput2">Purchase Price</label>
                    </div>
                    <div class=" col-sm-2">
                        
                        <input type="text" class="sete" id="purchase_price" name="purchase_price" value="" maxlength="9">
                    </div>
                    
                    <div class=" col-sm-3">
                        <button type="submit" class="mt-4 mb-4 btn btn-primary">Submit</button>
                        <a class="btn btn-primary" href="{{url($prefix.'/consignments') }}"> Back</a>
                    </div>
                </div><!-- Row -->

                
            </form>


        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $(function() {
        $('.basic').selectpicker();
    });
    // var ss = $(".basic").select2({
    //     tags: true,
    // });

      // add consignment date
    $('#consignDate').val(new Date().toJSON().slice(0, 10));
    
    function showResult(str) {
        if (str.length==0) {
            $( ".search-suggestions" ).empty();
            $( ".search-suggestions" ).css('border', '0px');
        } else if (str.length > 0) {
            $( ".search-suggestions" ).css('border', 'solid 1px #f6f6f6');
            var options = '';
            options = "<option value='Seeds'>";
            options += "<option value='Chemicals'>";
            options += "<option value='PGR'>";
            options += "<option value='Fertilizer'>";
            options += "<option value='Pesticides'>";
            $('#json-datalist').html(options);
        }
    }

</script>
@endsection