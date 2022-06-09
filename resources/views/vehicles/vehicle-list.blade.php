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
                    <div style="margin-left:9px;" class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3"><h5>Vehicles</h5></div>
                        <div class="ms-auto" style="margin: 10px 0 0px 742px">
                            <div class="btn-group">
                                <a href="{{'vehicles/create'}}" class="btn btn-primary pull-right">Create Vehicle</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        @csrf
                        <table id="usertable" class="table table-hover get-datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Regn No.</th>
                                    <th>Manufacture</th>
                                    <th>Model</th>
                                    <th>Body Type</th>
                                    <th>Regn Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($data)>0) {
                                    foreach ($data as $key => $vehicle) {  
                                ?> 
                                <tr>
                                    <td>{{ $vehicle->regn_no ?? ""}}</td>
                                    <td>{{ $vehicle->mfg ?? "" }}</td>
                                    <td>{{ $vehicle->make ?? "" }}</td>
                                    <td>{{ $vehicle->body_type ?? "" }}</td>
                                    <td>{{Helper::ShowFormatDate($vehicle->regndate ?? "")}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{url($prefix.'/vehicles/'.Crypt::encrypt($vehicle->id).'/edit')}}" ><span><i class="fa fa-edit"></i></span></a>
                                        <a class="btn btn-primary" href="{{url($prefix.'/vehicles/'.Crypt::encrypt($vehicle->id))}}" ><span><i class="fa fa-eye"></i></span></a>
                                        <?php $authuser = Auth::user();
                                        if($authuser->role_id ==1) { ?>
                                            <a href="Javascript:void();" class="btn btn-danger delete_vehicle" data-id="{{ $vehicle->id }}" data-action="<?php echo URL::to($prefix.'/vehicles/delete-vehicle'); ?>"><span><i class="fa fa-trash"></i></span></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                }
                                else {
                                    ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No Record Found </td>
                                    </tr>
                                <?php 
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('models.delete-vehicle')
@endsection