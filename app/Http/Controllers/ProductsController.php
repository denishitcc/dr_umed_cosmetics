<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use App\Models\Locations;
use App\Models\Products;
use DataTables;
use App\Models\ProductsCategories;
use App\Models\ProductAvailabilities;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Products::all();
        $all_product_categories = ProductsCategories::all();
        $locations = Locations::get();
        if ($request->ajax()) {
            $data = Products::all();
            return Datatables::of($data)
            
            ->addIndexColumn()
            ->addColumn('supplier_name', function ($row) {
                $sup = Suppliers::where('id',$row->supplier_id)->first();
                return $sup->business_name;
            })

            ->addIndexColumn()
            ->addColumn('category_name', function ($row) {
                $cat = ProductsCategories::where('id',$row->category_id)->first();
                return $cat->category_name;
            })

            ->addIndexColumn()
            ->addColumn('margin', function ($row) {
                $margin = (($row->price - $row->cost) / $row->cost) * 100;
                return number_format($margin, 2) . '%';
            })



            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6" ids='.$row->id.'><i class="ico-graph"></i></button></div>';
                    return $btn;
            })
            ->make(true);

        }
        return view('products.index', compact('products','all_product_categories','locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Suppliers::get();
        $locations = Locations::get();
        $product_category = ProductsCategories::get();
        return view('products.create',compact('suppliers','locations','product_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newProduct = Products::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'cost' => $request->cost,
            'type' => $request->type,
            'gst_code' => $request->gst_code,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'supplier_code' => $request->supplier_code,
            'barcode_1' => $request->barcode_1,
            'barcode_2' => $request->barcode_2,
            'order_lot' => $request->order_lot,
            'min' => $request->min,
            'max' => $request->max,
        ]);
        
        if($newProduct){
            //store availabilty data
            $locations_data = Locations::get();
            $final_array = [];
            //for check locations in locations table and locations in locations checked values
            foreach ($locations_data as $index => $in) {
                $price = is_numeric($request->availability_price[$index]) ? $request->availability_price[$index] : null;
            
                if ($request->has('locations') && is_array($request->locations) && in_array($in->location_name, $request->locations)) {
                    $final_array[] = [
                        'product_id' => $newProduct->id,
                        'min' => $request->availability_min[$index],
                        'max' => $request->availability_max[$index],
                        'price' => $price,
                        'location_name' => $in->location_name,
                        'availability' => 'Available'
                    ];
                } else {
                    $final_array[] = [
                        'product_id' => $newProduct->id,
                        'min' => '',
                        'max' => '',
                        'price' => $price,
                        'location_name' => $in->location_name,
                        'availability' => 'Not available'
                    ];
                }
            }
            
            ProductAvailabilities::insert($final_array);
            
            

            $response = [
                'success' => true,
                'message' => 'Product Created successfully!',
                'type' => 'success',
                'data_id' => $newProduct->id
            ];
        }
        else{
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
        $suppliers = Suppliers::get();
        $locations = Locations::get();
        $product_category = ProductsCategories::get();

        $product = Products::where('id',$id)->first();
        $productAvailability = ProductAvailabilities::where('product_id',$product->id)
        ->select(
            'min',
            'max',
            'price',
            'location_name',
            'availability'
        )
        ->get();
        $product->availability = $productAvailability;
        // dd(count($product->availability));
        return view('products.edit',compact('suppliers','locations','product','product_category','productAvailability'));
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
        $updateProduct = Products::updateOrCreate(['id' => $request->id] , [
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'cost' => $request->cost,
            'type' => $request->type,
            'gst_code' => $request->gst_code,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'supplier_code' => $request->supplier_code,
            'barcode_1' => $request->barcode_1,
            'barcode_2' => $request->barcode_2,
            'order_lot' => $request->order_lot,
            'min' => $request->min,
            'max' => $request->max,
        ]);
        if($updateProduct){
            //store availabilty data
            $locations_data = Locations::get();
            $final_array = [];
            //for check locations in locations table and locations in locations checked values
            foreach ($locations_data as $index => $in) {
                $price = is_numeric($request->availability_price[$index]) ? $request->availability_price[$index] : null;
            
                if ($request->has('locations') && is_array($request->locations) && in_array($in->location_name, $request->locations)) {
                    $final_array[] = [
                        'product_id' => $updateProduct->id,
                        'min' => $request->availability_min[$index],
                        'max' => $request->availability_max[$index],
                        'price' => $price,
                        'location_name' => $in->location_name,
                        'availability' => 'Available'
                    ];
                } else {
                    $final_array[] = [
                        'product_id' => $updateProduct->id,
                        'min' => $request->availability_min[$index],//'' .for update min/max/price to 0 logic
                        'max' => $request->availability_max[$index],//'' .for update min/max/price to 0 logic
                        'price' => $price,//null .for update min/max/price to 0 logic
                        'location_name' => $in->location_name,
                        'availability' => 'Not available'
                    ];
                }
            }
            
            // Prepare data for update
            $updateData = [];
            // dd($final_array);
            foreach ($final_array as $item) {
                $updateData[] = [
                    'product_id' => $item['product_id'],
                    'min' => $item['min'], // You commented this line out
                    'max' => $item['max'],
                    'price' => $item['price'],
                    'availability' => $item['availability'],
                    'location_name' => $item['location_name']
                ];
            }
            // dd($updateData);
            foreach ($updateData as $data) {
                ProductAvailabilities::updateOrCreate(
                    [
                        'product_id' => $data['product_id'],
                        'location_name' => $data['location_name'],
                    ],
                    [
                        'min' => $data['min'],
                        'max' => $data['max'],
                        'price' => $data['price'],
                        'availability' => $data['availability']
                    ]
                );            
            }
            
            $response = [
                'success' => true,
                'message' => 'Product Updated successfully!',
                'type' => 'success',
                'data_id' => $updateProduct->id
            ];
        }
        else{
            $response = [
                'error' => true,
                'message' => 'Error !',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        foreach($request->id as $ids){
            Products::find($ids)->delete();

            // Delete associated availability records
            ProductAvailabilities::where('product_id', $ids)->delete();

            $response = [
                'success' => true,
                'message' => 'Product deleted successfully!',
                'type' => 'success',
                'data_id' => $ids
            ];
        }
        return response()->json($response);
    }
    public function updateProductCategory(Request $request)
    {
        $product_ids = explode(',', $request->products_id);
        // $response = []; // Initialize response outside the loop

        foreach ($product_ids as $pro) {
            $updateProduct = Products::updateOrCreate(['id' => $pro], [
                'category_id' => $request->category_name,
            ]);
            if ($updateProduct) {
                $response = [
                    'success' => true,
                    'message' => 'Product Category Updated successfully!',
                    'type' => 'success',
                    'data_id' => $updateProduct->id
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Error!',
                    'type' => 'error',
                ];
            }
        }
        return response()->json($response);
    }
    public function changeProductAvailability(Request $request){
        $product_ids = explode(',', $request->prds_id);
        $response = []; // Initialize response outside the loop
    
        foreach($product_ids as $pro)
        {
            // Retrieve the existing availability records
            $availability = ProductAvailabilities::where('product_id', $pro)->get();
            
            // Loop through the form data and update the status for each location
            foreach ($request->locs_name as $i => $locName) {
                $selectedStatus = $request->input("availability$i");
                if($selectedStatus != '(no change)') {
                    // Find the corresponding availability record for the current location
                    $availability_data = $availability->where('location_name', $locName);
                    foreach($availability_data as $ava) {
                        // Update the status only if the record is found
                        if ($ava) {
                            //for update min/max/price to 0 logic
                            // if($selectedStatus =='Not available')
                            // {
                            //     $ava->update(['availability' => $selectedStatus,'min'=>null,'max'=>null,'price'=>null]);
                            // }else{
                                $ava->update(['availability' => $selectedStatus]);
                            // }
                            
                        }
                    }
                }
            }
        }
    
        // Move the response part outside the loop
        if ($availability) {
            $response = [
                'success' => true,
                'message' => 'Availability updated successfully!',
                'type' => 'success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Error!',
                'type' => 'error',
            ];
        }
        return response()->json($response);
    }    
}
