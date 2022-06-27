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
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Consignee</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Consignee List</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div style="margin-left:9px;" class="breadcrumb-title pe-3"><h5>Consignees</h5></div> -->
                    <div class="ms-auto">
                       
                    </div>
                </div>
                <div class="mb-4 mt-4">
                    @csrf
                    <table id="consigneetable" class="table table-hover get-datatable" style="width:100%">
                    <div class="btn-group relative">
                            <a class="btn-primary btn-cstm btn w-100" id="add_role" href="{{'consignees/create'}}" style="font-size: 12px; padding: 8px 0px;"><span><i class="fa fa-plus"></i> Add New</span></a>
                        </div>
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Consignee Nick Name</th>
                                <th>Consigner</th>
                                <th>Contact Person Name</th>
                                <th>Mobile No.</th>
                                <th>PIN Code</th>
                                <th>City</th>
                                <th>District</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(count($consignees)>0) {
                                    foreach ($consignees as $key => $value) {  
                                ?> 
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ ucwords($value->nick_name ?? "-") }}</td>
                                <td>{{ ucwords($value->Consigner->nick_name ?? "-") }}</td>
                                <td>{{ ucwords($value->contact_name ?? "-") }}</td>
                                <td>{{ $value->phone ?? "-" }}</td>
                                <td>{{ $value->postal_code ?? "-" }}</td>
                                <td>{{ ucwords($value->city ?? "-") }}</td>
                                <td>{{ ucwords($value->district ?? "-") }}</td>
                                <td>{{ ucwords($value->State->name ?? "-") }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{url($prefix.'/consignees/'.Crypt::encrypt($value->id).'/edit')}}" ><span><i class="fa fa-edit"></i></span></a>
                                    <a class="btn btn-info" href="{{url($prefix.'/consignees/'.Crypt::encrypt($value->id))}}" ><span><i class="fa fa-eye"></i></span></a>
                                    <?php $authuser = Auth::user();
                                    if($authuser->role_id ==1) { ?>
                                        <a href="Javascript:void();" class="btn btn-danger delete_consignee" data-id="{{ $value->id }}" data-action="<?php echo URL::to($prefix.'/consignees/delete-consignee'); ?>"><span><i class="fa fa-trash"></i></span></a>
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

@include('models.delete-consignee')
@endsection
