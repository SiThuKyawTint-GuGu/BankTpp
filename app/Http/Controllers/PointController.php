<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PointController extends Controller
{
    //Point Page
    public function pointpage(){
        return Inertia::render('Point/Point');
    }
}