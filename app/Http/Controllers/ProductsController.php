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
                if ($row->cost != 0) {
                    $dis = $row->price / 11;
                    $dis1 = $row->price - $dis;
            
                    $margin = (($dis1 - $row->cost) / $dis1) * 100;
                    $margin = min($margin, 100);
            
                    // Round up the margin to the nearest integer value
                    $margin = round($margin);
            
                    return $margin . '%';
                } else {
                    return '100'; // Or any other appropriate value to handle division by zero
                }
            })   

            ->addIndexColumn()
            ->addColumn('on_hand', function ($row) {
                $totalOnHand = ProductAvailabilities::where('product_id', $row->id)->sum('quantity');
                return $totalOnHand;
            })

            ->addIndexColumn()
            ->addColumn('on_hand_price', function ($row) {
                $product = Products::findOrFail($row->id); // Retrieve product details
                $totalOnHand = ProductAvailabilities::where('product_id', $row->id)->sum('quantity');
                $totalCost = $product->cost * $totalOnHand; // Calculate total cost of on-hand products
                return '$' . number_format($totalCost, 2); // Format and return total cost
            })



            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids='.$row->id.'><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 product_statistics" ids='.$row->id.'><i class="ico-graph"></i></button></div>';
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
            
                if ($request->has('locations') && is_array($request->locations) && in_array($in->id, $request->locations)) {
                    $final_array[] = [
                        'product_id' => $newProduct->id,
                        'quantity' => $request->availability_quantity[$index],
                        // 'max' => $request->availability_max[$index],
                        'price' => $price,
                        'location_name' => $in->id,
                        'availability' => 'Available'
                    ];
                } else {
                    $final_array[] = [
                        'product_id' => $newProduct->id,
                        'min' => '',
                        'max' => '',
                        'price' => $price,
                        'location_name' => $in->id,
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
            'quantity',
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
                $price = isset($request->availability_price[$index]) && is_numeric($request->availability_price[$index]) ? $request->availability_price[$index] : null;
            
                if ($request->has('locations') && is_array($request->locations) && in_array($in->id, $request->locations)) {
                    $final_array[] = [
                        'product_id' => $updateProduct->id,
                        'quantity' => $request->availability_quantity[$index] ?? null,
                        // 'max' => $request->availability_max[$index] ?? null,
                        'price' => $price,
                        'location_name' => $in->id,
                        'availability' => 'Available'
                    ];
                } else {
                    $final_array[] = [
                        'product_id' => $updateProduct->id,
                        'quantity' => '',//'' .for update min/max/price to 0 logic
                        // 'max' => '',//'' .for update min/max/price to 0 logic
                        'price' => null,//null .for update min/max/price to 0 logic
                        'location_name' => $in->id,
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
                    'quantity' => $item['quantity'], // You commented this line out
                    // 'max' => $item['max'],
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
                        'quantity' => $data['quantity'],
                        // 'max' => $data['max'],
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
                            if($selectedStatus =='Not available')
                            {
                                $ava->update(['availability' => $selectedStatus,'min'=>null,'max'=>null,'price'=>null]);
                            }else{
                                $ava->update(['availability' => $selectedStatus]);
                            }
                            
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
    // public function changeStocksLevel(Request $request){
    //     $product_ids = explode(',', $request->hdn_id);

    //     $response = []; // Initialize response outside the loop
    //     // dd($request->all());
    //     if($request->loc_status == '0')
    //     {
    //         // dd($product_ids);
    //         foreach($product_ids as $pro)
    //         {
    //             // Retrieve the existing availability records
    //             $availability = ProductAvailabilities::where('product_id', $pro)->get();
    //             // dd($availability);
    //             $availability_data = $availability->where('product_id', $pro);
    //             // dd($availability_data);
    //             foreach($availability_data as $ava) {
    //                 $ava->update(['min' => $request->min_price,'max' => $request->max_price]);
    //             }
    //         }
    //     }else{
    //         // dd($request->locations_availability);
    //         foreach ($request->locations_availability as $i => $locName) {
    //             // Find the first matching record for the location
    //             $availability_data = $availability->firstWhere('location_name', $locName);

    //             // If the record is found, update it
    //             if ($availability_data) {
    //                 // Update the status only if the record is found
    //                 $availabilityStatus = isset($request->locations_availability[$i]) ? 'Available' : 'Not available';

    //                 $availability_data->update([
    //                     'min' => $request->availability_min[$i],
    //                     'max' => $request->availability_max[$i],
    //                     'availability' => $availabilityStatus,
    //                 ]);
    //             }
    //         }



            
                    
    //     }
    //     // Move the response part outside the loop
    //     if ($availability) {
    //         $response = [
    //             'success' => true,
    //             'message' => 'Availability updated successfully!',
    //             'type' => 'success',
    //         ];
    //     } else {
    //         $response = [
    //             'error' => true,
    //             'message' => 'Error!',
    //             'type' => 'error',
    //         ];
    //     }
    //     return response()->json($response);
    // }
    public function changeStocksLevel(Request $request)
    {
        $product_ids = explode(',', $request->hdn_id);

        $response = []; // Initialize response outside the loop

        foreach ($product_ids as $pro) {
            $availability = ProductAvailabilities::where('product_id', $pro)->get();

            if ($request->loc_status == '0') {
                $availability_data = $availability->where('product_id', $pro);
                // dd($availability_data);
                foreach($availability_data as $ava) {
                    $ava->update(['min' => $request->min_price,'max' => $request->max_price,'availability' => 'Available']);
                }
            }else{
                $locations_data = Locations::get();

                foreach ($locations_data as $index => $location) {
                    $locName = $location->id;
                    
                    // Find the first matching record for the location
                    $availability_data = $availability->firstWhere('location_name', $locName);
                
                    // Check if availability data exists
                    if ($availability_data) {
                        // Determine availability status based on the condition
                        $isChecked = isset($request->locations_availability) && in_array($locName, $request->locations_availability);
                        
                        $availabilityStatus = $isChecked ? 'Available' : 'Not available';
                        
                        // Update availability data
                        $availability_data->update([
                            'quantity' => $isChecked ? $request->availability_quantity[$index] : null,
                            // 'max' => $isChecked ? $request->availability_max[$index] : null,
                            'availability' => $availabilityStatus,
                        ]);
                
                        // Optional: If you want to do something with the final_array
                        $final_array[] = $availability_data;
                    } else {
                        // Handle case where availability data is not found for the location
                        // You might want to log this or handle it differently based on your requirements
                    }
                }                

                // Optional: If you want to do something with the final_array
                // dd($final_array);


                
            }
        }
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
    public function import(Request $request) {
        $errors = []; // Track errors
        $dataToInsert = []; // Store data to be inserted
        
        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            
            // Remove the header row if present
            if (count($data) > 0 && isset($data[0]) && is_array($data[0])) {
                array_shift($data);
            }
            // Check if CSV is empty
            if (empty($data)) {
                return response()->json([
                    'error' => true,
                    'message' => 'The CSV file is empty.',
                    'type' => 'error',
                ]);
            }
            $maxFilesAllowed = 50;
            $uploadedFilesCount = count($data);
            if ($uploadedFilesCount > $maxFilesAllowed) {
                return response()->json([
                    'error' => true,
                    'message' => 'You can upload a maximum of ' . $maxFilesAllowed . ' files.',
                    'type' => 'error',
                ]);
            }
            $product_data = Products::pluck('product_name', 'id')->toArray();
    
            foreach ($data as $rowIndex => $row) {
                $rowErrors = []; // Track errors for this specific row
                
                // Initialize locationsInRow array
                $locationsInRow = [];
                
                // Check if product name is empty
                if (empty($row[0])) {
                    $rowErrors[] = 'Product name is required.';
                } else {
                    // Check if product name already exists
                    if (in_array($row[0], $product_data)) {
                        $rowErrors[] = 'Product with name "' . $row[0] . '" already exists.';
                    }
                }
                
                // If there are errors with this row, add them to the general errors array
                if (!empty($rowErrors)) {
                    $errors[] = [
                        'row' => $rowIndex + 1,
                        'fields' => $rowErrors,
                    ];
                    // Skip processing this row
                    continue;
                }
                
                // Check if price is empty
                if (empty($row[2])) {
                    $rowErrors[] = 'Price is required.';
                }
                // Check if price is empty or not numeric
                if (empty($row[2]) || !is_numeric($row[2]) || !is_float(floatval($row[2]))) {
                    $rowErrors[] = 'Price must be a numeric value.';
                }

                
                // Check if cost is empty
                if (empty($row[3])) {
                    $rowErrors[] = 'Cost is required.';
                }
                if (empty($row[3]) || !is_numeric($row[3]) || !is_float(floatval($row[3]))) {
                    $rowErrors[] = 'Cost must be a numeric value.';
                }

                // Check if type is empty
                if (empty($row[4])) {
                    $rowErrors[] = 'Type is required.';
                }

                // Check if gst code is empty
                if (empty($row[5])) {
                    $rowErrors[] = 'GST code is required.';
                }

                // Check if category is empty
                if (empty($row[6])) {
                    $rowErrors[] = 'Category is required.';
                }

                // Check if supplier is empty
                if (empty($row[7])) {
                    $rowErrors[] = 'Supplier is required.';
                }

                // Check if Order lot is empty
                if (empty($row[11])) {
                    $rowErrors[] = 'Order lot is required.';
                }
                // Check if cost is empty or not numeric
                if (empty($row[11]) || !is_numeric($row[11])) {
                    $rowErrors[] = 'Order lot must be a numeric value.';
                }

                // Check if Order min is empty
                if (empty($row[12])) {
                    $rowErrors[] = 'Order min is required.';
                }
                // Check if cost is empty or not numeric
                if (empty($row[12]) || !is_numeric($row[12])) {
                    $rowErrors[] = 'Order cost must be a numeric value.';
                }

                // Check if Order max is empty
                if (empty($row[13])) {
                    $rowErrors[] = 'Order max is required.';
                }
                // Check if cost is empty or not numeric
                if (empty($row[13]) || !is_numeric($row[13])) {
                    $rowErrors[] = 'Order max must be a numeric value.';
                }

                // Check if category exists
                $category = ProductsCategories::where('category_name', $row[6])->first();
                if (!$category && !empty($row[6])) {
                    $rowErrors[] = 'Category "' . $row[6] . '" does not exist.';
                }

                // Check if supplier exists
                $supplier = Suppliers::where('business_name', $row[7])->first();
                if (!$supplier && !empty($row[7])) {
                    $rowErrors[] = 'Supplier "' . $row[7] . '" does not exist.';
                }
                
                // Get all locations
                $locations = Locations::all();
    
                // // Initialize availability data array
                $availabilityData = [];
                
                // Check if availability information is provided
                if (!empty($row[14]) && !empty($row[15]) && !empty($row[16])) {

                    
                    
                    // Explode the comma-separated values and store them in separate variables
                    $availabilityLocation = explode(',', $row[14]);
                    $availabilityQuantityValues = explode(',', $row[15]);
                    // $availabilityMaxValues = explode(',', $row[16]);
                    $availabilityPriceValues = explode(',', $row[16]);

                    // Check if any value in row[18] doesn't match any location name
                    foreach ($availabilityLocation as $locationName) {
                        $locationExists = false;
                        foreach ($locations as $location) {
                            if ($locationName === $location->location_name) {
                                $locationExists = true;
                                break;
                            }
                        }
                        if (!$locationExists) {
                            // Add error message if location doesn't exist
                            $rowErrors[] = 'Location "' . $locationName . '" does not exist.';
                        }
                    }
                    
                    if (!empty($availabilityQuantityValues)) {
                        foreach ($availabilityQuantityValues as $value) {
                            if (!is_numeric($value)) {
                                $rowErrors[] = 'Availability quantity must be a numeric value.';
                                // break; // exit the loop if error found for efficiency
                            }
                        }
                    }
                    
                    // if (!empty($availabilityMaxValues)) {
                    //     foreach ($availabilityMaxValues as $value) {
                    //         if (!is_numeric($value)) {
                    //             $rowErrors[] = 'Availability max must be a numeric value.';
                    //             // break; // exit the loop if error found for efficiency
                    //         }
                    //     }
                    // }
                    
                    if (!empty($availabilityPriceValues)) {
                        foreach ($availabilityPriceValues as $value) {
                            if (!is_numeric($value) || !is_float(floatval($value))) {
                                $rowErrors[] = 'Availability price must be a numeric value.';
                                // break; // exit the loop if error found for efficiency
                            }
                        }
                    }
                    
                     // Check if availability information indices match
                    if (count($availabilityLocation) !== count($availabilityQuantityValues) || 
                        // count($availabilityMinValues) !== count($availabilityMaxValues) ||
                        count($availabilityQuantityValues) !== count($availabilityPriceValues)) {
                        $rowErrors[] = 'Mismatch in availability data indices.';
                    }

                    // Loop through each location and assign availability data
                    foreach ($locations as $location) {
                        $locationName = $location->location_name;
                        $availabilityQuantity = null;
                        // $availabilityMax = null;
                        $availabilityPrice = null;
                        $availabilityStatus = 'Available'; // Default

                        // Check if the location exists in the provided availability data
                        $index = array_search($locationName, $availabilityLocation);
                        if ($index !== false) {
                            // Assign availability data if found
                            $availabilityQuantity = isset($availabilityQuantityValues[$index]) ? $availabilityQuantityValues[$index] : null;
                            // $availabilityMax = isset($availabilityMaxValues[$index]) ? $availabilityMaxValues[$index] : null;
                            $availabilityPrice = isset($availabilityPriceValues[$index]) ? $availabilityPriceValues[$index] : null;

                            // Determine availability status
                            // $availabilityStatus = (!empty($availabilityMin) || !empty($availabilityMax) || !empty($availabilityPrice)) ? 'Available' : 'Not available';
                        }

                        // Add availability data to the array
                        $availabilityData[] = [
                            'location_name' => $location->id, // Use location ID
                            'availability_quantity' => $availabilityQuantity,
                            // 'availability_max' => $availabilityMax,
                            'availability_price' => $availabilityPrice,
                            'availability' => $availabilityStatus,
                        ];
                    }
                } else {
                    // If availability information is not provided, set default data for all locations
                    foreach ($locations as $location) {
                        $availabilityData[] = [
                            'location_name' => $location->id,
                            'availability_quantity' => null,
                            // 'availability_max' => null,
                            'availability_price' => null,
                            'availability' => 'Available',
                        ];
                    }
                }
                   
                
                
                               

                if (!empty($rowErrors)) {
                    $errors[] = [
                        'row' => $rowIndex + 1,
                        'fields' => $rowErrors,
                    ];
                } else {
                    // Store data for insertion
                    $dataToInsert[] = [
                        'product_name' => $row[0],
                        'description' => $row[1],
                        'price' => $row[2],
                        'cost' => $row[3],
                        'type' => $row[4],
                        'gst_code' => $row[5],
                        'category_id' => $category ? $category->id : null,
                        'supplier_id' => $supplier ? $supplier->id : null,
                        'supplier_code' => $row[8],
                        'barcode_1' => $row[9],
                        'barcode_2' => $row[10],
                        'order_lot' => $row[10] == "" ? 0 : $row[10],
                        'min' => $row[11] == "" ? 0 : $row[11],
                        'max' => $row[12] == "" ? 1 : $row[12],
                    ];
                }
            }
    
            // If there are no errors, insert the data
            if (empty($errors)) {
                foreach ($dataToInsert as $rowData) {
                    $product = Products::create([
                        'product_name' => $rowData['product_name'],
                        'description' => $rowData['description'],
                        'price' => $rowData['price'],
                        'cost' => $rowData['cost'],
                        'type' => $rowData['type'],
                        'gst_code' => $rowData['gst_code'],
                        'category_id' => $rowData['category_id'],
                        'supplier_id' => $rowData['supplier_id'],
                        'supplier_code' => $rowData['supplier_code'],
                        'barcode_1' => $rowData['barcode_1'],
                        'barcode_2' => $rowData['barcode_2'],
                        'order_lot' => $rowData['order_lot'],
                        'min' => $rowData['min'],
                        'max' => $rowData['max'],
                    ]);

                    // Store availability data
                    foreach ($availabilityData as $availability) {
                        ProductAvailabilities::create([
                            'product_id' => $product->id,
                            'location_name' => $availability['location_name'],
                            'quantity' => $availability['availability_quantity'],
                            // 'max' => $availability['availability_max'],
                            'price' => $availability['availability_price'],
                            'availability' => $availability['availability'],
                        ]);
                    }
                }
    
                return response()->json([
                    'success' => true,
                    'message' => 'CSV data imported successfully!',
                    'type' => 'success',
                ]);
            }
        } else {
            $errors[] = 'No CSV file selected.';
        }
        
        // Constructing error messages for specific errors
        $errorMsg = '';
        foreach ($errors as $error) {
            foreach ($error['fields'] as $fieldError) {
                $errorMsg .= 'Row ' . $error['row'] . ': ' . $fieldError . ' ';
            }
        }
        
        // If errors were found, return error response with specific error message
        return response()->json([
            'error' => true,
            'message' => 'Errors occurred while importing CSV data. ' . $errorMsg,
            'type' => 'error',
        ]);
    }
    public function productPerformance(Request $request)
    {
        $product = Products::where('id',$request->id)->first();

        if ($product->cost != 0) {
            $dis = $product->price / 11;
            $dis1 = $product->price - $dis;
    
            $margin = (($dis1 - $product->cost) / $dis1) * 100;
            $margin = min($margin, 100);
    
            // Round up the margin to the nearest integer value
            $margin = round($margin);
    
            $product->product_margin = $margin . '%';
        } else {
            $product->product_margin = '100'; // Or any other appropriate value to handle division by zero
        }
        
        // dd($product);
        $productAvailability = ProductAvailabilities::where('product_id', $request->id)
        ->select(
            'quantity',
            'price',
            'location_name',
            'availability'
        )
        ->get();
        // dd($productAvailability);

        $product->availability = $productAvailability;

        $productLocations = []; // Initialize an array to store location names
        $productQuantities = []; // Initialize an array to store location names
        $productPrice = []; // Initialize an array to store location names
        $productStatus = [];
        
        $productAvailability->each(function ($availability) use (&$productLocations,&$productQuantities,&$productPrice,&$productStatus) {
            $location = Locations::find($availability->location_name);
            if ($location) {
                $productLocations[] = $location->location_name;
            }
            $productQuantities[] = $availability->quantity;
            $productPrice[] = $availability->price;
            $productStatus[] = $availability->availability;
        });
        // dd($productQuantities);

        $response = [
            'success' => true,
            'message' => 'Product fetch successfully!',
            'type' => 'success',
            'data' => $product,
            'productLocations' => $productLocations,
            'productQuantities'=> $productQuantities,
            'productPrice'=>$productPrice,
            'productStatus'=>$productStatus
        ];
        return response()->json($response);
    }
}