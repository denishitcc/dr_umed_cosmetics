<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkingHoursResource;
use App\Models\Locations;
use App\Models\Workinghours;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeTableController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $locations = Locations::get();
        return view('timetable.index', compact('locations'));
    }

    /**
     * Method updateWorkingHours
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updateWorkingHours(Request $request)
    {
        $data = $request->all();
        // dd($data);
        try {
            DB::beginTransaction();
            switch ($data['working_status']) {
                case 0:
                    $workinghours = Workinghours::updateOrCreate(['staff_id' => $data['staff_id'], 'calendar_date' => $data['current_date']], [
                        'working_status'        => $data['working_status']
                    ]);
                    break;
                case 1:
                    $workinghours = Workinghours::updateOrCreate(['staff_id' => $data['staff_id'], 'calendar_date' => $data['current_date']], [
                        'working_status'            => $data['working_status'],
                        'working_start_time'        => $data['working_start_time'],
                        'working_end_time'          => $data['working_end_time'],
                        'lunch_start_time'          => $data['lunch_start_time'],
                        'lunch_duration_minutes'    => $data['lunch_duration_minutes'],
                        'break_start_time'          => $data['break_start_time'],
                        'break_duration'            => $data['break_duration']
                    ]);
                    break;
                case 2:
                    $workinghours = Workinghours::updateOrCreate(['staff_id' => $data['staff_id'], 'calendar_date' => $data['current_date']], [
                        'working_status'        => $data['working_status'],
                        'leave_reason'          => $data['leave_reason'],
                        'leave_start_date'      => $data['current_date'],
                        'leave_end_date'        => $data['current_date'],
                        'calendar_date'         => $data['current_date'],
                    ]);
                    break;
                case 3:
                    # code...
                    break;
                default:
                    # code...
                    break;
            }
            DB::commit();
            $wsatus = [
                'success' => true,
                'message' => 'Working status updated successfully!',
                'type'    => 'success',
            ];
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            DB::rollback();
            $wsatus = [
                'success' => false,
                'message' => $th,
                'type'    => 'fail',
            ];
        }
        return $wsatus;
    }

    /**
     * Method getWorkingHours
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function getWorkingHours(Request $request)
    {
        $data = $request->all();
        try {
            $workinghours = Workinghours::whereBetween('calendar_date',[$data['start_date'],$data['end_date']])->get();

            return response()->json(WorkingHoursResource::collection($workinghours));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
