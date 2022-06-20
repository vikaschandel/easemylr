@extends('layouts.main')
@section('content')
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
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Branch Locations</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Location List</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div style="margin-left:9px;" class="breadcrumb-title pe-3"><h5>Locations</h5></div> -->
                    <div class="ms-auto" style="margin: 10px 0 0px 870px">
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
                                <th>Team Id</th>
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
                                <td>{{ ucfirst($value->team_id) }}</td>
                                <td>
                                    <a class="btn btn-primary editlocation" href="javascript:void(0)" data-action = "<?php echo URL::to($prefix.'/locations/get-location'); ?>" data-id="{{ $value->id }}" data-toggle="modal" data-target="#location-updatemodal"><span><span><i class="fa fa-edit"></i></span></span></a>
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
