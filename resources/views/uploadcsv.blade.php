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
                
                <button type="submit" name="" class="mt-4 mb-4 btn btn-primary">Submit</button>
                <a class="btn btn-primary" href="{{url($prefix.'/dashboard') }}"> Back</a>
            </form>
        </div>

    </div>
</div>


@endsection