@extends('layouts.main')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3"><h5>Create Vehicle</h5></div>
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <form class="general_form" method="POST" action="{{url($prefix.'/vehicles')}}" id="createvehicle">
                                <div class="form-row mb-0">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Registration No.</label>
                                        <input type="text" class="form-control" id="regn_no" name="regn_no" placeholder="" maxlength="10">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Manufacturer</label>
                                        <input type="text" class="form-control" name="mfg" placeholder="Mahindra, Tata, etc.">
                                    </div>
                                </div>
                                <div class="form-row mb-0">                          
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Make</label>
                                        <input type="text" class="form-control" name="make" placeholder="407, Supro Maxi, Truck, Pickup, Ace, etc.">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Engine No.</label>
                                        <input type="text" class="form-control" name="engine_no" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-0">     
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Chassis No.</label>
                                        <input type="text" class="form-control" name="chassis_no" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Gross Vehicle Weight</label>
                                        <input type="text" class="form-control" name="gross_vehicle_weight" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-0">                          
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Unladen Weight</label>
                                        <input type="text" class="form-control" name="unladen_weight" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Body Type</label>
                                        <select class="form-control" name="body_type">
                                            <option value="Container">Container</option>
                                            <option value="Open Body">Open Body</option>
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
                                                <option value="{{ $key }}">{{ucwords($state)}}</option>
                                              <?php 
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Regn. Date</label>
                                        <input type="date" class="form-control" name="regndate" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Hypothecation</label>
                                        <input type="text" class="form-control" name="hypothecation" placeholder="Name of Financer | N/A">
                                    </div>    
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput2">Ownership</label>
                                        <select class="form-control" name="ownership">
                                            <option value="Self Owned">Self Owned</option>
                                            <option value="Company Owned">Company Owned</option>
                                            <option value="Transporter Owned">Transporter Owned</option>
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