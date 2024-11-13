<?php

namespace App\Http\Controllers;

Class  WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Welcome',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', ['breadcrumb'=> $breadcrumb, 'activeMenu'=> $activeMenu]);
    }
}