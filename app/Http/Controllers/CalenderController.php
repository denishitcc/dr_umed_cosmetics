<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Services;
use App\Models\User;
use App\Repositories\CalendarRepository;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    // /** @var \App\Repositories\CalendarRepository $repository */
    // protected $repository;

    // public function __construct(CalendarRepository $repository)
    // {
    //     $this->repository = $repository;
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with([
                            'children'
                        ])->whereNull('parent_category')->get();

        $services   = Services::get();

        return view('calender.index')->with(
            [
                'categories' => $categories,
                'services'   => $services
            ]
        );
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
     * Method getCategoryServices
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getCategoryServices(Request $request)
    {
        $services   = Services::select();

        if ($request->category_id) {
            $services->where('parent_category', $request->category_id);
        }

        $services = $services->get();

        $data       = [];

        foreach ($services as $value) {
            $data[] = [
                'id'            => $value['id'],
                'service_name'  => $value['service_name']
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
