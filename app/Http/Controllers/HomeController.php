<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Mail;
use Illuminate\Support\Facades\Redirect;

session_start();

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //seo
        $meta_desc = "cap nhat...";
        $meta_keywords = "cap nhat";
        $meta_title = "cap nhat";
        $url_canonical = $request->url();
        //--seo
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '1')
            ->orderby('category_id', 'desc')
            ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')
            ->orderby('brand_id', 'desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '0')
            ->orderby('product_id', 'desc')->limit(15)->get();
        return view('pages.home')->with('category', $cate_product)
            ->with('brand', $brand_product)->with('all_product', $all_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')
            ->orderby('brand_id', 'desc')->get();
        $search_product = DB::table('tbl_product')
            ->where('product_name', 'like', '%' . $keywords . '%')->get();
        return view('pages.product.search')->with('category', $cate_product)
            ->with('brand', $brand_product)->with('search_product', $search_product);
    }
}
