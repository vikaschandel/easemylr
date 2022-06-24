@extends('layouts.main')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<!-- END PAGE LEVEL CUSTOM STYLES -->
<style>
        .dt--top-section {
    margin:none;
}
div.relative {
    position: absolute;
    left: 110px;
    top: 24px;
    z-index: 1;
    width: 83px;
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
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Drivers</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Driver List</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    @csrf
                    <table id="drivertable" class="table table-hover get-datatable" style="width:100%">
                    <div class="btn-group relative">
                            <a class="btn-primary btn-cstm btn w-100" id="add_role" href="{{'drivers/create'}}" style="font-size: 12px; padding: 8px 0px;"><span><i class="fa fa-plus" ></i> Add New</span></a>
                        </div>
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Driver Name</th>
                                <th>Driver Phone</th>
                                <th>Driver License Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(count($drivers)>0) {
                                foreach ($drivers as $key => $value) {  
                            ?> 
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ ucwords($value->name ?? '-') }}</td>
                                <td>{{ $value->phone ?? '-' }}</td>
                                <td>{{ $value->license_number ?? '-' }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{url($prefix.'/drivers/'.Crypt::encrypt($value->id).'/edit')}}" ><span><i class="fa fa-edit"></i></span></a>
                                    <a class="btn btn-info" href="{{url($prefix.'/drivers/'.Crypt::encrypt($value->id))}}" ><span><i class="fa fa-eye"></i></span></a>
                                    <?php $authuser = Auth::user();
                                    if($authuser->role_id ==1) { ?>
                                        <a href="Javascript:void();" class="btn btn-danger delete_driver" data-id="{{ $value->id }}" data-action="<?php echo URL::to($prefix.'/drivers/delete-driver'); ?>"><span><i class="fa fa-trash"></i></span></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php 
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('models.delete-driver')
@endsection
