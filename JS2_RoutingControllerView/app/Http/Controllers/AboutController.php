<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about()
    {
        return 'NIM : 2341760131 <br> Nama : An Naastasya Sakina 
            <br> (dengan single action controller)';
    }
}