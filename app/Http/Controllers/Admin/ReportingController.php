<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Company;
use App\Models\Site\BookingInfo;
use App\Models\Site\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Response;
use App\Models\Admin\Discount;

class ReportingController extends Controller
{
    public function hotel_report(){
        $booking_infos = array();
        $no_record = '';
        $all_companies = Company::select('user_id', 'name')->get();
        $all_users = User::select('id', 'name')->where('type','=', 'individual')->get();
        return view('admin-panel/reporting/hotel_report', compact('all_companies','all_users','booking_infos','no_record'));
    }
    public function get_hotel_report(Request $request){

        $all_companies = Company::select('user_id', 'name')->get();
        $all_users = User::select('id', 'name')->where('type','=', 'individual')->get();
        $hotel = $request->input('hotel') ? $request->input('hotel') : array();
        $user = $request->input('user') ? $request->input('user') : array();

        $start_date = Carbon::parse($request->input('report_start_date'));
        $end_date = Carbon::parse($request->input('report_end_date'));
        $status = $request->input('status');
        $bookings = (new BookingInfo())->newQuery();
        if(count($hotel) > 0){
            $bookings->whereIn('hotel_owner_id', $hotel);            
        }
        if(count($user) > 0){
            $bookings->whereIn('user_id', $user);            
        }
        if($request->filled('status')){
            $bookings->where('status', '=', $status);
        }
        $bookings->where('start_date', '>=', $start_date);
        $bookings->where('end_date', '<=', $end_date);
        $booking_infos = $bookings->get();

        $no_record = '';
        if(count($booking_infos) < 1){
            $no_record = 'No record found';
        }
        return view('admin-panel/reporting/hotel_report', compact('booking_infos','start_date','end_date','no_record','all_companies','all_users'));
    }

    public function download_pdf_report(Request $request){
        $report_data = json_decode($request->input('report_data'));
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $pdf = PDF::loadView('admin-panel/reporting/pdf', compact('report_data','start_date','end_date'));
        return $pdf->download('report.pdf');
    }

    public function download_excel_report(Request $request)
    {
        $report_data = json_decode($request->input('report_data'));
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=report.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
        );

        $columns = array('Sr#', 'Customer Name', 'Customer Email', 'Name of Meeting', 'Venue Name', 'Space Name', 'Start Date','End Date', 'Amount', 'Status');

        $callback = function() use ($report_data, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($report_data as $key=>$booking) {
                if($booking->status == 0){
                    $status = "Pending";
                }elseif ($booking->status == 1){
                    $status = "Approved";
                }elseif ($booking->status == 2){
                    $status = "Cancelled";
                }
                $venue_title = get_venue_title($booking->venue_id);
                $space_title = get_space_title($booking->space_id);

                fputcsv($file, array($key+1, get_user_name($booking->user_id), 
                get_user_email($booking->user_id), 
                $booking->purpose,
                    $venue_title,
                    $space_title,
                date('d M Y', strtotime($booking->start_date)), 
                date('d M Y', strtotime($booking->end_date)), 
                'AED '.$booking->grand_total, $status));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function saving_report(){
        $saving_report = array();
        $no_record = '';
        $all_users = User::select('id', 'name')->where('type', 'individual')->get();
        return view('admin-panel/reporting/saving_points_report', compact('all_users','saving_report','no_record'));
    }

    public function get_saving_point_report(Request $request){
        $all_users = User::select('id', 'name')->where('type', 'individual')->get();
        $start_date = $request->has('report_start_date') ? $request->input('report_start_date') : '';
        $end_date = $request->has('report_end_date') ? $request->input('report_end_date') : '';
        $users = $request->has('user') ? $request->input('user') : array();
        $query = (new BookingInfo)->newQuery();
        if(count($users) > 0){
            $query->whereIn('user_id', $users);
        }
        $query->where('status', 1);
        $query->where('start_date', '>=', $start_date);
        $query->where('end_date', '<=', $end_date);
        $saving_report = $query->get();

        $no_record = '';
        if(count($saving_report) < 1){
            $no_record = 'No record found';
        }
        return view('admin-panel/reporting/saving_points_report', compact('saving_report','start_date','end_date','no_record','all_users'));
    }

    /*public function downloadpdf_saving_point_report(Request $request){
        $report_data = json_decode($request->input('report_data'));
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $pdf = PDF::loadView('admin-panel/reporting/savingpdf', compact('report_data','start_date','end_date'));
        return $pdf->download('report.pdf');
    }*/

    public function user_sale_report(){
        $booking_infos = array();
        $no_record = '';
        $all_category = Discount::all();
        $all_users = User::select('id', 'name')->where('type', 'individual')->where('activated', 1)->get();
        return view('admin-panel/reporting/user_sale_report', compact('all_users','booking_infos', 'all_category' ,'no_record'));
    }

    public function get_usersale_report(Request $request){
        $no_record = '';
        $sales = array();
        $all_category = Discount::all();
        $all_users = User::select('id', 'name')->where('type', 'individual')->where('activated', 1)->get();
        $user = $request->input('user') ? $request->input('user') : array();
        $user_category = $request->input('user_category');
        $start_date = Carbon::parse($request->input('report_start_date'));
        $end_date = Carbon::parse($request->input('report_end_date'));
        if(count($user) > 0 && $user_category != null){
            $user_in_category = 0;
            $user_filter = array();
            foreach ($user as $row){
                if(user_batch_category($row) == $user_category) {
                    $user_in_category++;
                    array_push($user_filter, $row);
                }
            }
            $user = $user_filter;
            if($user_in_category == 0){
                $no_record = 'No record found';
                return view('admin-panel/reporting/user_sale_report', compact('sales','no_record','all_users', 'all_category'));
            }
        }else if(count($user) == 0 && $user_category != null){
            $distinct_users = BookingInfo::select('user_id')->distinct()->where('status', 1)->whereDate('end_date', '<=', Carbon::today())->get();
            $user = array();
            foreach ($distinct_users as $distinct){
                //echo 'User in:- '.user_batch_category($distinct->user_id).' Given is:- '. $user_category.'<br />';
                if(user_batch_category($distinct->user_id) == $user_category) {
                    array_push($user, $distinct->user_id);
                }
            }
            //dd($distinct_users);
            if(count($user) == 0){
                $no_record = 'No record found';
                return view('admin-panel/reporting/user_sale_report', compact('sales','no_record','all_users', 'all_category'));
            }
        }

        $user_sale = (new BookingInfo())->newQuery();
        if(count($user) > 0){
            $user_sale->whereIn('user_id', $user);
        }else{
            $user_sale->where('user_id','!=', 0);
        }
        $user_sale->where('start_date', '>=', $start_date);
        $user_sale->where('end_date', '<=', $end_date);
        $user_sale->where('status', 1)->whereDate('end_date', '<=', Carbon::today());
        $sales = $user_sale->get();

        if(count($sales) < 1){
            $no_record = 'No record found';
        }
        return view('admin-panel/reporting/user_sale_report', compact('sales','no_record','all_users', 'all_category'));
    }

    public function hotel_sale_report(){
        $hotel_sales = array();
        $no_record = '';
        $all_companies = Company::select('user_id', 'name')->get();
        return view('admin-panel/reporting/hotel_sale_report', compact('all_companies','hotel_sales','no_record'));
    }

    public function get_hotelsale_report(Request $request){

        $all_companies = Company::select('user_id', 'name')->get();
        $start_date = Carbon::parse($request->input('report_start_date'));
        $end_date = Carbon::parse($request->input('report_end_date'));
        $hotel = $request->input('hotel') ? $request->input('hotel') : array();
        $status = $request->input('status');
        $hotel_sale = (new BookingInfo())->newQuery();
        if(count($hotel) > 0){
            $hotel_sale->whereIn('hotel_owner_id', $hotel);
        }
        if($status != null){
            $hotel_sale->where('status', $status);
        }
        $hotel_sale->where('start_date', '>=', $start_date);
        $hotel_sale->where('end_date', '<=', $end_date);
        $sales = $hotel_sale->get();

        $no_record = '';
        if(count($sales) < 1){
            $no_record = 'No record found';
        }
        return view('admin-panel/reporting/hotel_sale_report', compact('sales','start_date','end_date','no_record','all_companies'));
    }
}
