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
    </style>
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<!-- END PAGE LEVEL CUSTOM STYLES -->  

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
                                    <th>Transaction Date</th>
                                    <th>Vehicle No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction as $trns)
                                <?php  $creation = date('d-m-Y',strtotime($trns['created_at']));  ?>
                              <tr>
                                <td>DRS-{{$trns['drs_no']}}</td>
                                <td>{{$creation}}</td>
                                <td>{{$trns['vehicle_no']}}</td>
                                <td><button type="button" class="btn btn-warning view-sheet" value="{{$trns['id']}}" style="margin-right:4px;">View</button><a class="btn btn-primary" href="{{url($prefix.'/print-transaction/'.$trns['id'])}}" role="button">Print</a></td>
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
<script>
    //////////////////////////////////////////
    $(document).ready(function() {
        
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
                    $('.opm').modal('show');
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
                        $("#total").empty();  
                        $("#ppp").empty();  
                        $("#nnn").empty();   
                        $("#drsdate").empty();  
                 },
                        success: function(data){
                            var re = jQuery.parseJSON(data)
                            $.each(re.fetch, function(index, value) {
                                 var alldata = jQuery.parseJSON(value.transaction_details);  
                                console.log(value.vehicle_no);
                                 $("#sss").append(value.vehicle_no);
                                 $("#ppp").append(value.driver_name);
                                 $("#nnn").append(value.driver_no);
                                 $("#drsdate").append("DRS-"+value.drs_no);
                                 for(i=0 ; i<alldata.length; i++){ 
                                    var tras =  alldata[i];
                                    // console.log(tras); return false;
                                    $('#sheet tbody').append("<tr><td>" + tras.consignment_no + "</td><td>" + tras.consignment_date + "</td><td>" + tras.consignee_id + "</td><td>"+ tras.city + "</td><td>"+ tras.pincode + "</td><td>"+ tras.total_quantity + "</td><td>"+ tras.total_weight + "</td></tr>");
                                    //console.log(i);
                                 }
                                 //console.log(i);
                                 $("#total").append(i);
                        });
                       
                

				}
                
			});
			
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
        
    </script>
@endsection