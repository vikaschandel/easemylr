@extends('layouts.main')
@section('content')
<style>
        .dt--top-section {
    margin:none;
}
div.relative {
    position: absolute;
    left: 9px;
    top: 14px;
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

tr.shown td.dt-control {
    background: url('/assets/img/details_close.png') no-repeat center center !important;
}
td.dt-control {
    background: url('/assets/img/details_open.png') no-repeat center center !important;
    cursor: pointer;
}
.theads {
    text-align: center;
    padding: 5px 0;
    color: #279dff;
}
.ant-timeline {
    box-sizing: border-box;
    font-size: 14px;
    font-variant: tabular-nums;
    line-height: 1.5;
    font-feature-settings: "tnum","tnum";
    margin: 0;
    padding: 0;
    list-style: none;
}
.css-b03s4t {
    color: rgb(0, 0, 0);
    padding: 6px 0px 2px;
}
.css-16pld72 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform: capitalize;
}
.ant-timeline-item-tail {
    position: absolute;
    top: 10px;
    left: 4px;
    height: calc(100% - 10px);
    border-left: 2px solid #e8e8e8;
}
.ant-timeline-item-last>.ant-timeline-item-tail {
    display: none;
}

.ant-timeline-item-head-red {
    background-color: #f5222d;
    border-color: #f5222d;
}
.ant-timeline-item-head-green {
    background-color: #52c41a;
    border-color: #52c41a;
}
.ant-timeline-item-content {
    position: relative;
    top: -6px;
    margin: 0 0 0 18px;
    word-break: break-word;
}
.css-phvyqn {
    color: rgb(0, 0, 0);
    padding: 0px;
    height: 34px !important;
}
.ant-timeline-item {
    position: relative;
    margin: 0;
    padding: 0 0 5px;
    font-size: 14px;
    list-style: none;
}
.ant-timeline-item-head {
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 100px;
}
.css-ccw3oz .ant-timeline-item-head {
    padding: 0px;
    border-radius: 0px !important;
}
.labels{
    color:#4361ee;
}
a.badge.alert.bg-secondary.shadow-sm {
    color: #fff;
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Consignment List</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="widget-content widget-content-area br-6"> 
                    <div class="mb-4 mt-4">
                        @csrf
                        <table id="bulk-table" class="table table-hover" style="width:100%">
                            <div class="btn-group relative">
                            <a href="{{'download-bulklr'}}" class="btn btn-primary pull-right" style="font-size: 13px; padding: 6px 0px;">Create Consignment</a>
                            <!-- <button type="button" class="btn btn-warning disableDrs" id="download_bulkLr" style="font-size: 11px;">
                             Download All LR
                              </button> -->
                            </div>
                            <thead>
                                <tr>
                                <th>
                                     <input type="checkbox" name="" id="checkAll_Lr" style="width: 30px; height:30px;">
                                    </th>
                                    <th>LR No.</th>
                                    <th>LR Date</th>
                                    <th>Consigner</th>
                                    <th>Consignee</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consignments as $value)
                                <tr>
                                <td><input type="checkbox" name="checked_lr[]" class="checkLr" value="{{$value->id}}" data-trp="" data-vehno="" data-vctype="" style="width: 30px; height:30px;"></td>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->consignment_date}}</td>
                                    <td>{{$value->consigner_name}}</td>
                                    <td>{{$value->consignee_name}}</td>
                                    <td>{{$value->city}}</td>
                                 
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
  jQuery(document).on('click','#checkAll_Lr',function(){
        if(this.checked){
            jQuery('#create_edd').prop('disabled', false);
            jQuery('.checkLr').each(function(){
                this.checked = true;
            });
        } 
        else{
            jQuery('.checkLr').each(function(){
                this.checked = false;
            });
            jQuery('#create_edd').prop('disabled', true);
        }
    });

    jQuery(document).on('click','.checkLr',function(){
        if($('.chkBoxClass:checked').length == $('.checkLr').length){
            $('#checkAll_Lr').prop('checked',true);
        }else{
            var checklength = $('.checkLr:checked').length;
            if(checklength < 1){
                jQuery('#create_edd').prop('disabled', true);
            }else{
                jQuery('#create_edd').prop('disabled', false);
            }

            $('#checkAll_Lr').prop('checked',false);
        }
    });
    $(function () {
                    $('#download_bulkLr').click(function () { 
                        // alert('hi'); return false;

                        var consignmentID = [];
                $(':checkbox[name="checked_lr[]"]:checked').each (function () {
                    consignmentID.push(this.value);
                });
                //alert(consignmentID); return false;

                $.ajax({
                    url: "download-bulklr",
                    method: "POST",
                    data: {consignmentID: consignmentID},
                    headers   : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    dataType  : 'json',
                    beforeSend  : function () {
                   $('.disableDrs').prop('disabled', true);
             
                   },
                    complete: function (response) {
                        $('.disableDrs').prop('disabled', true);
                    },
                    success: function (data) {
                        if(data.success == true){
                        
                        alert('Data Updated Successfully');
                        location.reload();
                    }
                    else{
                        alert('something wrong');
                    }
                        
                    }
                    })
                         

                    }); 
                });


            //////////////////////////////////////////    
                $('#bulk-table').DataTable( {
            "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    // { extend: 'copy', className: 'btn btn-sm' },
                    // { extend: 'csv', className: 'btn btn-sm' },
                    // { extend: 'excel', className: 'btn btn-sm' },
                    // { extend: 'print', className: 'btn btn-sm' }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            
            "ordering": true,
            "paging": true,
            "pageLength": 80,
            
        } );
    </script>

    @endsection