<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsCategories;
use DataTables;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = \Auth::user()->checkPermission('products');
        if ($permission === 'View & Make Changes' || $permission === 'Both' || $permission === 'View Only' || $permission === true) {
            $products_categories = ProductsCategories::all();
            if ($request->ajax()) {
                $data = ProductsCategories::select('*');
                return Datatables::of($data)
                    
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $permission = \Auth::user()->checkPermission('products');
                        // dd($permission);
                        if ($permission === 'View Only')
                        {
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids="'.$row->id.'"  cat_name="'.$row->category_name.'"  parent_cat_name="'.$row->sub_category_name.'" data-bs-toggle="modal" data-bs-target="#edit_product_Category" disabled><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.' disabled><i class="ico-trash"></i></button></div>';
                            return $btn;
                        }else{
                            $btn = '<div class="action-box"><button type="button" class="btn btn-sm black-btn round-6 dt-edit" ids="'.$row->id.'"  cat_name="'.$row->category_name.'"  parent_cat_name="'.$row->sub_category_name.'" data-bs-toggle="modal" data-bs-target="#edit_product_Category"><i class="ico-edit"></i></button><button type="button" class="btn btn-sm black-btn round-6 dt-delete" ids='.$row->id.'><i class="ico-trash"></i></button></div>';
                            return $btn;
                        }
                })
                ->make(true);

            }
            return view('products-categories.index', compact('products_categories'));
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
        $newProductcategories = ProductsCategories::create([
            'category_name' => $request->category_name,
            'sub_category_name' => $request->sub_category_name
        ]);
        if($newProductcategories){

            $response = [
                'success' => true,
                'message' => 'Product Categories Created successfully!',
                'type' => 'success',
                'data_id' => $newProductcategories->id
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
        $update = ProductsCategories::updateOrCreate(['id' => $request->cat_hdn_id],[
            'category_name' => $request->category_name,
            'sub_category_name' => $request->sub_category_name
        ]);
        if($update){
            $response = [
                'success' => true,
                'message' => 'Product Category Updated successfully!',
                'type' => 'success',
                'data_id' => $update->id
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        ProductsCategories::find($request->id)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Product Category deleted successfully!',
            'type' => 'success',
            'data_id' => $request->id
        ];

        return response()->json($response);
    }
}
