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
    }
    // public function show(Task $task)
    // {
    //     return view('tasks.show', compact('task'));
    // }
    // public function edit(Task $task)
    // {
    //     return view('tasks.edit', compact('task'));
    // }
    // public function update(Request $request, Task $task)
    // {
    //     // Validation and task update logic
    // }
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
