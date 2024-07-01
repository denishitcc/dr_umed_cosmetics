<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkingHoursResource;
use App\Models\Locations;
use App\Models\Timetable;
use App\Models\Workinghours;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Time;

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

    public function saveTimetable(Request $request)
    {
        $data       = $request->all();
        $days       = $request->days;
        $weekdays   = $request->weekdays;

        try {
            $period = CarbonPeriod::create($days['start_date'], '1 days', $days['end_date']);

            $timedata = [
                'staff_id'      => $request->staff_id,
                'start_date'    => $days['start_date'],
                'end_date'      => $days['end_date']
            ];
            $time = Timetable::create($timedata);

            foreach( $period as $key => $day ){

                $particularDay = $day->format('l');

                foreach ($weekdays as $key => $week) {

                    if($week['day_name'] == $particularDay)
                    {
                        $timetable_data[] = [
                            'staff_id'              => $request->staff_id,
                            'timetable_id'          => $time->id,
                            'working_status'        => Workinghours::WORKING,
                            'calendar_date'         => $day->format('Y-m-d'),
                            'working_start_time'    => $week['start_time'],
                            'working_end_time'      => $week['end_time']
                        ];
                    }
                }
            }
            $data  = Workinghours::insert($timetable_data);
            $response = [
                'success'   => true,
                'message'   => 'Timetable created successfully!',
                'type'      => 'success',
            ];
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => $th->getMessage(),
                'type'    => 'fail',
            ];
        }

        return $response;
    }

    /**
     * Method getUserTimetable
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function getUserTimetable($id)
    {
        $timetable          = Timetable::where('staff_id',$id)->get();
        $timetablehtml      = view('timetable.partials.timetable-list', ['timetable' => $timetable])->render();

        return response()->json([
            'status'        => true,
            'message'       => 'Timetable found.',
            'timetable'     => $timetablehtml,
        ], 200);
    }
}
