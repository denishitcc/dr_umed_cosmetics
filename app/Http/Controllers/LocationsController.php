<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locations;
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
        return view('locations.edit', compact('locations'));
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
