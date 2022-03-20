<?php

namespace App\Http\Controllers;

use App\Models\Region;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $regionArray = "";
        $regionNameArray = "";
        $regions = Region::all();
        for ($i = 0; $i < count($regions); $i++) {
            if ($i == count($regions) - 1) {
                $regionArray .= $regions[$i]->id;
                $regionNameArray .= $regions[$i]->name;
            } else {
                $regionArray .= $regions[$i]->id . ',';
                $regionNameArray .= $regions[$i]->name . ',';
            }
        }
        return view('home', compact("regionArray", "regionNameArray"));
    }
}
