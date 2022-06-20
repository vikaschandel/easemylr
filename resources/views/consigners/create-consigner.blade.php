@extends('layouts.main')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Consigner</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Create Consigner</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create Consigner</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form" method="POST" action="{{url($prefix.'/consigners')}}" id="createconsigner">
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Consigner Nick Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nick_name" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Consigner Legal Name</label>
                                    <input type="text" class="form-control" name="legal_name" placeholder="">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlSelect1">Select State</label>
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
                                    <label for="exampleFormControlInput2">GST No.<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="gst_number" name="gst_number" placeholder="" maxlength="15">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Contact Name</label>
                                    <input type="text" class="form-control" name="contact_name" placeholder="Contact Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Email ID</label>
                                    <input type="email" class="form-control" name="email" placeholder="">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Mobile No.<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mbCheckNm" name="phone" placeholder="Enter 10 digit mobile no" maxlength="10">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlSelect1">Select Location</label>
                                    <select class="form-control" name="branch_id">
                                        <option value="">Select</option>
                                        <?php 
                                        if(count($branches)>0) {
                                            foreach ($branches as $key => $branch) {
                                        ?>
                                            <option value="{{ $key }}">{{ucwords($branch)}}</option>
                                            <?php 
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Address</label>
                                <textarea class="form-control" name="address" cols="5" rows="3" placeholder="Address"></textarea>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">City</label>
                                    <input type="text" class="form-control" name="city" placeholder="City">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">District</label>
                                    <input type="text" class="form-control" name="district" placeholder="District">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Pincode</label>
                                    <input type="text" class="form-control" name="postal_code" placeholder="Pincode">
                                </div>  
                                <!-- <div class="form-group col-md-6">
                                    <label for="exampleFormControlInput2">Status</label>
                                    <div class="check-box d-flex">
                                        <div class="checkbox radio">
                                            <label class="check-label">Active
                                                <input type="radio" value="1" name="status" class=""  checked="">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="checkbox radio">
                                            <label class="check-label">Deactive
                                                <input type="radio" name="status" value="0">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>                             
                                </div>   -->
                            </div>
                            <button type="submit" name="time" class="mt-4 mb-4 btn btn-primary">Submit</button>
                            <a class="btn btn-primary" href="{{url($prefix.'/consigners') }}"> Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
