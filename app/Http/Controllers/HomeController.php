<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Group;

class HomeController extends Controller
{
    function index(){
        $groups = Group::all();
        return view('welcome', [
            'groups' => $groups
        ]);
    }
}
