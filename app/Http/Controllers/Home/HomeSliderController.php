<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;

class HomeSliderController extends Controller {

    public function HomeSlider() {

        $homeslider = HomeSlider::find(1);
        return view('admin.home_slider.home_slider_all', compact('homeslider'));
        

    } // End Method
}
