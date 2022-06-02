@extends('layouts.main')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3"><h5>Update Vehicle</h5></div>
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <form class="general_form" method="POST" action="{{url($prefix.'/vehicles/update-vehicle')}}" id="updatevehicle">
                                @csrf
                                <input type="hidden" name="vehicle_id" value="{{$getvehicle->id}}">

                                <div class="form-row mb-0">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Registration No.</label>
                                        <input type="text" class="form-control" id="regn_no" name="regn_no" value="{{old('regn_no',isset($getvehicle->regn_no)?$getvehicle->regn_no:'')}}" placeholder="" maxlength="10">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Manufacturer</label>
                                        <input type="text" class="form-control" name="mfg" value="{{old('mfg',isset($getvehicle->mfg)?$getvehicle->mfg:'')}}" placeholder="Mahindra, Tata, etc.">
                                    </div>
                                </div>
                                <div class="form-row mb-0">                          
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Make</label>
                                        <input type="text" class="form-control" name="make" value="{{old('make',isset($getvehicle->make)?$getvehicle->make:'')}}" placeholder="407, Supro Maxi, Truck, Pickup, Ace, etc.">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Engine No.</label>
                                        <input type="text" class="form-control" name="engine_no" value="{{old('engine_no',isset($getvehicle->engine_no)?$getvehicle->engine_no:'')}}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-0">     
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Chassis No.</label>
                                        <input type="text" class="form-control" name="chassis_no" value="{{old('chassis_no',isset($getvehicle->chassis_no)?$getvehicle->chassis_no:'')}}" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Gross Vehicle Weight</label>
                                        <input type="text" class="form-control" name="gross_vehicle_weight" value="{{old('gross_vehicle_weight',isset($getvehicle->gross_vehicle_weight)?$getvehicle->gross_vehicle_weight:'')}}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-0">                          
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Unladen Weight</label>
                                        <input type="text" class="form-control" name="unladen_weight" value="{{old('unladen_weight',isset($getvehicle->unladen_weight)?$getvehicle->unladen_weight:'')}}" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Body Type</label>
                                        <select class="form-control" name="body_type">
                                            <option value="Container" {{$getvehicle->body_type == 'Container' ? 'selected' : ''}}>Container</option>
                                            <option value="Open Body" {{$getvehicle->body_type == 'Open Body' ? 'selected' : ''}}>Open Body</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">State(Regd)</label>
                                        <select class="form-control" name="state_id">
                                            <option value="">Select</option>
                                            <?php 
                                            if(count($states)>0) {
                                                foreach ($states as $key => $state) {
                                            ?>
                                                <option value="{{ $key }}" {{ $key == $getvehicle->state_id ? 'selected' : ''}}>{{ucwords($state)}}</option>
                                              <?php 
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Regn. Date</label>
                                        <input type="date" class="form-control" name="regndate" value="{{old('regndate',isset($getvehicle->regndate)?$getvehicle->regndate:'')}}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Hypothecation</label>
                                        <input type="text" class="form-control" name="hypothecation" value="{{old('hypothecation',isset($getvehicle->hypothecation)?$getvehicle->hypothecation:'')}}" placeholder="Name of Financer | N/A">
                                    </div>    
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Ownership</label>
                                        <select class="form-control" name="ownership">
                                            <option value="Self Owned" {{$getvehicle->ownership == 'Self Owned' ? 'selected' : ''}}>Self Owned</option>
                                            <option value="Company Owned" {{$getvehicle->ownership == 'Company Owned' ? 'selected' : ''}}>Company Owned</option>
                                            <option value="Transporter Owned" {{$getvehicle->ownership == 'Transporter Owned' ? 'selected' : ''}}>Transporter Owned</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <button type="submit" class="mt-4 mb-4 btn btn-primary">Submit</button>
                                <a class="btn btn-primary" href="{{url($prefix.'/vehicles')}}"> Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection