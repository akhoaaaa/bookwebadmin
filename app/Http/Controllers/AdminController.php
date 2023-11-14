<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
   public function index(){
    return view('admin_login');
   }
   public function show_dashboard(){
      if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
         return view('admin.dashboard');
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
   public function logout(){
            Session::put('username',null);
            Session::put('id',null);
            return Redirect::to ('/admin');
   }


}
