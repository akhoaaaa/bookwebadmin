<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
   public function index(){
       if (Session::has('id')&& Session::get('chucnang') === 'quanly'){
           return Redirect::to('dashboard');
       }
    return view('admin_login');
   }
   public function show_dashboard(Request $request){
      if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
          $currentDateTime = Carbon::now();
          $donhang = DB::table('donhang')->count();
          $tong = DB::table('donhang')->whereMonth('create_time','<=', $currentDateTime )->sum('tongtien');
          $users = DB::table('user')->where('chucnang','user')->count();
         return view('admin.dashboard')->with('tong',$tong)->with('donhang',$donhang)->with('user',$users);

      }else{
         return Redirect::to('/admin');

      }
   }
   public function doanhthu(){
       if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
           $currentDateTime = Carbon::now();
           $currentMonth = $currentDateTime->month;
           $currentYear = $currentDateTime->year;
           $currentDay = $currentDateTime->day;
           $months = range(1, 12);

           $thongKeDoanhThu = DB::table('donhang')
               ->select(DB::raw('MONTH(create_time) as month'), DB::raw('SUM(tongtien) as total_revenue'))
               ->groupBy('month')
               ->get();

           $revenues = array_fill_keys($months, 0);
           foreach ($thongKeDoanhThu as $item) {
               $revenues[$item->month] = $item->total_revenue;
           }
           $tong = DB::table('donhang')->where('create_time','<=',$currentDateTime)->sum('tongtien');
           $nam = DB::table('donhang')->whereYear('create_time','=',$currentYear)->sum('tongtien');
           $thang = DB::table('donhang')->whereMonth('create_time','=', $currentMonth )->sum('tongtien');
           $day = DB::table ('donhang')->whereDay('create_time','=',$currentDay)->sum('tongtien');
           return view('admin.doanhthu', [
               'tong' => $tong,
               'nam' => $nam,
               'thang' => $thang,
               'day' => $day,
               'labels' => array_values($months),
               'data' => array_values($revenues),
               'thongKeDoanhThu' => $thongKeDoanhThu,
           ]);
       }else{
           return Redirect::to('/admin');

       }
   }
   public function dashboard(Request $request){
      $admin_email = $request -> email;
      $admin_pass = $request -> pass;

      $result = DB::table('user') -> where('email',$admin_email) -> where('pass',$admin_pass)->first();
      if ($result) {
         Session::put('username',$result -> username);
         Session::put('id',$result -> id);
         Session::put('chucnang',$result -> chucnang);
         if ($result->chucnang === 'quanly'){
             return Redirect::to('/dashboard');
         }else{
             return Redirect::to('/admin');

         }
      }else{
                  Session::put('message','mật khẩu hoặc email không chính xác');
                 return Redirect::to('/admin');
      }
   }
   public function logout_admin(){
            Session::put('username',null);
            Session::put('id',null);
            return Redirect::to ('/admin');
   }


}
