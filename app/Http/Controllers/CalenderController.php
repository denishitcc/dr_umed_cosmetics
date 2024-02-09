<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list_parent_cat = Category::where('parent_category','(top-level)')->get();
        return view('calender.index',compact('list_parent_cat'));
    }

    /**
     * Method doctorAppointments
     *
     * @return mixed
     */
    public function doctorAppointments()
    {
        $user = User::where('role_type','!=','admin')->get();
        $data = [];
        foreach ($user as $value) {
            $data[] = [
                'resourceId' => $value['id'],
                'title'      => $value['first_name'].' '.$value['last_name']
            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
