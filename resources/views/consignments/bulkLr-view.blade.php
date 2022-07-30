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
                        <table id="" class="table table-hover" style="width:100%">
                            <div class="btn-group relative">
                                <!-- <a href="{{'consignments/create'}}" class="btn btn-primary pull-right" style="font-size: 13px; padding: 6px 0px;">Create Consignment</a> -->
                            </div>
                            <thead>
                                <tr>
                                <th>
                                     <input type="checkbox" name="" id="ckbCheckAll" style="width: 30px; height:30px;">
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
                                <td><input type="checkbox" name="checked_consign[]" class="chkBoxClass ddd" value="{{$value->id}}" data-trp="" data-vehno="" data-vctype="" style="width: 30px; height:30px;"></td>
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
$("#select_all").click(function () {
                    if($(this).is(':checked')){
                     
                        $('.ddd').prop('checked', true);
                 }else{ 
                   $('.ddd').prop('checked', false);
              }
                });
                $(function () {
                    $('#create_edd').click(function () { 

                        var consignmentID = [];
                $(':checkbox[name="checked_consign[]"]:checked').each (function () {
                    consignmentID.push(this.value);
                });
                //alert(consignmentID);

                $.ajax({
                    url: "",
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
    </script>