<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello() {
        return 'Hello World';
    }

    // // Menampilkan View dari Controller
    // public function greeting(){
    //     return view('blog.hello', ['name' => 'Natha']) 
    //         . '<br>(menampilkan view dari controller)';
    // }

    // Meneruskan data ke view
    public function greeting(){
        return view('blog.hello')
            ->with('name','Natha')
            ->with('occupation','Astronaut');
    }
}
