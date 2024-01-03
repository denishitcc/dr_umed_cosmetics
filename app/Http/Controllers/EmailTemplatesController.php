<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\EmailTemplates;

class EmailTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $email_templates = EmailTemplates::all();
        if ($request->ajax()) {
            $data = EmailTemplates::select('*');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){
                        $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                        return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);

        }
        return view('email_templates.index', compact('email_templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('email_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newUser = EmailTemplates::create([
            'email_template_type' => $request->email_template_type,
            'email_template_description' => $request->email_template_description
        ]);
        $response = [
            'success' => true,
            'message' => 'Email Template Created successfully!',
            'type' => 'success',
        ];
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
