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
                    <div class="table-responsive mb-4 mt-4">
                        @csrf
                        <table id="usertable" class="table table-hover get-datatable" style="width:100%">
                            <div class="btn-group relative">
                                <button type="button" class="btn btn-warning" id="launch_model" data-toggle="modal" data-target="#exampleModal" disabled="disabled" style="font-size: 11px;">

                            Update Vehicle Details
                            </button>
                            </div>
                            <thead>
                                <tr>
                                     <th>
                                     <input type="checkbox" name="" id="ckbCheckAll">
                                    </th>
                                    <th>Consignment No.</th>
                                    <th>Consignment Date</th>
                                    <th>Invoice No.</th>
                                    <th>Party Name</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                foreach ($consignments as $key => $consignment) {  
                                ?> 
                                <tr>
                                <td><input type="checkbox" name="checked_consign[]" class="chkBoxClass ddd" value="{{$consignment->id}}" data-trp="" data-vehno="" data-vctype=""></td>
                                    <td>{{ $consignment->consignment_no ?? "-" }}</td>
                                    <td>{{ Helper::ShowFormatDate($consignment->consignment_date ?? "")}}</td>
                                    <td>{{ $consignment->invoice_no ?? "-" }}</td>
                                    <td>{{ $consignment->transporter_name ?? "-" }}</td>
                                </tr>
                                <?php } ?>
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
        

     $('#updt_vehicle').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
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

    ///// check box checked lead page
    jQuery(document).on('click','#ckbCheckAll',function(){
        if(this.checked){
            jQuery('#launch_model').prop('disabled', false);
            jQuery('.chkBoxClass').each(function(){
                this.checked = true;
            });
        }
        else{
            jQuery('.chkBoxClass').each(function(){
                this.checked = false;
            });
            jQuery('#launch_model').prop('disabled', true);
        }
    });

    jQuery(document).on('click','.chkBoxClass',function(){
        if($('.chkBoxClass:checked').length == $('.chkBoxClass').length){
            $('#ckbCheckAll').prop('checked',true);
            jQuery('#launch_model').prop('disabled', false);
        }else{
            var checklength = $('.chkBoxClass:checked').length;
            if(checklength < 1){
                jQuery('#launch_model').prop('disabled', true);
            }else{
                jQuery('#launch_model').prop('disabled', false);
            }

            $('#ckbCheckAll').prop('checked',false);
        }
    });

});

</script>
@endsection