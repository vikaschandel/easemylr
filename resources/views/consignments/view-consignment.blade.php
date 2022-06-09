@extends('layouts.main')
@section('content')
<style>
hr {
  border: 1;
  clear:both;
  display:block;
  width: 96%;               
  background-color:#f1f2f3;
  height: 1px;
}
</style>
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <!-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">
                        <h5>Consignment Details</h5>
                    </div>
                </div> -->
                <div class="col-lg-12 col-12 layout-spacing">
                    <!-- row1 start -->
                    <div class="row">
                        <div class="col-ms-4">
                            <div class="panel panel-white full_height">
                                <div class="panel-heading">
                                    <div class="col-ms-8">
                                        <h4 class="panel-title">All Consignments</h4>
                                    </div>
                                    <!-- <?php //if (check_permissions('cn', 'add')){ ?>  -->
                                    <div class="col-ms-4">
                                        <a href="{{'create'}}"><button class="btn btn-success btn-addon m-b-sm">+ Add New</button></a>
                                    </div>
                                    <!-- <?php// } ?>  -->
                                </div>
                                <div class="panel-body"> 
                                    <div class="">
                                        <table id="consignment_table" class="table" style="width: 100%; cellspacing: 0;">
                                            <tbody>
                                            <?php
                                                $i= 0;
                                                if(count($getconsignment)>0) {
                                                    foreach ($getconsignment as $key => $consignment) {  
                                                ?> 
                                            <tr id="{{ $consignment->id }}" class="cons_list <?php if($i==0){ ?> selected <?php } ?>" >
                                            <td>
                                            <div>
                                                <div class="col-ms-<?php if ($consignment->total_freight == 0) { echo "12"; } else { echo "9";}?>" style="margin-bottom:10px">
                                                    <span style="color:#000000;"><strong> 
                                                        {{ $consignment->Consignee->nick_name ?? "" }}
                                                    </strong></span>
                                                </div>
                                                <div class="col-ms-3">
                                                    &#x20b9;  {{ $consignment->total_freight ?? "" }}
                                                </div>
                                                <div class="col-ms-6">
                                                    {{ $consignment->consignment_no ?? "" }}
                                                </div>
                                                <div class="col-ms-6"> 
                                                    {{ Helper::ShowFormatDate($consignment->consignment_date) ?? "" }}
                                                </div>
                                                <!--<div class="col-ms-3">  
                                                    {{ $consignment->supply ?? "" }}
                                                </div>-->
                                            </div>
                                            </td></tr>
                                                <?php
                                                $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="invoice col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                    <div class="ribbon"><span>Cancelled</span></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h1 style="font-size:22px;" class="m-b-md"><b>Eternity Forwarders Private Limited.</b></h1>
                                                @foreach($branch_add as $value)
                                                <address id="warehouse_address">
                                                    {{$value->address}}
                                                    {{$value->district}} - {{$value->postal_code}}
                                                    GST No. : {{$value->gst_number}}<br>
                                                    Email : {{$value->email}}<br>
                                                    Phone No. : {{$value->phone}}
                                                </address>
                                                @endforeach
                                                <hr>
                                                <table class="custom_table">
                                                    <tr>
                                                        <td><strong>Consignment No.</strong></td>
                                                        <td><span id="cons_no">SOJ/18-19/0001</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Consignment Date</strong></td>
                                                        <td><span id="cons_date">21.09.2018</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Dispatch From</strong></td>
                                                        <td><span id="dispatch">Jaipur</span></td>
                                                    </tr>
                                                        <td><strong>Invoice No.</strong></td>
                                                        <td><span id="cons_invoice_no">123456789</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Invoice Date</strong></td>
                                                        <td><span id="invoice_date">25.10.2018</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Value</strong></td>
                                                        <td>INR <span id="invoice_amount">1431254</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Vehicle No.</strong></td>
                                                        <td><span id="vehicle_no">RJ148G TEMP 83737</span></td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td><strong>Driver</strong></td>
                                                        <td><span id="driver_name">Rajesh Kumar</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Driver No.</strong></td>
                                                        <td><span id="driver_no">9876543210</span></td>
                                                    </tr> -->
                                                </table>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <!--<img height="100px" src="<?php// echo $path;?>/assets/images/eternity_logo.JPG"/>-->
                                                <div style="min-height:150px"></div>
                                                <h2>CONSIGNMENT NOTE</h2>
                                                <br>
                                                <img id="bar_code" height="100px" src=""/>
                                            </div>
                                        </div><!--row-->
                                        <div class="row">
                                            <!-- <div class="col-mo-12"> -->
                                            <hr>
                                            <div class="col-md-4">
                                                <table class="custom_table" width="100%">
                                                    <tr>
                                                        <td><strong>CONSIGNOR NAME & ADDRESS</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span id="consignerAddress">Melbourne, Australia<br>P: (123) 456-7890</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-4">
                                                <table class="custom_table" width="100%">
                                                    <tr>
                                                        <td><strong>CONSIGNEE NAME & ADDRESS</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span id="consigneeAddress">Melbourne, Australia<br>P: (123) 456-7890</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-4">
                                                <table class="custom_table" width="100%">
                                                    <tr>
                                                        <td><strong>SHIP TO NAME & ADDRESS</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span id="ship_to_Address">Melbourne, Australia<br>P: (123) 456-7890</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <hr>
                                            <!-- </div> -->
                                            
                                            <div class="col-md-12">
                                                <table id="items_table"  class="table table-striped" BORDER CELLSPACING=0>
                                                    <thead>
                                                        <tr class="line_items">
                                                            <th width="5%" style="border:solid 1px #A9A9A9;border-style:solid; font-family:Open Sans,sans-serif; padding:5px;">Sr. No.</th>
                                                            <th width="15%" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;">Description</th>
                                                            <th width="14%" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;">Quantity</th>
                                                            <th width="15%" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;">Net Weight</th>
                                                            <th width="17%" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;">Gross Weight</th>
                                                            <th width="15%" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;">Freight</th>
                                                            <th width="19%" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;">Payment Terms</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="line_items">
                                                            <td id="first_data"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="total_items">
                                                            <td colspan="2" style="border:solid 1px #A9A9A9;border-style:solid; font-family:Open Sans,sans-serif; padding:5px;"><strong>TOTAL</strong></td>
                                                            <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="qty" class="no-m"></span></strong></td>
                                                            <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="net_weight" class="no-m"></span> Kgs.</strong></td>
                                                            <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="gross_weight" class="no-m"></span> Kgs.</strong></td>
                                                            <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"><strong><span id="currency">INR </span><span id="tot_amt"></span></strong></td>
                                                            <td style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif; padding:5px;"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <p style="float:right" id="tot_amt_words"></p>
                                            </div>
                                            <div class="col-md-8">
                                                <!--<h3>Terms & Conditions</h3>
                                                <p id="termsConditions">Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla.</p>
                                                <hr>-->
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <div class="col-md-5">
                                                <br>
                                                <br>
                                                <h3>Receiver's Signature</h3>
                                                <p>Received the goods mentioned above in good condition.</p>
                                                <br>
                                                </div>
                                                <div class="col-md-7">
                                                <br>
                                                <br>
                                                <h4>For Eternity Eternity Forwarders Pvt. Ltd.</h4>
                                                <br>
                                                </div>
                                                
                                                <!--<img src="assets/images/signature.png" height="150" class="m-t-lg" alt="">-->
                                            </div>
                                            <div class="col-md-4">
                                                <!--<div class="text-center">
                                                    <h4 class="no-m m-t-sm">Total Gross Weight</h4>
                                                    <h2 id="gross_weight" class="no-m">240</h2>
                                                    <hr>
                                                    <h4 class="no-m m-t-md text-success">Total Amount</h4>
                                                    <h1 class="no-m text-success">&#x20b9; <span id="tot_amt">7522</span></h1>
                                                    <p id="tot_amt_words"></p>
                                                </div>-->
                                                <div class="text-right">
                                                <br>
                                                <br>
                                                <!-- <button id="get_pdf" type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button> -->
                                                <button class="btn btn-default" type="button"><a id="printcon" data-printtoid="1" href="{{url($prefix.'/consignments/')}}"><i class="fa fa-print"></i>Print</a></button>
                                                <button class="btn btn-default" type="button"><a id="printshipcon" data-printtoid="2" href="{{url($prefix.'/consignments/')}}"><i class="fa fa-print"></i>Print (with Ship To)</a></button>
                                                
                                                <!-- <button id="get_pdf_ship_to" type="button" class="btn btn-default"><i class="fa fa-print"></i> Print (with Ship To)</button> -->
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </div>
                                </div>
                            </div>

                            <form id="submit_for_pdf" action="pdf.php" method="POST">
                                <input type="hidden" id="form_id" name="id" value="">
                                <input type="hidden" id="form_cons_no" name="cons_no" value="">
                                <input type="hidden" id="form_cons_date" name="cons_date" value="">
                                <input type="hidden" id="form_dispatch" name="dispatch" value="">
                                <input type="hidden" id="form_supply" name="supply" value="">
                                <input type="hidden" id="form_cons_invoice_no" name="cons_invoice_no" value="">
                                <input type="hidden" id="form_vehicle_no" name="vehicle_no" value="">
                                <!-- <input type="hidden" id="form_driver_name" name="driver_name" value=""> -->
                                <!-- <input type="hidden" id="form_driver_no" name="driver_no" value=""> -->
                                <input type="hidden" id="form_invoice_amount" name="invoice_amount" value="">
                                <input type="hidden" id="form_invoice_date" name="invoice_date" value="">
                                <input type="hidden" id="form_bar_code" name="bar_code" value="">
                                <input type="hidden" id="form_consignerAddress" name="consignerAddress" value="">
                                <input type="hidden" id="form_consigneeAddress" name="consigneeAddress" value="">
                                <input type="hidden" id="form_ship_to_Address" name="ship_to_Address" value="">
                                <input type="hidden" id="form_items_table" name="items_table" value="">
                                <input type="hidden" id="form_termsConditions" name="termsConditions" value="">
                                <input type="hidden" id="form_gross_weight" name="gross_weight" value="">
                                <input type="hidden" id="form_tot_amt" name="tot_amt" value="">
                                <input type="hidden" id="form_tot_amt_words" name="tot_amt_words" value="">
                                <input type="hidden" id="form_address" name="w_address" value="">
                                <input type="hidden" id="form_print_ship_to" name="print_ship_to" value=1>
                            </form>
                        
                        </div><!-- Consignment Note -->
                    </div>
                    <!-- end row1 -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

<script>
    $("#menu_notes").addClass("active open");
    $("#menu_notes_2").addClass("active");
		
    $(document).ready(function() {
        var hrefval = $('#printcon').attr('href');
        var printtoid = $('#printcon').attr('data-printtoid');

        var hrefshipval = $('#printshipcon').attr('href');
        var printshiptoid = $('#printshipcon').attr('data-printtoid');
        
        $('#consignment_table tr').removeClass("selected");
        //  var php_id = "<?php if (isset($_GET['id'])) {echo $_GET['id'];} else {echo 'None';}?>";

        var url = $(location).attr("href");
        var php_id = url.split('/')[5];
        
            $('#consignment_table tr[id=php_id]').addClass('selected');
            
            var con_href = ''+hrefval+'/'+php_id+'/print-view/1';
            var gethref = $('#printcon').attr("href",con_href);

            var con_shiphref = ''+hrefshipval+'/'+php_id+'/print-view/2';
            var getshiphref = $('#printshipcon').attr("href",con_shiphref);
            
            $.ajax({
                type:'post',
                url: 'get-consign-details',
                data: { id: php_id, printtoid: printtoid, printshiptoid: printshiptoid },
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(response){
                    var data = response.data;
                    console.log(data);
                    var consigneradd = '<strong>'+data.consigner_detail.nick_name+'</strong><br>'+data.consigner_detail.address+',<br>'+data.consigner_detail.district+',<br>'+data.consigner_detail.city+' - '+data.consigner_detail.postal_code+',<strong><br>GST No. : </strong>'+data.consigner_detail.gst_number+'';

                    var consigneeadd = '<strong>'+data.consignee_detail.nick_name+'</strong><br>'+data.consignee_detail.address_line1+' '+data.consignee_detail.address_line2+' '+data.consignee_detail.address_line3+',<br>'+data.consignee_detail.district+',<br>'+data.consignee_detail.city+' - '+data.consignee_detail.postal_code+',<strong><br>GST No. : </strong>'+data.consignee_detail.gst_number+'';

                    var shiptoadd = '<strong>'+data.consignee_detail.nick_name+'</strong><br>'+data.consignee_detail.address_line1+' '+data.consignee_detail.address_line2+' '+data.consignee_detail.address_line3+',<br>'+data.consignee_detail.district+',<br>'+data.consignee_detail.city+' - '+data.consignee_detail.postal_code+',<strong><br>GST No. : </strong>'+data.consignee_detail.gst_number+'';

                    $('#cons_no').html(data.consignment_no);
                    
                    var dateAr = data.consignment_date.split('-');
                    var consDate = dateAr[2] + '.' + dateAr[1] + '.' + dateAr[0];
                    $('#cons_date').html(consDate);
                    $('#dispatch').html(data.consigner_detail.city);
                    $('#cons_invoice_no').html(data.invoice_no);
                    $('#vehicle_no').html(data.vehicle_detail.regn_no);
                    // $('#driver_name').html(data.driver_name);
                    // $('#driver_no').html(data.driver_mobile_no);
                    $('#invoice_amount').html(data.invoice_amount);

                    var dateInvc = data.invoice_date.split('-');
                    var invoiceDate = dateInvc[2] + '.' + dateInvc[1] + '.' + dateInvc[0];
                    $('#invoice_date').html(invoiceDate);
                    $("#bar_code").attr("src",data.bar_code);
                    $('#consignerAddress').html(consigneradd);
                    $('#consigneeAddress').html(consigneeadd);
                    $('#ship_to_Address').html(shiptoadd);
                    // $('#warehouse_address').html(data.w_address);
                    
                    // /'.$consignment->id.'/print-view

                    var cn_status = data.status;
                    if (cn_status == '0' || cn_status == null) {
                        $('.ribbon').css("display", "block");
                        $('#get_pdf').hide();
                        $('#get_pdf_ship_to').hide();
                        
                    } else {
                        $('.ribbon').css("display", "none");
                        $('#get_pdf').show();
                        $('#get_pdf_ship_to').show();
                    }
                    var item_nos = data.consignment_items;
                    var w = item_nos.length;
                    var tds = '';
                    for (var i = 0; i<w; i++){
                        c  = i + 1;
                        var items_array = item_nos;
                        tds += '<tr class="line_items">';
                        tds += '<td class="line_items" id="first_data" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px;">'+c+'</td>';
                        tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['description']+'</td>';
                        //tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:3px; font-family:Open Sans,sans-serif">'++'</td>';
                        tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['packing_type']+' '+items_array[i]['quantity']+'</td>';
                        tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['weight']+' Kgs.</td>';
                        tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['gross_weight']+' Kgs.</td>';
                        tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">INR '+items_array[i]['freight']+'</td>';
                        tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['payment_type']+'</td>';
                        tds += '</tr>';
                    }  
                    $("td#first_data").parent().parent().html(tds);
                    $('#termsConditions').html(data['terms_conditions']);
                    $('#qty').html(data.total_quantity);
                    $('#gross_weight').html(data.total_gross_weight);
                    $('#net_weight').html(data.total_weight);
                    $('#tot_amt').html(data.total_freight);
                    if (data.total_freight != 0){
                        var tot_amt_words = data.total_freight;
                        $('#tot_amt_words').html(tot_amt_words);
                        $('#currency').html('INR ');
                    } else {
                        $('#tot_amt_words').html('');
                        $('#currency').html('');
                    }
                }
            });
        // }

    });
    //End ready function

    var table = $('#consignment_table');    

    table.on('click', 'tr', function () {
        $('#printcon').attr('href', '');
        $('#printshipcon').attr('href', '');

        var printtoid = $('#printcon').attr('data-printtoid');
        var printshiptoid = $('#printshipcon').attr('data-printtoid');

    //    alert(printtoid);
        var baseurl = window.location.origin
        var url = $(location).attr("href");
        var url1 = url.split('/')[3];
        var url2 = url.split('/')[4];

        $('#consignment_table tr').removeClass("selected");
        $(this).addClass('selected');
        var id = $(this).closest('tr').attr('id');

        var con_href = ''+baseurl+'/'+url1+'/'+url2+'/'+id+'/print-view/1';
        var con_shiphref = ''+baseurl+'/'+url1+'/'+url2+'/'+id+'/print-view/2';
        var gethref = $('#printcon').attr("href",con_href);
        var getshiphref = $('#printshipcon').attr("href",con_shiphref);

        $.ajax({
            type:'post',
            url: 'get-consign-details',
            data: { id: id, printtoid: printtoid, printshiptoid: printshiptoid },
            headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            dataType: "json",
            success: function(response){
                var data = response.data;
                console.log(data);
                $('#cons_no').html(data.consignment_no);

                var dateAr = data.consignment_date.split('-');
                var consDate = dateAr[2] + '.' + dateAr[1] + '.' + dateAr[0];
                $('#cons_date').html(consDate);
                $('#dispatch').html(data.consigner_detail.city);
                $('#cons_invoice_no').html(data.invoice_no);
                $('#vehicle_no').html(data.vehicle_detail.regn_no);
                // $('#driver_name').html(data.driver_name);
                // $('#driver_no').html(data.driver_mobile_no);
                $('#invoice_amount').html(data.invoice_amount);

                var dateInvc = data.invoice_date.split('-');
                var invcDate = dateInvc[2] + '.' + dateInvc[1] + '.' + dateInvc[0];
                $('#invoice_date').html(invcDate);
                $("#bar_code").attr("src",data.bar_code);
                $('#consignerAddress').html(data.consigner);
                $('#consigneeAddress').html(data.consignee);
                $('#ship_to_Address').html(data.ship_to);
                // $('#warehouse_address').html(data.w_address);
                var cn_status = data.status;
                if (cn_status == '0' || cn_status == null){
                    $('.ribbon').css("display", "block");
                    $('#get_pdf').hide();
                    $('#get_pdf_ship_to').hide();
                } else {
                    $('.ribbon').css("display", "none");
                    $('#get_pdf').show();
                    $('#get_pdf_ship_to').show();
                }
                // var item_nos = JSON.parse(data['line_items']);
                var item_nos = data.consignment_items;
                var w = item_nos.length;
                var tds = '';
                for (var i = 0; i<w; i++){
                    // var items_array = item_nos[i][0].split(",");
                    c  = i + 1;
                    var items_array = item_nos;

                    tds += '<tr class="line_items" style="border-bottom:solid 1px #A9A9A9;border-style:solid; padding:5px;">';
                    tds += '<td class="line_items" id="first_data" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px;">'+c+'</td>';
                    tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['description']+'</td>';
                    //tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[2]+'</td>';
                    tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['packing_type']+' '+items_array[i]['quantity']+'</td>';
                    tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['weight']+' Kgs.</td>';
                    tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['gross_weight']+' Kgs.</td>';
                    tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">INR '+items_array[i]['freight']+'</td>';
                    tds += '<td class="line_items" style="border:solid 1px #A9A9A9;border-style:solid; padding:5px; font-family:Open Sans,sans-serif">'+items_array[i]['payment_type']+'</td>';
                    tds += '</tr>';
                }
                $("td#first_data").parent().parent().html(tds);
                $('#termsConditions').html(data['terms_conditions']);
                $('#qty').html(data.total_quantity);
                $('#gross_weight').html(data.total_gross_weight);
                $('#net_weight').html(data.total_weight);
                $('#tot_amt').html(data.total_freight);
                if (data.total_freight != 0){
                    var tot_amt_words = data.total_freight;
                    $('#tot_amt_words').html(tot_amt_words);
                    $('#currency').html('INR ');
                } else {
                    $('#tot_amt_words').html('');
                    $('#currency').html('');
                }
            }
        });
    });
    
    $('#get_pdf').click(function(){
        var id = $('#consignment_table tr.selected').attr('id');
        $('#form_id').val(id);
        $('#form_cons_no').val($('#cons_no').html());
        $('#form_cons_date').val($('#cons_date').html());
        $('#form_dispatch').val($('#dispatch').html());
        $('#form_supply').val($('#supply').html());
        $('#form_cons_invoice_no').val($('#cons_invoice_no').html());
        $('#form_vehicle_no').val($('#vehicle_no').html());
        // $('#form_driver_name').val($('#driver_name').html());
        // $('#form_driver_no').val($('#driver_no').html());
        $('#form_invoice_amount').val($('#invoice_amount').html());
        $('#form_invoice_date').val($('#invoice_date').html());
        $('#form_bar_code').val($("#bar_code").attr("src"));
        $('#form_consignerAddress').val($('#consignerAddress').html());
        $('#form_consigneeAddress').val($('#consigneeAddress').html());
        $('#form_ship_to_Address').val($('#ship_to_Address').html());
        $('#form_items_table').val($('#items_table').html());
        $('#form_termsConditions').val($('#termsConditions').html());
        $('#form_gross_weight').val($('#gross_weight').html());
        $('#form_tot_amt').val($('#tot_amt').html());
        $('#form_tot_amt_words').val($('#tot_amt_words').html());
        // $('#form_address').val($('#warehouse_address').html());
        $('#submit_for_pdf').submit();
    });
    
    $('#get_pdf_ship_to').click(function(){
        var id = $('#consignment_table tr.selected').attr('id');
        $('#form_id').val(id);
        $('#form_cons_no').val($('#cons_no').html());
        $('#form_cons_date').val($('#cons_date').html());
        $('#form_dispatch').val($('#dispatch').html());
        $('#form_supply').val($('#supply').html());
        $('#form_cons_invoice_no').val($('#cons_invoice_no').html());
        $('#form_vehicle_no').val($('#vehicle_no').html());
        // $('#form_driver_name').val($('#driver_name').html());
        // $('#form_driver_no').val($('#driver_no').html());
        $('#form_invoice_amount').val($('#invoice_amount').html());
        $('#form_invoice_date').val($('#invoice_date').html());
        $('#form_bar_code').val($("#bar_code").attr("src"));
        $('#form_consignerAddress').val($('#consignerAddress').html());
        $('#form_consigneeAddress').val($('#consigneeAddress').html());
        $('#form_ship_to_Address').val($('#ship_to_Address').html());
        $('#form_items_table').val($('#items_table').html());
        $('#form_termsConditions').val($('#termsConditions').html());
        $('#form_gross_weight').val($('#gross_weight').html());
        $('#form_tot_amt').val($('#tot_amt').html());
        $('#form_tot_amt_words').val($('#tot_amt_words').html());
        // $('#form_address').val($('#warehouse_address').html());
        $('#form_print_ship_to').val(2);
        $('#submit_for_pdf').submit();

    });
    
    var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
    var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

    function toWords (num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
        return 'Rupees '+str+ 'Only.';
    }
		
</script>
@endsection