@extends('layouts.main')
@section('content')
<style>
.red-text { color: red; }
.green-text{ color: green;}

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
                    <div style="margin-left:9px;" class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <!-- <div class="breadcrumb-title pe-3"><h5>Consignments</h5></div> -->
                        <div class="ms-auto" style="margin: 10px 0 0px 682px">
                            <div class="btn-group">
                                <a href="{{'consignments/create'}}" class="btn btn-primary pull-right">Create Consignment</a>
                            </div>
                        </div>  
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        @csrf
                        <table id="usertable" class="table table-hover get-datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Consignment No.</th>
                                    <th>Consignment Date</th>
                                    <th>Invoice No.</th>
                                    <th>Party Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($consignments)>0) {
                                    foreach ($consignments as $key => $consignment) {  
                                ?> 
                                <tr>
                                    <td>{{ $consignment->consignment_no ?? "-" }}</td>
                                    <td>{{ Helper::ShowFormatDate($consignment->consignment_date ?? "")}}</td>
                                    <td>{{ $consignment->invoice_no ?? "-" }}</td>
                                    <td>{{ $consignment->transporter_name ?? "" }}</td>
                                    <?php
                                    if($consignment->status==1){
                                        $status = 'Active';
                                        $class = "green-text";
                                    }else{
                                        $class = "red-text";
                                        $status = 'InActive';
                                    }
                                    ?>
                                    <td>@if($consignment->status == 1)
                                        <a class="inactivestatus btn {{$class}}" data-id = "{{$consignment->id}}" data-text="consignment" data-status = "0" data-action = "<?php echo URL::current();?>"><span><i class="fa fa-check-circle-o"></i> {{ $status }}</span></a>
                                        @else
                                        <a class="btn {{$class}}" data-id = "{{$consignment->id}}" data-text="consignment" data-status = "1" data-action = ""><span><i class="fa fa-ban"></i>  {{ $status }}</span></a>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{url($prefix.'/consignments/'.$consignment->id)}}" ><span><i class="fa fa-eye"></i></span></a>
                                        <!-- <a class="btn btn-primary" href="{{url($prefix.'/consignments/'.Crypt::encrypt($consignment->id).'/edit')}}" ><span><i class="fa fa-edit"></i></span></a>
                                        <a href="Javascript:void();" class="btn btn-danger delete_consignment" data-id="{{ $consignment->id }}" data-action="<?php// echo URL::to($prefix.'/consignments/delete-consignment'); ?>"><span><i class="fa fa-trash"></i></span></a> -->
                                    </td>
                                </tr>
                                <?php 
                                    }
                                }
                                else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No Record Found </td>
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
@include('models.delete-user')
@include('models.common-confirm')
@endsection