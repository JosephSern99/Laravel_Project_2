<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
	 
     */
	 
	 public function loggedin()
    {	
		$date = now()->format("d-m-Y");
		
        return view('signin', compact("date"));
    }

	
	 
    public function index()
    {
        return view('home');
    }
}
