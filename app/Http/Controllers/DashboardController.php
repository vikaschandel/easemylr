<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsignmentNote;
use App\Models\ConsignmentItem;
use Carbon\Carbon;
use DB;
use Auth;

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
        $authuser = Auth::user();
        // $cc = explode(',',$authuser->branch_id);
        if($authuser->role_id == 2){
        $gettoday_lr = $query->where('user_id',$authuser->id)
                        ->whereDate('created_at', '=', date('Y-m-d'))
                        ->where('status', '1')
                        ->toSql();
                        // dd($gettoday_lr);
        $getcurrentmonth_lr = ConsignmentNote::where('created_at', '>=', date('Y-m-01'))
                        ->where('user_id',$authuser->id)
                        ->where('status', 1)
                        ->count();

        // $today_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-d'))
        //                 ->where('status', '=', 1)
        //                 ->sum('weight');
        $today_weightlifted = DB::table('consignment_items')->select('consignment_items.*', 'consignment_notes.id as consignment_id')
                        ->join('consignment_notes', 'consignment_notes.id', '=', 'consignment_items.consignment_id')
                        ->where('consignment_items.created_at', '>=', date('Y-m-d'))
                        ->where('consignment_items.status', '=', 1)
                        ->where('consignment_notes.user_id',$authuser->id)
                        ->sum('weight');
        $gettoday_weightlifted = $today_weightlifted/1000;              

        // $monthly_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-01'))
        //                 ->where('status', '=', 1)
        //                 ->sum('weight');
        $monthly_weightlifted = DB::table('consignment_items')->select('consignment_items.*', 'consignment_notes.id as consignment_id')
                        ->join('consignment_notes', 'consignment_notes.id', '=', 'consignment_items.consignment_id')
                        ->where('consignment_items.created_at', '>=', date('Y-m-01'))
                        ->where('consignment_items.status', '=', 1)
                        ->where('consignment_notes.user_id',$authuser->id)
                        ->sum('weight');
        $getmonthly_weightlifted = $monthly_weightlifted/1000;

        // $today_gross_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-d'))
        //                 ->where('status', '=', 1)
        //                 ->sum('gross_weight');
        $today_gross_weightlifted = DB::table('consignment_items')->select('consignment_items.*', 'consignment_notes.id as consignment_id')
                        ->join('consignment_notes', 'consignment_notes.id', '=', 'consignment_items.consignment_id')
                        ->where('consignment_items.created_at', '>=', date('Y-m-d'))
                        ->where('consignment_items.status', '=', 1)
                        ->where('consignment_notes.user_id',$authuser->id)
                        ->sum('gross_weight');
        $gettoday_gross_weightlifted = $today_gross_weightlifted/1000;

        // $monthly_gross_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-01'))
        //                 ->where('status', '=', 1)
        //                 ->sum('gross_weight');
        $monthly_gross_weightlifted = DB::table('consignment_items')->select('consignment_items.*', 'consignment_notes.id as consignment_id')
                        ->join('consignment_notes', 'consignment_notes.id', '=', 'consignment_items.consignment_id')
                        ->where('consignment_items.created_at', '>=', date('Y-m-01'))
                        ->where('consignment_items.status', '=', 1)
                        ->where('consignment_notes.user_id',$authuser->id)
                        ->sum('gross_weight');
        $getmonthly_gross_weightlifted = $monthly_gross_weightlifted/1000;
        }else{
            $gettoday_lr = $query->whereDate('created_at', '=', Carbon::today())
                        ->where('status', '1')
                        ->count();
            $getcurrentmonth_lr = ConsignmentNote::where('created_at', '>=', date('Y-m-01'))
                        ->where('status', 1)
                        ->count();

            $today_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-d'))
                        ->where('status', '=', 1)
                        ->sum('weight');
            $gettoday_weightlifted = $today_weightlifted/1000; 

            $monthly_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-01'))
                        ->where('status', '=', 1)
                        ->sum('weight');
            $getmonthly_weightlifted = $monthly_weightlifted/1000;

            $today_gross_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-d'))
                        ->where('status', '=', 1)
                        ->sum('gross_weight'); 
            $gettoday_gross_weightlifted = $today_gross_weightlifted/1000; 
            
            $monthly_gross_weightlifted = ConsignmentItem::where('created_at', '>=', date('Y-m-01'))
                        ->where('status', '=', 1)
                        ->sum('gross_weight');
            $getmonthly_gross_weightlifted = $monthly_gross_weightlifted/1000;
        }

        return view('dashboard',['prefix'=>$this->prefix,'title'=>$this->title,'gettoday_lr'=>$gettoday_lr,'gettoday_weightlifted'=>$gettoday_weightlifted,'gettoday_gross_weightlifted'=>$gettoday_gross_weightlifted,'getcurrentmonth_lr'=>$getcurrentmonth_lr,'getmonthly_weightlifted'=>$getmonthly_weightlifted,'getmonthly_gross_weightlifted'=>$getmonthly_gross_weightlifted]);
    }

    public function ForbiddenPage(Request $request)
    {
        return view('forbidden');
    }
    
}
