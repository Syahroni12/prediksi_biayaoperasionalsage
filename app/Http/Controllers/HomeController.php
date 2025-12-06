<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        return view('dashboard', compact('title'));
    }

    public function prediksi()
    {
        $title = 'Prediksi';
        return view('prediksi', compact('title'));
    }
}
