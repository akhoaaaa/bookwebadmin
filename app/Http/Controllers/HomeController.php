<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        $allproduct=DB::table('sanpham')->where('status','1')->orderby('id','desc')->limit(8)->get();
        return view('pages.home')->with('allproduct',$allproduct);
    }
    public function search(Request $request) {
        $keywords = $request->keywords_submit;
        $search_product = DB::table('sanpham')->where('tensp', 'like', '%' . $keywords . '%')->get();

        if ($search_product->isEmpty()) {
            return view('pages.product.search')->with('search_product', $search_product)->with('noResults', true);
        }

        return view('pages.product.search')->with('search_product', $search_product);
    }

}
