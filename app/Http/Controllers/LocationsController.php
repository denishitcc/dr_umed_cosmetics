<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locations;
use App\Models\BusinessWorkingHours;
use DataTables;
use App\Models\LocationSurcharge;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('locations');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $locations = Locations::all();
            if ($request->ajax()) {
                // if($request->search != '')
                // {
                //     $data = Locations::where('location_name','LIKE','%'.$request->search.'%')
                //             ->orWhere('phone','LIKE','%'.$request->search.'%')
                //             ->orWhere('email','LIKE','%'.$request->search.'%')
                //             ->orWhere('street_address','LIKE','%'.$request->search.'%')
                //             ->orWhere('suburb','LIKE','%'.$request->search.'%')
                //             ->orWhere('city','LIKE','%'.$request->search.'%')
                //             ->orWhere('state','LIKE','%'.$request->search.'%')
                //             ->orWhere('postcode','LIKE','%'.$request->search.'%')
                //             ->orWhere('latitude','LIKE','%'.$request->search.'%')
                //             ->orWhere('longitude','LIKE','%'.$request->search.'%')
                //     ->get();
                // }
                // else if($request->pagination != '')
                // {
                //     $data = Locations::paginate(10, ['*'], 'page', $request->pagination);
                //     // dd($data);
                // }
                // else
                // {
                    $data = Locations::select('*');
                // }
                
                // dd($data);
                return Datatables::of($data)

                        ->addIndexColumn()

                        ->addColumn('action', function($row){
                                $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                                return $btn;
                        })
                        ->addColumn('street_addresses', function ($row) { 
                            return $row->street_address.' '.$row->suburb.' '.$row->suburb.' '.$row->city.' '.$row->state.' '.$row->postcode;
                        })
                        ->rawColumns(['action'])

                        ->make(true);

            }
            return view('locations.index', compact('locations'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    public function create()
    {
        $permission = \Auth::user()->checkPermission('locations');
        if ($permission === 'View & Make Changes' || $permission === true) {
            return view('locations.create');
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'location_name' => 'required|string',
            'phone' => 'required|string',
            'email_address' => 'required|string',
        ]);

        $newLocation = Locations::create([
            'location_name' => $request->location_name,
            'phone' => $request->phone,
            'email'=> $request->email_address,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'city'=> $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'latitude'=> $request->latitude,
            'longitude'=> $request->longitude,
        ]);
        // dd($newLocation->id);
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
        foreach ($request->surcharge_type as $key => $value) {
            if(isset($value) && $value != "") {
                // Assuming $request->discount_percentage[$key] corresponds to the discount percentage for each discount type
                $surchargePercentage = $request->surcharge_percentage[$key];
        
                $sur_type = LocationSurcharge::create([
                    'location_id' => $newLocation->id,
                    'surcharge_type' => $value,
                    'surcharge_percentage'=> $surchargePercentage,
                ]);
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
        $permission = \Auth::user()->checkPermission('locations');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $locations = Locations::find($id);
            $working_hours_location = Locations::join('business_working_hours', 'business_working_hours.location_id', '=', 'locations.id')
            ->where('business_working_hours.location_id',$id)
            ->get();

            $loc_surcharge = LocationSurcharge::where('location_id',$id)->get();

            return view('locations.edit', compact('locations','working_hours_location','loc_surcharge'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
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
            'email'=> $request->email_address,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'city'=> $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'latitude'=> $request->latitude,
            'longitude'=> $request->longitude,
        ]);
        LocationSurcharge::where('location_id', $request->id)->delete();
        
        foreach ($request->surcharge_type as $key => $sur_value) {
            if(isset($sur_value) && $sur_value != "") {
                // Assuming $request->surcharge_percentage[$key] corresponds to the surcharge percentage for each surcharge type
                $surchargePercentage = $request->surcharge_percentage[$key];
                
                // Use the index of the loop as the ID to update or create a new record
                $sur_type = LocationSurcharge::create(
                    // ['id' => $key + 1, 'location_id' => $request->id], // Use key + 1 as ID to avoid updating the same record
                    [
                        'location_id' => $request->id,
                        'surcharge_type' => $sur_value,
                        'surcharge_percentage' => $surchargePercentage,
                    ]
                );
            }
        }        

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
