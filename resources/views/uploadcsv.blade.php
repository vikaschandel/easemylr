@extends('layouts.main')
@section('content')

<h5 class="importmessage red-text" style="display: none;">Files imported successfully.</h5>
<!-- <h5 class="select-csvfile red-text" style="display: none;">Please select csv file.</h5> -->
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            @php
                $authuser = Auth::user();
            @endphp

            <form method="POST" action="{{url($prefix.'/consignees/upload_csv')}}" id="importfiles" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-3 col-sm-12">
                        <h4 class="win-h4">Browse Consignees Sheet</h4>
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="file" name="consigneesfile" id="consigneefile" class="consigneefile"> 
                    </div> 
                </div> 
                <br/>
                <div class="row">
                    <div class="col-lg-6 col-md-3 col-sm-12">
                        <h4 class="win-h4">Browse Vehicles Sheet</h4>
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="file" name="vehiclesfile" id="vehiclefile" class="vehiclefile"> 
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-6 col-md-3 col-sm-12">
                        <h4 class="win-h4">Browse Consigners Sheet</h4>
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="file" name="consignersfile" id="consignerfile" class="consignerfile"> 
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-6 col-md-3 col-sm-12">
                        <h4 class="win-h4">Browse Drivers Sheet</h4>
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="file" name="driversfile" id="driverfile" class="driverfile"> 
                    </div>
                </div>
            
                
                <button type="submit" name="" class="mt-4 mb-4 btn btn-primary">Submit</button>
                <div class="spinner-border loader" style= "display:none;"></div>
                <a class="btn btn-primary" href="{{url($prefix.'/dashboard') }}"> Back</a>
            </form>
        </div>

    </div>
</div>


@endsection