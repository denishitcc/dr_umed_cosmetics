<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\UserRoles;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('settings');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $user_role = UserRoles::all();
            if ($request->ajax()) {
                $data = UserRoles::select('*');
                return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                            return $btn;
                    })

                    ->rawColumns(['action'])

                    ->make(true);

            }
            return view('user_role.index', compact('user_role'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = \Auth::user()->checkPermission('settings');
        if ($permission === 'View & Make Changes' || $permission === true) {
            return view('user_role.create');
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newUser = UserRoles::create([
            'role_name' => $request->role_name,
        ]);
        if($newUser){

            $response = [
                'success' => true,
                'message' => 'User Role Created successfully!',
                'type' => 'success',
                'data_id' => $newUser->id
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = \Auth::user()->checkPermission('settings');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $users = UserRoles::find($id);
            return view('user_role.edit', compact('users'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
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
        $newUser = UserRoles::updateOrCreate(['id' => $request->id],[
            'role_name' => $request->role_name,
        ]);
        if($newUser){
            $response = [
                'success' => true,
                'message' => 'User Updated successfully!',
                'type' => 'success',
                'data_id' => $newUser->id
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        UserRoles::find($request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'User deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
    

        return response()->json($response);
    }
}
