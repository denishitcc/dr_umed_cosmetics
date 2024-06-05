<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $locations = Locations::get();
        return view('timetable.index',compact('locations'));
    }
}
