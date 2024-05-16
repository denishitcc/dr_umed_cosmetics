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
        $permission = \Auth::user()->checkPermission('email-templates');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $email_templates = EmailTemplates::all();
            // if ($request->ajax()) {
            //     $data = EmailTemplates::select('*');
            //     return Datatables::of($data)

            //         ->addIndexColumn()

            //         ->addColumn('action', function($row){
            //                 $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
            //                 return $btn;
            //         })

            //         ->rawColumns(['action'])

            //         ->make(true);

            // }
            return view('email_templates.index', compact('email_templates'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('email_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $newUser = EmailTemplates::create([
        //     'email_template_type' => $request->email_template_type,
        //     'subject' => $request->subject,
        //     'email_template_description' => $request->email_template_description
        // ]);
        // $response = [
        //     'success' => true,
        //     'message' => 'Email Template Created successfully!',
        //     'type' => 'success',
        // ];
        // return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = \Auth::user()->checkPermission('email-templates');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $email_templates = EmailTemplates::where('id',$id)->first();
            return view('email_templates.edit', compact('email_templates'));
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
        $email_temp = EmailTemplates::updateOrCreate(['id' => $request->id],[
            // 'email_template_type' => $request->email_template_type,
            'subject' => $request->subject,
            'email_template_description' => $request->email_template_description
        ]);

        $response = [
            'success' => true,
            'message' => 'Email Template Updated successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        EmailTemplates::find($request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Email Template deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
    

        return response()->json($response);
    }
}
