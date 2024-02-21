<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Clients;
use App\Models\ClientsPhotos;
use App\Models\ClientsDocuments;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Clients::all();
        if ($request->ajax()) {
            $data = Clients::select('*');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('autoId', function ($row) {
                    $lastuserId = $row->id;
                    $lastIncreament = substr($lastuserId, -3);
                    $newUserId = str_pad($lastIncreament, 3, 0, STR_PAD_LEFT);
                    $row->autoId = $newUserId;
                    return $row->autoId;
                })
                ->addColumn('username', function ($row) {
                    return $row->firstname.' '.$row->lastname;
                })
                ->addColumn('date_and_time', function ($row) {
                    return date('d/m/Y  H:i:s', strtotime($row->created_at));
                })
                ->addColumn('addresses', function ($row) {
                    return $row->street_address.', '.$row->suburb. ', '.$row->city.', '.$row->postcode;
                })
                ->addColumn('status_bar', function($row){
                    if($row->status == 'active')
                    {
                        $row->status_bar = 'checked';
                    }
                    return $row->status_bar;
                })
                ->make(true);

        }
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newUser = Clients::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'date_of_birth' => $request['date_of_birth'],
            'gender' => $request['gender'],
            'mobile_number' => $request->phone_type == 'Mobile' ? $request->phone : $request['mobile_number'],
            'home_phone' => $request->phone_type == 'Home' ? $request->phone : $request['home_phone'],
            'work_phone' => $request->phone_type == 'Work' ? $request->phone : $request['work_phone'],
            'contact_method' => $request['contact_method'],
            'send_promotions' => $request['send_promotions'],
            'street_address' => $request['street_address'],
            'suburb' => $request['suburb'],
            'city' => $request['city'],
            'postcode' => $request['postcode']
        ]);
        
        if(isset($request->pics))
        {
            foreach($request->pics as $pics)
            {
                // dd($pics);
                $folderPath = storage_path('app/public/images/clients_photos/');
                $image_parts = explode(";base64,", $pics);
                // dd($image_parts);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $uniqid = uniqid();
                $file = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $photo = ClientsPhotos::create([
                    'client_id' => $newUser->id,
                    'client_photos' => $uniqid . '.' . $image_type
                ]);
            }
        }
        if(isset($request->docs))
        {
            foreach($request->docs as $docs)
            {
                $folderPath = storage_path('app/public/images/clients_documents/');
                $image_parts = explode(";base64,", $docs);
                // dd($image_parts);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $uniqid = uniqid();
                $file = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $photo = ClientsDocuments::create([
                    'client_id' => $newUser->id,
                    'client_documents' => $uniqid . '.' . $image_type
                ]);
            }
        }
        
        $response = [
            'success' => true,
            'message' => 'Client Created successfully!',
            'type' => 'success',
            'data' => $newUser
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Clients::where('id',$id)->first();
        // dd($client);
        $client_photos = ClientsPhotos::where('client_id',$client->id)->get();
        $client_documents = ClientsDocuments::where('client_id',$client->id)->get();
        // dd($client_photos);
        return view('clients.edit',compact('client','client_photos','client_documents'));
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
        $newUser = Clients::updateOrCreate(['id' => $request->id],[
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            // 'email' => $request['email'],
            'date_of_birth' => $request['date_of_birth'],
            'gender' => $request['gender'],
            'mobile_number' => $request['mobile_number'],
            'home_phone' => $request['home_phone'],
            'work_phone' => $request['work_phone'],
            'contact_method' => $request['contact_method'],
            'send_promotions' => $request['send_promotions'],
            'street_address' => $request['street_address'],
            'suburb' => $request['suburb'],
            'city' => $request['city'],
            'postcode' => $request['postcode']
        ]);
        $response = [
            'success' => true,
            'message' => 'Client Updated successfully!',
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
    public function checkClientEmail(Request $request){
        $email = $request->input('email');
        $isExists = Clients::where('email',$email)->first();
        if($isExists){
            return response()->json(array("exists" => true));
        }else{
            return response()->json(array("exists" => false));
        }
    }
    public function updateStatus(Request $request){
        $chk = $request->input('chk');
        if($chk == 'checked')
        {
            $status= 'deactive';
        }
        else
        {
            $status='active';
        }
        $id = $request->input('id');
        $isExists = Clients::where('id',$id)->first();
        if($isExists){
            $newUser = Clients::where('id',$id)->update(['status'=>$status]);
        }
        if($newUser){
            $response = [
                'success' => true,
                'message' => 'Client Status Updated successfully!',
                'type' => 'success',
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
    public function updatePhotos(Request $request)
    {
        if(isset($request->pics))
        {
            foreach($request->pics as $pics)
            {
                $file = $pics;
                $destinationPath = storage_path('app/public/images/clients_photos');
                $file->move($destinationPath,$file->getClientOriginalName());   
                $photo = ClientsPhotos::create([
                    'client_id' => $request->id,
                    'client_photos' => $file->getClientOriginalName(),
                ]);
            }
        }
        $response = [
            'success' => true,
            'message' => 'Client Photos Updated successfully!',
            'type' => 'success',
        ];
        return response()->json($response);
    }
    public function updateDocuments(Request $request)
    {
        $insertedIds = []; // Array to hold the inserted IDs
        if(isset($request->pics))
        {
            foreach($request->pics as $pics)
            {
                $file = $pics;
                $destinationPath = storage_path('app/public/images/clients_documents');
                $file->move($destinationPath,$file->getClientOriginalName());   
                $photo = ClientsDocuments::create([
                    'client_id' => $request->id,
                    'client_documents' => $file->getClientOriginalName(),
                ]);
                // Add the inserted ID to the array
                $insertedIds[] = $photo->id;
            }
        }
        $response = [
            'success' => true,
            'message' => 'Client Documents Updated successfully!',
            'type' => 'success',
            'client_id' => $insertedIds // Include the client ID in the response
        ];
        return response()->json($response);
    }
    public function removeDocuments(Request $request)
    {
        // dd($request->all());
        ClientsDocuments::where('id',$request->doc_id)->where('client_id',$request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Location deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
        return response()->json($response);
    }
    public function removePhotos(Request $request)
    {
        // dd($request->all());
        ClientsPhotos::where('id',$request->photo_id)->where('client_id',$request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Client deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];
        return response()->json($response);
    }
}
