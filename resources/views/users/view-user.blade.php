@extends('layouts.main')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3"><h5>User Details</h5></div>
                    <div class="col-md-10 text-right">
                        <a href="{{url($prefix.'/users/'.Crypt::encrypt($getuser->id).'/edit')}}" class="btn my-3" href="" style="background:#fff;" title="Edit User"><i class="fa fa-edit m-0"></i></a>
                    </div>
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{isset($getuser->name)?ucfirst($getuser->name):'-'}} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{isset($getuser->email) ? ucfirst($getuser->email) : "-" }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Password</th>
                                        <td>{{isset($getuser->user_password) ? $getuser->user_password : "-" }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone</th>
                                        <td>{{isset($getuser->phone) ? ucfirst($getuser->phone) : "-" }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Role</th>
                                        <td>{{ucwords(@$getuser->UserRole->name) ?? "-"}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Locations</th>
                                        <td>
                                            @if(isset($branches))
                                                @foreach($branches as $branch)
                                                    {{$branch}}<br>
                                                @endforeach
                                            @else
                                                -   
                                            @endif
                                        <!-- <?php 
                                       // if(count($branches)>0) {
                                            // $cc = explode(',',$getuser->branch_id);
                                            // foreach ($branches as $k => $branch) {
                                            //     $selected = in_array($k,$cc) ? 'selected' : '';
                                        ?>
                                            {{ucwords($branch)}}
                                            <?php 
                                        //     }
                                        // }
                                        ?>
                                    </select> -->
                                        </td>
                                    </tr>                             
                                </tbody>
                            </table>  
                            <a class="btn btn-primary" href="{{url($prefix.'/users') }}"> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection