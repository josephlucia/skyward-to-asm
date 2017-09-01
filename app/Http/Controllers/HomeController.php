<?php

namespace App\Http\Controllers;

use App\Credential;
use Illuminate\Http\Request;

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
     * Show the configuration home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$credentials = Credential::find(1);

        return view('home', compact('credentials'));
    }

    /**
     * Log the current user out.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        auth()->user()->logout();

        return redirect(url('/home'));
    }
}
