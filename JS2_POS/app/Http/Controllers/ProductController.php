<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function food_beverage()
    {
        return view('page.food_beverage');
    }
    public function beauty_health()
    {
        return view('page.beauty_health');
    }
    public function home_care()
    {
        return view('page.home_care');
    }
    public function baby_kid()
    {
        return view('page.baby_kid');
    }
}