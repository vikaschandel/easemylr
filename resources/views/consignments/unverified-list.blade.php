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

    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Consignments</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Unverified Lr</a></li>
                        </ol>
                    </nav>
                </div> 
      
                <div class="widget-content widget-content-area br-6">
                    <div class=" mb-4 mt-4">
                        @csrf
                        <table id="usertable" class="table table-hover get-datatable" style="width:100%">
                            <div class="btn-group relative">
                            <button type="button" class="btn btn-warning disableDrs" id="create_edd" style="font-size: 11px;">
                             Create DSR
                              </button>
                                <!-- <button type="button" class="btn btn-warning" id="launch_model" data-toggle="modal" data-target="#exampleModal" disabled="disabled" style="font-size: 11px;">

                            Create DSR
                            </button> -->
                            </div>
                            <thead>
                                <tr>
                                     <th>
                                     <input type="checkbox" name="" id="ckbCheckAll" style="width: 30px; height:30px;">
                                    </th>
                                        <th>LR No</th>
                                        <th>CN Date</th>
                                        <th>Consigner Name</th>
                                        <th>Consignee Name</th>
                                        <th>District</th>
                                        <th>City</th>
                                        <th>Pin Code</th> 
                                        <th>Boxes</th> 
                                        <th>Net Weight</th>
                                       
                                </tr>
                             </thead>
                            <tbody>
                            <?php 
                            $i = 1;
                                foreach ($consignments as $key => $consignment) {       
                                ?> 
                                <tr>

                                <td><input type="checkbox" name="checked_consign[]" class="chkBoxClass ddd" value="{{$consignment->id}}" data-trp="" data-vehno="" data-vctype="" style="width: 30px; height:30px;"></td>
                                    <td>{{ $consignment->id ?? "-" }}</td>
                                    <td>{{ $consignment->consignment_date}}</td>
                                    <td>{{ $consignment->consigner_id}}</td>
                                    <td>{{ $consignment->consignee_id}}</td>
                                    <td>{{ $consignment->consignee_district ?? "-" }}</td>
                                    <td>{{ $consignment->city ?? "-" }}</td>
                                    <td>{{ $consignment->pincode ?? "-" }}</td>
                                    <td>{{ $consignment->total_quantity ?? "-" }}</td>
                                    <td>{{ $consignment->total_weight ?? "-" }}</td>
                                  
                                </tr>
                               
                                <?php  $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('models.common-confirm')
@include('models.update-unverifiedList') 
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    

    ///// check box checked lead page
    jQuery(document).on('click','#ckbCheckAll',function(){
        if(this.checked){
            jQuery('#create_edd').prop('disabled', false);
            jQuery('.chkBoxClass').each(function(){
                this.checked = true;
            });
        }
        else{
            jQuery('.chkBoxClass').each(function(){
                this.checked = false;
            });
            jQuery('#create_edd').prop('disabled', true);
        }
    });

    jQuery(document).on('click','.chkBoxClass',function(){
        if($('.chkBoxClass:checked').length == $('.chkBoxClass').length){
            $('#ckbCheckAll').prop('checked',true);
            jQuery('#launch_model').prop('disabled', false);
        }else{
            var checklength = $('.chkBoxClass:checked').length;
            if(checklength < 1){
                jQuery('#create_edd').prop('disabled', true);
            }else{
                jQuery('#create_edd').prop('disabled', false);
            }

            $('#ckbCheckAll').prop('checked',false);
        }
    });

}); 
/////////////////////////////////////////////////////////////////
  
</script>
@endsection