<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
//use Image;

class AboutController extends Controller {

    public function AboutPage() {

        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutpage'));
    } // End Method

    public function UpdateAbout(Request $request) {

        if ($request->file('about_image')) {  // Fix: Added closing parenthesis

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('about_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('about_image'));
            $img->resize(523, 605);

            $img->toPng(80)->save(base_path('public/upload/home_about/'.$name_gen));  // Fix: Changed ->( to ->save(

            $save_url = 'upload/home_about/'.$name_gen;

            About::findOrFail($request->id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,                
            ]);

            $notification = array(
                'message' => 'About Page  Updated with Image Successfully', 
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        } // End If

        else {

            About::findOrFail($request->id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,                
            ]);

            $notification = array(
                'message' => 'About Page Updated without Image Successfully', 
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        } // End Else        
    } // End Method

    public function HomeAbout(){

        $aboutpage = About::find(1);
        return view('frontend.about_page',compact('aboutpage'));

     }// End Method 
}