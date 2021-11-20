<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;

class ProductCategoryController extends Controller
{
    
    public function index(ProductCategory $model)
    {
        $categories = ProductCategory::get();
        
        return view('inventory.categories.index', compact('categories'));
    }

    public function edit_category(Request $request)
    {
        try {
            $category = ProductCategory::where('id', $request->id)->first();
            return response()->json([
                'response' => true,
                'data' => $category,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
            ]);
        }
    }

    
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
            $shop_id = $searchshop->shop_id;

            if (ProductCategory::where('name', $request->name)
                ->where('shop_id', $shop_id)->exists()) {
                return response()->json([
                    'response' => false,
                    'error' => true
                ]);
            }else{
                $category = ProductCategory::create([
                    'name' => $request->name,
                    'shop_id' => $shop_id,
                    'status' => 1,
                ]);
               
                DB::commit();
                return response()->json([
                    'response' => true,
                   
                ]);
            }
            
        } catch (Exception $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
                'data' => $th
            ]);
        }
    }
   
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_update = Carbon::now();

            ProductCategory::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'updated_at' => $date_update,
            ]);
            DB::commit();
            return response()->json([
                'response' => true,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
                'data' => $th
            ]);
        }
    }

    
    public function status_category(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_update = Carbon::now();

            ProductCategory::where('id', $request->id)
            ->update([
                'status' => $request->status,
                'updated_at' => $date_update,
            ]);
            DB::commit();
            return response()->json([
                'response' => true,
            ]);
        } catch (Exception $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
                'data' => $th
            ]);
        }
    }
    public function delete_category(Request $request)
    {

        $prods = Product::where('product_category_id', $request->id)->count();

        
        try {
            DB::beginTransaction();

            
            if ($prods >= 1) {
                return response()->json([
                    'response' => false,
                    'data' => true
                ]);
            }else {
                $delete = ProductCategory::where('id', $request->id)->delete();
            }

            DB::commit();
            return response()->json([
                'response' => true,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
                'error' => true
            ]);
        }
    }
}
