@extends('layouts.main')
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four" style="background-color: #90cfe3;">
                <div class="widget-content">
                    <div class="w-header">
                        <div class="w-info">
                            <h6 class="value">Today's LR</h6>
                        </div>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg> -->
                                </a>

                                <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="w-content">
                        <div class="w-info">
                            <p class="value">$ {{ $gettoday_lr }} </p>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four" style="background-color: #30b45fb8;">
                <div class="widget-content">
                    <div class="w-header">
                        <div class="w-info">
                            <h6 class="value">Today's Net Weight Lifted</h6>
                        </div>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="w-content">
                        <div class="w-info">
                            <p class="value">$ {{ $gettoday_weightlifted }}  </p>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four" style="background-color: #cfad74;">
                <div class="widget-content">
                    <div class="w-header">
                        <div class="w-info">
                            <h6 class="value">Today's Gross Weight Lifted</h6>
                        </div>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-content">
                        <div class="w-info">
                            <p class="value">$ {{ $gettoday_gross_weightlifted }} </p>
                        </div>
                    </div>
                </div>
            </div>   
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four" style="background-color: #97b044;">
                <div class="widget-content">
                    <div class="w-header">
                        <div class="w-info">
                            <h6 class="value">Current Month's LR</h6>
                        </div>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                </a>                
                            </div>
                        </div>
                    </div>

                    <div class="w-content">
                        <div class="w-info">
                            <p class="value">$ {{ $getcurrentmonth_lr }} </p>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four" style="background-color: #a04e4b;">
                <div class="widget-content">
                    <div class="w-header">
                        <div class="w-info">
                            <h6 class="value">Monthly Net Weight Lifted</h6>
                        </div>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-content">
                        <div class="w-info">
                            <p class="value">$ {{ $getmonthly_weightlifted }} </p>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four" style="background-color: #bd86d3;">
                <div class="widget-content">
                    <div class="w-header">
                        <div class="w-info">
                            <h6 class="value">Monthly Gross Weight Lifted</h6>
                        </div>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="w-content">
                        <div class="w-info">
                            <p class="value">$ {{ $getmonthly_gross_weightlifted }} </p>
                        </div>
                    </div>
                </div>
            </div>   
        </div>

        
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h5 class="">Revenue</h5>
                    <div class="task-action">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                                <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                                <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <div id="revenueMonthly"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-two">
                <div class="widget-heading">
                    <h5 class="">Sales by Category</h5>
                </div>
                <div class="widget-content">
                    <div id="chart-2" class=""></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget-one widget">
                <div class="widget-content">
                    <div class="w-numeric-value">
                        <div class="w-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                        <div class="w-content">
                            <span class="w-value">3,192</span>
                            <span class="w-numeric-title">Total Orders</span>
                        </div>
                    </div>
                    <div class="w-chart">
                        <div id="total-orders"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

            <div class="widget widget-activity-four">

                <div class="widget-heading">
                    <h5 class="">Recent Activities</h5>
                </div>

                <div class="widget-content">

                    <div class="mt-container mx-auto">
                        <div class="timeline-line">

                            <div class="item-timeline timeline-primary">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p><span>Updated</span> Server Logs</p>
                                    <span class="badge">Pending</span>
                                    <p class="t-time">Just Now</p>
                                </div>
                            </div>

                            <div class="item-timeline timeline-success">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Send Mail to <a href="javascript:void(0);">HR</a> and <a href="javascript:void(0);">Admin</a></p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">2 min ago</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-danger">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Backup <span>Files EOD</span></p>
                                    <span class="badge">Pending</span>
                                    <p class="t-time">14:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-dark">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Collect documents from <a href="javascript:void(0);">Sara</a></p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">16:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-warning">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Conference call with <a href="javascript:void(0);">Marketing Manager</a>.</p>
                                    <span class="badge">In progress</span>
                                    <p class="t-time">17:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-secondary">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Rebooted Server</p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">17:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-warning">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Send contract details to Freelancer</p>
                                    <span class="badge">Pending</span>
                                    <p class="t-time">18:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-dark">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Kelly want to increase the time of the project.</p>
                                    <span class="badge">In Progress</span>
                                    <p class="t-time">19:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-success">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Server down for maintanence</p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">19:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-secondary">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Malicious link detected</p>
                                    <span class="badge">Block</span>
                                    <p class="t-time">20:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-warning">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Rebooted Server</p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">23:00</p>
                                </div>
                            </div>

                            <div class="item-timeline timeline-primary">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p><span>Updated</span> Server Logs</p>
                                    <span class="badge">Pending</span>
                                    <p class="t-time">Just Now</p>
                                </div>
                            </div>

                            <div class="item-timeline timeline-success">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Send Mail to <a href="javascript:void(0);">HR</a> and <a href="javascript:void(0);">Admin</a></p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">2 min ago</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-danger">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Backup <span>Files EOD</span></p>
                                    <span class="badge">Pending</span>
                                    <p class="t-time">14:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-dark">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Collect documents from <a href="javascript:void(0);">Sara</a></p>
                                    <span class="badge">Completed</span>
                                    <p class="t-time">16:00</p>
                                </div>
                            </div>

                            <div class="item-timeline  timeline-warning">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>Conference call with <a href="javascript:void(0);">Marketing Manager</a>.</p>
                                    <span class="badge">In progress</span>
                                    <p class="t-time">17:00</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tm-action-btn">
                        <button class="btn"><span>View All</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">Transactions</h5>
                    <div class="task-action">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                                <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                                <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-content">

                    <div class="transactions-list t-info">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-title">SP</span>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4>Shaun Park</h4>
                                    <p class="meta-date">10 Jan 1:00PM</p>
                                </div>
                            </div>
                            <div class="t-rate rate-inc">
                                <p><span>+$36.11</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="transactions-list">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4>Electricity Bill</h4>
                                    <p class="meta-date">04 Jan 1:00PM</p>
                                </div>

                            </div>
                            <div class="t-rate rate-dec">
                                <p><span>-$16.44</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="transactions-list">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-title">AD</span>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4>Amy Diaz</h4>
                                    <p class="meta-date">31 Jan 1:00PM</p>
                                </div>

                            </div>
                            <div class="t-rate rate-inc">
                                <p><span>+$66.44</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="transactions-list t-secondary">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4>Netflix</h4>
                                    <p class="meta-date">02 Feb 1:00PM</p>
                                </div>

                            </div>
                            <div class="t-rate rate-dec">
                                <p><span>-$32.00</span></p>
                            </div>
                        </div>
                    </div>


                    <div class="transactions-list t-info">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-title">DA</span>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4>Daisy Anderson</h4>
                                    <p class="meta-date">15 Feb 1:00PM</p>
                                </div>
                            </div>
                            <div class="t-rate rate-inc">
                                <p><span>+$10.08</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="transactions-list">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-title">OG</span>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4>Oscar Garner</h4>
                                    <p class="meta-date">20 Feb 1:00PM</p>
                                </div>

                            </div>
                            <div class="t-rate rate-dec">
                                <p><span>-$22.00</span></p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        

    </div>

</div>

@endsection