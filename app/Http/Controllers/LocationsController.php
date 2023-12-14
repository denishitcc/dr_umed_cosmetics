<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locations;
use App\Models\BusinessWorkingHours;

class LocationsController extends Controller
{
    public function index()
    {
        $locations = Locations::all();
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string',
            'phone' => 'required|string',
            'email_address' => 'required|string',
        ]);

        $newLocation = Locations::create([
            'location_name' => $request->location_name,
            'phone' => $request->phone,
            'email'=> $request->email_address
        ]);
        dd($request->get('days'));
        foreach ($request->get('days') as $key => $value) 
        {
            if(isset($value) && $value != "")
            {
                if(isset($value['check_days']))
                {
                    $working_hours = BusinessWorkingHours::create([
                        'location_id' => $newLocation->id,
                        'day' => $value['check_days'],
                        'start_time'=> $value['start_time'],
                        'end_time'=> $value['to_time'],
                        'day_status'=> isset($value['check_status'])?'Open':'Close'
                    ]);
                }
            }
        }
        if($newLocation){
            $response = [
                'success' => true,
                'message' => 'Location Created successfully!',
                'type' => 'success',
                'data_id' => $newLocation->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function show(Request $request,$id)
    {
        
        $locations = Locations::find($id);
        // dd($locations);
        $working_hours_location = Locations::join('business_working_hours', 'business_working_hours.location_id', '=', 'locations.id')
        ->where('business_working_hours.location_id',$id)
        ->get();
        // dd($locations);
        return view('locations.edit', compact('locations','working_hours_location'));
    }
    // public function edit(Request $request)
    // {
        
    // }
    public function update(Request $request, Locations $loc)
    {
        $request->validate([
            'location_name' => 'required|string',
            'phone' => 'required|string',
            'email_address' => 'required|string',
        ]);

        $locations = Locations::updateOrCreate(['id' => $request->id],[
            'location_name' => $request->location_name,
            'phone' => $request->phone,
            'email'=> $request->email_address
        ]);

        BusinessWorkingHours::where('location_id', $request->id)->delete();
        foreach ($request->get('days') as $key => $value) 
        {
            if(isset($value) && $value != "")
            {
                
                if(isset($value['check_days']))
                {
                    $working_hours = BusinessWorkingHours::create([
                        'location_id' => $request->id,
                        'day' => $value['check_days'],
                        'start_time'=> $value['start_time'],
                        'end_time'=> $value['to_time'],
                        'day_status'=> isset($value['check_status'])?'Open':'Close'
                    ]);
                }
            }
        }

        if($locations){
            $response = [
                'success' => true,
                'message' => 'Location Updated successfully!',
                'type' => 'success',
                'data_id' => $locations->id
            ];
        }else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }
    public function destroy(Request $request)
    {
        Locations::find($request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Location deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
    

        return response()->json($response);
    }
}
