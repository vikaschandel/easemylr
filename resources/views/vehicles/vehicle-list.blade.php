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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Vehicles</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Vehicle List</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="widget-content widget-content-area br-6">
                    <div style="margin-left:9px;" class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <!-- <div class="breadcrumb-title pe-3"><h5>Vehicles</h5></div> -->
                        <div class="ms-auto" style="margin: 10px 0 0px 742px">
                            <div class="btn-group">
                                <a href="{{'vehicles/create'}}" class="btn btn-primary pull-right">Create Vehicle</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        @csrf
                        <table id="vehicletable" class="table table-hover vehicle-datatable" style="width:100%">
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
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('models.delete-vehicle')
@endsection
@section('js')
<script>
    
    $(function () {
        var table = $('#vehicletable').DataTable({
            processing: true,
            serverSide: true,
            columns: [
                {data: 'regn_no', name: 'regn_no'},
                {data: 'mfg', name: 'mfg'},
                {data: 'make', name: 'make'},
                {data: 'body_type', name: 'body_type'},
                {data: 'regn_date', name: 'regn_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
             
            ]
        });
    });
</script>
@endsection