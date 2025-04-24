<?php
 
 namespace App\Http\Controllers;
 
 class WelcomeController extends Controller
 {
     public function index()
     {
         $breadcrumb = (object) [
             'title' => 'Selamat Datang di Pinjem.inBook',
             'list' => ['Home', 'Selamat Datang']
         ];
 
         $activeMenu = 'dashboard';
 
         return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
     }
 }