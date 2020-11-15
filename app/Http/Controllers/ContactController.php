<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Slider;
use App\Contact;
use App\Video;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ContactController extends Controller
{
    public function lien_he(Request $request){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $video = Video::orderBy('video_id','desc')->take(4)->get();
        //seo
        $meta_desc = "Liên hệ";
        $meta_keywords = "Liên hệ";
        $meta_title = "Liên hệ với chúng tôi";
        $url_canonical = $request->url();
        //--seo

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.lienhe.contact')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('video',$video);
    }


}
