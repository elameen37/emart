<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeSliderController extends Controller {

    public function HomeSlider() {

        $homeslider = HomeSlider::find(1);
        return view('admin.home_slider.home_slider_all', compact('homeslider'));
        

    } // End Method

    public function UpdateSlider(Request $request){

        if ($request->file('home_slider')) {  // Fix: Added closing parenthesis
    
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('home_slider')->getClientOriginalExtension();
            $img = $manager->read($request->file('home_slider'));
            $img->resize(636, 852);
    
            $img->toPng(80)->save(base_path('public/upload/home_slider/'.$name_gen));  // Fix: Changed ->( to ->save(
    
            $save_url = 'upload/home_slider/'.$name_gen;
    
            HomeSlider::findOrFail($request->id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_slider' => $save_url,
            ]);
    
            $notification = array(
                'message' => 'Home Slide Updated with Image Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
    
        } // End If

        else {
    
            HomeSlider::findOrFail($request->id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
            ]);
    
            $notification = array(
                'message' => 'Home Slide Updated without Image Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
    
        } // End Else
    
    } // End Method
    







}