@extends('layouts.main')
@section('content')
 <!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<!-- END PAGE LEVEL STYLES -->
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div style="margin-left:9px;" class="breadcrumb-title pe-3"><h5>Locations</h5></div>
                    <div class="ms-auto" style="margin: 10px 0 0px 767px">
                        <div class="btn-group">
                            <a class="btn-primary btn-cstm btn w-100" id="add_location" data-toggle="modal" data-target="#location-modal" href="#"><span><i class="fa fa-plus"></i> Add New</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    @csrf
                    <table id="usertable" class="table table-hover get-datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                <th>Nick Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(count($locations)>0) {
                                foreach ($locations as $key => $value) {  
                            ?> 
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ ucfirst($value->name) }}</td>
                                <td>{{ ucfirst($value->nick_name) }}</td>
                                <td>
                                    <a class="btn btn-primary editlocation" href="javascript:void(0)" data-action = "<?php echo URL::to($prefix.'/locations/get-location'); ?>" data-id="{{ $value->id }}" data-toggle="modal" data-target="#location-updatemodal"><span><span><i class="fa fa-edit"></i></span></span></a>
                                    <!-- <a class="btn btn-info" href="{{url($prefix.'/locations/'.Crypt::encrypt($value->id))}}" ><span><i class="fa fa-eye"></i></span></a> -->
                                    <!-- <a href="Javascript:void();" class="btn btn-danger delete_location" data-id="{{ $value->id }}" data-action="<?php// echo URL::to($prefix.'/locations/delete-location'); ?>"><span><i class="fa fa-trash"></i></span></a> -->
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

@include('models.create-location')
@include('models.update-location')
@endsection
