<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function demoLanding()
    {
        # TODO: Read in GET params, display to user
        # TODO: API endpoint to retrieve method choices
        # TODO: API endpoint to choose method
        # TODO: Redirect client to real payment thing
    }


}
