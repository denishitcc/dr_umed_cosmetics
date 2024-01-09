<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsTemplates;

class SMSTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sms_templates = SmsTemplates::all();
        // dd($sms_templates);
        return view('sms_templates.index', compact('sms_templates'));
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
        $sms_templates = smsTemplates::where('id',$id)->first();
        return view('sms_templates.edit', compact('sms_templates'));
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
        $sms_temp = SmsTemplates::updateOrCreate(['id' => $request->id],[
            // 'email_template_type' => $request->email_template_type,
            // 'subject' => $request->subject,
            'sms_template_description' => $request->sms_template_description
        ]);

        $response = [
            'success' => true,
            'message' => 'SMS Template Updated successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
