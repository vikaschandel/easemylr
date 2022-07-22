@extends('layouts.main')
@section('content')
<style>
     .row.layout-top-spacing {
    width: 80%;
    margin: auto;

}
    </style>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Clients</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Create Client</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form" method="POST" action="{{url($prefix.'/clients')}}" id="createclient">
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Client Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="client_name" id="client_name" placeholder="">
                            </div>
                            <table id="myTable">
                                <tbody>
                                    <tr>
                                        <th><label for="exampleFormControlInput2">Regional Client Name<span class="text-danger">*</span></label></th>
                                        <th><label for="exampleFormControlInput2">Location<span class="text-danger">*</span></label></th>
                                    </tr>
                                    <tr class="rowcls">
                                        <td>
                                            <input type="text" class="form-control name" name="data[1][name]" placeholder="">
                                        </td>
                                        <td>
                                            <select class="form-control location_id" name="data[1][location_id]">
                                                <option value="">Select</option>
                                                <?php 
                                                if(count($locations)>0) {
                                                    foreach ($locations as $key => $location) {
                                                ?>
                                                    <option value="{{ $key }}">{{ucwords($location)}}</option>
                                                    <?php 
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" id="addRow" onclick="addrow()"><i class="fa fa-plus-circle"></i></button>
                                            <!-- <a onclick="addrow()" class="fa fa-plus-circle" href="#"></a> -->
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <button type="submit" class="mt-4 mb-4 btn btn-primary">Submit</button>
                            <a class="btn btn-primary" href="{{url($prefix.'/clients') }}"> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    // $("a").click(function(){
    function addrow(){
        var i = $('.rowcls').length;
        i  = i + 1;

        $('#myTable tbody').append('<tr class="rowcls"><td><input class="form-control name" type="text" name="data['+i+'][name]"></td><td> <select class="form-control location_id" name="data['+i+'][location_id]"> <option value="">Select</option> @if(count($locations)>0)@foreach ($locations as $key => $location)<option value="{{ $key }}">{{ucwords($location)}}</option> @endforeach @endif</select></td><td><button type="button" class="btn btn-primary removeRow" onclick="removerow()"><i class="fa fa-minus-circle"></i></button></td></tr>');   
    }
    
    function removerow(){
        $('#myTable tr:last').remove();
    }
    // $('.removeRow').click(function(){
    //     $(this).parent().parent().remove();
    // });

</script>
@endsection