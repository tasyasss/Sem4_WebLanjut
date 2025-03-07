<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user($id, $name)
    {
        return view('page.user')
            ->with('id', $id)
            ->with('name', $name);
    }
}