<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        return 'Selamat Datang';
    }

    public function about() {
        return 'NIM : 2341760131 <br> Nama : An Naastasya Sakina';
    }

    public function articles($id) {
        return 'Halaman Artikel dengan id ' . $id;
    }
}