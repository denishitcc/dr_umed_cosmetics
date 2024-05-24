<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentForms;
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
        $permission = \Auth::user()->checkPermission('forms');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $forms = FormSummary::all();
            if ($request->ajax()) {
                $data = FormSummary::select('*');
                return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $btn = '<div class="action-box">
                                    <button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'>
                                        <i class="ico-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm black-btn round-6 dt-delete deleteFormBtn" data-formid='.$row->id.' >
                                        <i class="ico-trash"></i>
                                    </button>
                                </div>';
                        return $btn;
                })
                ->make(true);
            }
            return view('forms.index', compact('forms'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
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
        $permission = \Auth::user()->checkPermission('forms');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $forms = FormSummary::find($id);
            return view('forms.edit',compact('forms'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Method formUpdate
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function formUpdate(Request $request)
    {
        $user = Auth::user();
        $forms = FormSummary::find($request->form_id);

        if($forms)
        {
            $data = [
                'title'         => $request->title,
                'description'   => $request->description,
                'status'        => $request->status,
                'by_whom'       => $user->first_name.' '.$user->last_name
            ];

            $updateForms = $forms->update($data);

            if($updateForms){

                $response = [
                    'success' => true,
                    'message' => 'Form updated successfully!',
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
    }

    /**
     * Method formHTMLUpdate
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function formHTMLUpdate(Request $request)
    {
        try {

            $forms  = FormSummary::find($request->form_id);
            $user   = Auth::user();

            if($forms){
                $fdata = [
                    'form_json'     => $request->form_json,
                    'by_whom'       => $user->first_name.' '.$user->last_name
                ];

                $updateForms = $forms->update($fdata);

                $data = [
                    'success' => true,
                    'message' => 'Form updated successfully!',
                    'type' => 'success',
                ];
            }

        } catch (\Throwable $th) {

            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }
        return response()->json($data);

    }

    /**
     * Method formDelete
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function formDelete(Request $request)
    {
        try {
            $forms = FormSummary::find($request->form_id);

            if($forms)
            {
                $forms->delete();
            }

            $data = [
                'success' => true,
                'message' => 'Appointment deleted successfully!',
                'type'    => 'success',
            ];

        } catch (\Throwable $th) {

            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }

        return response()->json($data);
    }

    /**
     * Method formPreview
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function formPreview($id)
    {
        $permission = \Auth::user()->checkPermission('forms');
        if ($permission === 'View & Make Changes' || $permission === true) {
            $forms  = FormSummary::find($id);
            $user   = Auth::user();

            return view('forms.preview',compact('forms','user'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Method formUser
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function formUser($apptid,$id)
    {
        $appointment  = AppointmentForms::where('appointment_id',$apptid)->first();
        $user         = Auth::user();
        $forms        = FormSummary::find($id);

        return view('forms.userform',compact('forms','user','appointment'));
    }

    public function serviceFormUpdate(Request $request)
    {
        try {
            $userdata = [
                'form_user_data'    => $request->form_user_data,
                'status'            => AppointmentForms::IN_PRORESS
            ];

            $appointmentform = AppointmentForms::find($request->appointment_form_id);
            if($appointmentform){
                $appointmentform->update($userdata);
            }
            $data = [
                'success' => true,
                'message' => 'Appointment deleted successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {

            $data = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }

        return response()->json($data);
    }
}
