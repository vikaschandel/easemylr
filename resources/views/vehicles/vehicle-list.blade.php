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
      var table = $('#vehicletable').DataTable({
            processing: true,
            serverSide: true,
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                    },

                    "stripeClasses": [],
                    "pageLength": 30,
                    drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered'); },
    
        columns: [
                {data: 'regn_no', name: 'regn_no'},
                {data: 'mfg', name: 'mfg'},
                {data: 'make', name: 'make'},
                {data: 'body_type', name: 'body_type'},
                {data: 'regn_date', name: 'regn_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
             
            ]
}); 
    </script>
<!-- <script>
    
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
</script> -->
@endsection