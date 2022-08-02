@extends('layouts.main')
@section('content')
<style>
        .dt--top-section {
    margin:none;
}
div.relative {
    position: absolute;
    left: 110px;
    top: 24px;
    z-index: 1;
    width: 145px;
    height: 38px;
}
/* .table > tbody > tr > td {
    color: #4361ee;
} */
.dt-buttons .dt-button {
    width: 83px;
    height: 38px;
    font-size: 13px;
}
.btn-group > .btn, .btn-group .btn {
    padding: 0px 0px;
    padding: 10px;
}
.btn {
   
    font-size: 10px;
    }
    .select2-results__options {
    list-style: none;
    margin: 0;
    padding: 0;
    height: 160px;
    /* scroll-margin: 38px; */
    overflow: auto;
}
    </style>
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<!-- END PAGE LEVEL CUSTOM STYLES -->  
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">

    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Consignments</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Transaction Sheet</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        @csrf
                        <table id="usertable" class="table table-hover get-datatable" style="width:100%">
                            <div class="btn-group relative">
                                <!-- <a href="{{'consignments/create'}}" class="btn btn-primary pull-right" style="font-size: 13px; padding: 6px 0px;">Create Consignment</a> -->
                            </div>
                            <thead>
                                <tr>
                                    <th>DRS NO</th>
                                    <th>DRS Date</th>
                                    <th>Vehicle No</th>
                                    <th>Driver Name</th>
                                    <th>Driver Number</th>
                                    <th>Total LR</th>
                                    <th>Action</th>
                                    <th>DRS Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction as $trns)
                                <?php  $creation = date('d-m-Y',strtotime($trns->created_at));    ?>
                              <tr>
                                
                                <td>DRS-{{$trns->drs_no}}</td>
                                <td>{{$creation}}</td>
                                <td>{{$trns->vehicle_no}}</td>
                                <td>{{$trns->driver_name}}</td>
                                <td>{{$trns->driver_no}}</td>
                                <td>{{ Helper::getCountDrs($trns->drs_no) ?? "" }}</td>
                                <?php 
                                if($trns->status == 0){?>
                                 <td><label class="badge badge-dark">Cancelled</label></td>
                                 <?php }else{?>
                                <td>
                               
                              <?php  if(empty($trns->vehicle_no)){ ?>
                                    <button type="button" class="btn btn-warning view-sheet" value="{{$trns->drs_no}}" style="margin-right:4px;">Draft</button> 
                                   <button type="button" class="btn btn-danger draft-sheet" value="{{$trns->drs_no}}" style="margin-right:4px;">Save</button> 
                                   <?php } ?>
                                   <?php if(!empty($trns->vehicle_no)){?>
                                    <a class="btn btn-primary" href="{{url($prefix.'/print-transaction/'.$trns->drs_no)}}" role="button" >Print</a>
                                    <?php } ?>
                                    <?php  
                                    if($trns->delivery_status == 'Unassigned'){?>
                                    <button type="button" class="btn btn-danger" value="{{$trns->drs_no}}" style="margin-right:4px;">Unassigned</button>
                                    <?php }elseif($trns->delivery_status == 'Assigned'){ ?>
                                        <button type="button" class="btn btn-warning" value="{{$trns->drs_no}}" style="margin-right:4px;">Assigned</button>
                                    <?php }elseif($trns->delivery_status == 'Started'){ ?>
                                        <button type="button" class="btn btn-success" value="{{$trns->drs_no}}" style="margin-right:4px;"> Started</button>
                                        <?php }elseif($trns->delivery_status == 'Successful'){ ?>
                                        <button type="button" class="btn btn-success" value="{{$trns->drs_no}}" style="margin-right:4px;"> Successful</button>
                                        <?php } ?>
                                      </td>
                                        <td> <a class="drs_cancel btn btn-success" drs-no = "{{$trns->drs_no}}" data-text="consignment" data-status = "0" data-action = "<?php echo URL::current();?>"><span><i class="fa fa-check-circle-o"></i> Active</span></a></td>
                                <?php } ?>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('models.transaction-sheet')
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script>
    //////////////////////////////////////////
    $(document).ready(function() {

        jQuery(function() {
            $('.my-select2').each(function() {
                $(this).select2({
                    theme: "bootstrap-5",
                    dropdownParent: $(this).parent(), // fix select2 search input focus bug
                })
            })

            // fix select2 bootstrap modal scroll bug
            $(document).on('select2:close', '.my-select2', function(e) {
                var evt = "scroll.select2"
                $(e.target).parents().off(evt)
                $(window).off(evt)
            })
        })
        
            $('#sheet').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            } );
        } );
        $(document).on('click','.view-sheet', function(){
            var cat_id = $(this).val();
            //alert(cat_id ); 
            $('#opm').modal('show');
            //   return false;
            $.ajax({
                type: "GET",
                url: "view-transactionSheet/"+cat_id,
                data: {cat_id:cat_id},
                // dataType: "json",
                beforeSend:                      //reinitialize Datatables
                function(){   
                    $('#sheet').dataTable().fnClearTable();             
                    $('#sheet').dataTable().fnDestroy();
                    $("#sss").empty();          
                    //$("#total").empty();  
                    $("#ppp").empty();  
                    $("#nnn").empty();   
                    $("#drsdate").empty();  
                },
                success: function(data){
                    var re = jQuery.parseJSON(data)
                    //console.log(re.fetch); return false;
                   var totalBox = 0;
                   var totalweight = 0;
                    $.each(re.fetch, function(index, value) { 
                        var alldata = value;  
                        totalBox += parseInt(value.total_quantity);
                        totalweight += parseInt(value.total_weight);
                        
                        $('#sheet tbody').append("<tr id="+value.id+"><td>" + value.consignment_no + "</td><td>" + value.consignment_date + "</td><td>" + value.consignee_id + "</td><td>"+ value.city + "</td><td>"+ value.pincode + "</td><td>"+ value.total_quantity + "</td><td>"+ value.total_weight + "</td></tr>");
                                    
                    });

                    // alert(totalBox);
                    var rowCount = $("#sheet tbody tr").length; 
                    $("#total_box").html("No Of Boxes: "+totalBox);
                    $("#totalweight").html("Net Weight: "+totalweight);
                    $("#total").html(rowCount);
				}
                
			});
			
		});
        /////////////////////////////////Draft Sheet//////////////////////////////////////////////
        $(document).on('click','.draft-sheet', function(){
            
                    var draft_id = $(this).val(); 
                    $('#save-draft').modal('show');
                    //alert(draft_id);
                    $.ajax({
                        type: "GET",
                        url: "view-draftSheet/"+draft_id, 
                        data: {draft_id:draft_id},
                        // dataType: "json",
                        beforeSend:                      //reinitialize Datatables
                       function(){   
                        $('#save-DraftSheet').dataTable().fnClearTable();             
                        $('#save-DraftSheet').dataTable().fnDestroy();
                        $("#total_boxes").empty();          
                         $("#totalweights").empty();  
                         $("#totallr").empty();  
                        // $("#nnn").empty();    
                        // $("#drsdate").empty();  
                 },
                        success: function(data){
                        var re = jQuery.parseJSON(data)
                    //console.log(re.fetch); return false;
                    var consignmentID = [];
                    var totalBoxes = 0;
                    var totalweights = 0;
                    $.each(re.fetch, function(index, value) {

                        var alldata = value;  
                        //console.log(alldata);
                        //alert(value.edd);

                        consignmentID.push(alldata.consignment_no);
                        totalBoxes += parseInt(value.total_quantity);
                        totalweights += parseInt(value.total_weight);
                        //alert(alldata.consignment_detail.edd); return false;


                        $('#save-DraftSheet tbody').append("<tr id="+value.id+"><td>" + value.consignment_no + "</td><td>" + value.consignment_date + "</td><td>" + value.consignee_id + "</td><td>"+ value.city + "</td><td>"+ value.pincode + "</td><td>"+ value.total_quantity + "</td><td>"+ value.total_weight + "</td><td><input type='date' name='edd[]' data-id="+ value.consignment_no +" class='new_edd' value='"+ value.edd+ "'></td></tr>");      
                    });
                     // alert(consignmentID);
                      $("#transaction_id").val(consignmentID);
                    var rowCount = $("#save-DraftSheet tbody tr").length;
                    
                    $("#total_boxes").append("No Of Boxes: "+totalBoxes);
                    $("#totalweights").append("Net Weight: "+totalweights);
                    $("#totallr").append(rowCount);

                    showLibrary();

				} 
			});
		});

        //////////////////////////////
                $('#suffle').sortable({
                placeholder : "ui-state-highlight",
                update : function(event, ui)
                {
                var page_id_array = new Array();
                $('#suffle tr').each(function(){
                page_id_array.push($(this).attr('id'));
                });
               //alert(page_id_array);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"update-suffle",
                method:"POST",
                data:{page_id_array:page_id_array, action:'update'},
                success:function()
                {
                load_data();
                }
            })
            }
            });
///////////////
        function printData() {
        var divToPrint = document.getElementById("www");
        newWin = window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
        }

   $('#print').on('click', function() {
   printData();
 
})
////////////////////////////
$('#updt_vehicle').submit(function(e) {
        e.preventDefault();

        var consignmentID = [];
        $('input[name="edd[]"]').each(function() {
          if(this.value == '') {
           alert('Please enter EDD');
           exit;
          }
            consignmentID.push(this.value);
        });
        
        var ct = consignmentID.length; 
        var rowCount = $("#save-DraftSheet tbody tr").length;

        var vehicle = $('#vehicle_no').val();
        var driver = $('#driver_id').val();
        if(vehicle == ''){
            alert('Please select vehicle');
            return false;
        }
        if(driver == ''){
            alert('Please select driver');
            return false;
        }
        
        $.ajax({
              url: "update_unverifiedLR", 
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              type: 'POST',  
              data:new FormData(this),
              processData: false,
              contentType: false,
              beforeSend: function(){
                $('.indicator-progress').prop('disabled', true);
                $('.indicator-label').prop('disabled', true);

                $(".indicator-progress").show(); 
                $(".indicator-label").hide();
               },
               complete: function (response) {
            $('.indicator-progress').prop('disabled', true);
            $('.indicator-label').prop('disabled', true);
        },
              success: (data) => {
                $(".indicator-progress").hide();
                $(".indicator-label").show();
                    if(data.success == true){
                        
                        alert('Data Updated Successfully');
                        location.reload();
                    }
                    else{
                        alert('something wrong');
                    }
                }
                
        }); 
    });	
////////////////////////////
function showLibrary()
{
                 $('.new_edd').blur(function () {
                    
                    var consignment_id = $(this).attr('data-id');
                    
                    var drs_edd = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url: "update-edd",
                    method: "POST",
                    data: { drs_edd: drs_edd,consignment_id:consignment_id, _token: _token },
                    headers   : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    dataType  : 'json',
                    success: function (result) {
                        
                    }
                    })
           });
    }

    ///////////////////////////////delivery status////////////////////////////////////////
    $(document).on('click','.delivery_status', function(){
            
            var draft_id = $(this).val(); 
            $('#delivery').modal('show');
          //alert(draft_id);
          
            $.ajax({
                type: "GET",
                url: "update-delivery/"+draft_id, 
                data: {draft_id:draft_id},
                //dataType: "json",
                beforeSend:                      //reinitialize Datatables
               function(){   
                $('#delivery_status').dataTable().fnClearTable();             
                $('#delivery_status').dataTable().fnDestroy();
             
              },
                success: function(data){
                    var re = jQuery.parseJSON(data)
                    // console.log(re.fetch); return false;
                    var consignmentID = [];
                    $.each(re.fetch, function(index, value) {

                        var alldata = value;  
                       
                        consignmentID.push(alldata.consignment_no);
                        
                        $('#delivery_status tbody').append("<tr><td>" + value.consignment_no + "</td><td><input type='date' name='delivery_date[]' data-id="+ value.consignment_no +" class='delivery_d' value='"+ value.dd+ "'></td><td><button type='button'  data-id="+ value.consignment_no +" class='btn btn-primary remover_lr'>remove</button></td></tr>");      


                    });
                      //alert(consignmentID);
                      $("#drs_status").val(consignmentID);

                      get_delivery_date();
        } 
        
    });
});
///////////////////////////Update Delivery Status/////////////////////////////////////////////
$('#update_delivery_status').submit(function(e) {
        e.preventDefault();
//alert('hello'); return false;
       var consignmentID = [];
        $('input[name="delivery_date[]"]').each(function() {
          if(this.value == '') {
           alert('Please enter Delivery Date');
           exit;
          }
            consignmentID.push(this.value);
        });
        //alert(consignmentID);
        
        $.ajax({
              url: "update-delivery-status",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              type: 'POST',  
              data:new FormData(this),
              processData: false,
              contentType: false,
              beforeSend: function(){
              
               },
              success: (data) => {
                    if(data.success == true){
                
                        alert('Data Updated Successfully');
                        location.reload();
                    }
                    else{
                        alert('something wrong');
                    }
                }
                
        }); 
    });	

    ////////////////////////////////////////////
    function get_delivery_date()
{
    $('.delivery_d').blur(function () {
                    //  alert('hello');
                    var consignment_id = $(this).attr('data-id');
                    var delivery_date = $(this).val();
                    
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url: "update-delivery-date",
                    method: "POST",
                    data: { delivery_date: delivery_date,consignment_id:consignment_id, _token: _token },
                    headers   : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    dataType  : 'json',
                    success: function (result) {
                        
                    }
                    })
           });
    }
//////////////////////////////////Remove Lr From DRS////////////////////
    $(document).on('click','.remover_lr', function(){
            
           var consignment_id = $(this).attr('data-id');
           //alert(consignment_id);
          
            $.ajax({
                type: "GET",
                url: "remove-lr", 
                data: {consignment_id:consignment_id},
                //dataType: "json",
                beforeSend:                      //reinitialize Datatables
               function(){   
             
              },
                success: function(data){
                    var re = jQuery.parseJSON(data)
                    if(re.success == true){
                
                alert('LR Removed nSuccessfully');
                location.reload();
            }
            else{
                alert('something wrong');
            }

                   
        } 
        
    });
});
/////////////////////////////////////////////////
function catagoriesCheck(that) {
    if (that.value == "Successful") {
        document.getElementById("opi").style.display = "block";
   
    } else{
        document.getElementById("opi").style.display = "none";
          
    }
}
    </script>

@endsection