<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Services;
use App\Models\User;
use App\Repositories\CalendarRepository;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\ClientsPhotos;
use App\Models\ClientsDocuments;

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
        if($services)
        {
            foreach ($services as $value) {
                $data[] = [
                    'id'            => $value['id'],
                    'service_name'  => $value['service_name']
                ];
            }
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

    /**
     * Method getAllClients
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getAllClients(Request $request)
    {
        $clients = Clients::where('firstname', 'like', '%' . $request->name . '%')->get();
        $data = [];
        
        foreach ($clients as $client) {
            $clientData = [
                'id'              => $client->id,
                'first_name'      => $client->firstname,
                'last_name'       => $client->lastname,
                'email'           => $client->email,
                'mobile_no'       => $client->mobile_number,
                'date_of_birth'   => $client->date_of_birth,
                'gender'          => $client->gender,
                'home_phone'      => $client->home_phone,
                'work_phone'      => $client->work_phone,
                'contact_method'  => $client->contact_method,
                'send_promotions' => $client->send_promotions,
                'street_address'  => $client->street_address,
                'suburb'          => $client->suburb,
                'city'            => $client->city,
                'postcode'        => $client->postcode,
                'client_photos'   => [],
                'client_documents'   => []
            ];

            // Fetch client photos for the current client
            $clientPhotos = ClientsPhotos::where('client_id', $client->id)->get();
            foreach ($clientPhotos as $photo) {
                $clientData['client_photos'][] = $photo->client_photos;
            }
            // Fetch client documents for the current client
            $clientDocuments = ClientsDocuments::where('client_id', $client->id)->get();
            foreach ($clientDocuments as $doc) {
                $clientData['client_documents'][] = [
                    'doc_id'     => $doc->id,
                    'doc_name'   => $doc->client_documents,  // Assuming the field name is 'doc_name'
                    'created_at' => $doc->created_at  // Assuming the field name is 'created_at'
                ];
            }
            $data[] = $clientData;
        }

        return response()->json($data);
    }
}
