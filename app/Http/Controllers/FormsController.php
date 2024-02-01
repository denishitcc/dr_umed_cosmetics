<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormSummary;
use DataTables;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $forms = FormSummary::all();
        if ($request->ajax()) {
            $data = FormSummary::select('*');
            return Datatables::of($data)
                
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                    return $btn;
            })
            ->make(true);

        }
        return view('forms.index', compact('forms'));
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
        $user = Auth::user();
        $forms = FormSummary::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'by_whom' => $user->first_name.' '.$user->last_name
        ]);
        if($forms){

            $response = [
                'success' => true,
                'message' => 'Form Created successfully!',
                'type' => 'success',
                'data_id' => $forms->id
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
