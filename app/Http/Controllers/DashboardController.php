<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsignmentNote;
use App\Models\ConsignmentItem;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public $prefix;
    public $title;
    public $segment;

    public function __construct()
    {
      $this->title =  "Dashboard";
      $this->segment = \Request::segment(2);
    }
    public function index()
    {
        $this->prefix = request()->route()->getPrefix();
        $query = ConsignmentNote::query();

        $gettoday_lr = $query->whereDate('created_at', '=', Carbon::today())->where('status', '1')->count();
        $gettoday_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-d'))->where('status', '=', 1)->sum('weight');        
        $gettoday_gross_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-d'))->where('status', '=', 1)->sum('gross_weight');

        $getcurrentmonth_lr = DB::table('consignment_notes')->whereMonth('created_at', Carbon::now()->month)->where('status', '=', 1)->count();
        $getmonthly_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-01'))->where('status', '=', 1)->sum('weight');
        $getmonthly_gross_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-01'))->where('status', '=', 1)->sum('gross_weight');

        return view('dashboard',['prefix'=>$this->prefix,'title'=>$this->title,'gettoday_lr'=>$gettoday_lr,'gettoday_weightlifted'=>$gettoday_weightlifted,'gettoday_gross_weightlifted'=>$gettoday_gross_weightlifted,'getcurrentmonth_lr'=>$getcurrentmonth_lr,'getmonthly_weightlifted'=>$getmonthly_weightlifted,'getmonthly_gross_weightlifted'=>$getmonthly_gross_weightlifted]);
    }    

    public function ForbiddenPage(Request $request)
    {
        return view('forbidden');
    }
    
}
