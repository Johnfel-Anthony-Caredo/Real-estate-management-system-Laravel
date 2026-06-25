<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prop\Property;

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
    public function index()
    {
        // Fetch properties to display on the home page
        $props = Property::select()->take(9)->orderBy('created_at', 'desc')->get();
        
        return view('home', compact('props'));
    }
}
