<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;
use App\Shop_User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    public function index()
    {

        //Nuevas consultas
        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', Auth::id())->first('shop_id');
        $categories = ProductCategory::where('shop_id', $searchshop->shop_id)->where('status',1)->get();
        $products = Product::join('product_categories as pc','products.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)
        ->select('products.name as product','pc.name as category', 'products.price',
        'products.stock','products.status','products.id','products.description', 'products.image')
        ->get();


        return view('inventory.products.index', compact('products', 'categories'));
    }

    public function exist(Request $request)
    {
        try {
            DB::beginTransaction();

            $code = $request->code;

            $prod = Product::where('code_bar', $code)->first();
            
            if ($prod) {
                DB::commit();
                return response()->json([
                    'response' => true,
                    'data' => $prod
                ]);
            }else{
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

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::create([
                'code_bar' => $request->codebar,
                'name' => $request->name,
                'description' => $request->descripcion,
                'product_category_id' => $request->categoria,
                'price' => $request->precio,
                'stock' => $request->cantidad,
                'status' => 1,
            ]);

            $file = $request->file('photo');
            if ($file) {
                $extension = $file->getClientOriginalExtension();
                $name = Str::random(20);
                $fileName = $name . '.' . $extension;
                $path = public_path('images/products/'.$fileName);
                Image::make($file->getRealPath())
                    ->resize(150,200, function ($constraint){ 
                        $constraint->aspectRatio();
                    })
                    ->save($path,72);
                $product->image = $fileName;
                $saved = $product->save();
            }else{
                $fileName = 'producto.png';
                $product->image = $fileName;
                $saved = $product->save();
            }
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
    public function store_stock(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $product = Product::find($request->id);
            $product->stock += $request->cantidad;
            $saved = $product->save();
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

    public function status_product(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_update = Carbon::now();

            Product::where('id', $request->id)
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

    public function edit_product(Request $request)
    {
        try {
            $category = Product::where('id', $request->id)->first();
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

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_update = Carbon::now();
            $product = Product::where('id',$request->id)
            ->update([
                'code_bar' => $request->code,
                'name' => $request->name,
                'description' => $request->descripcion,
                'product_category_id' => $request->categoria,
                'price' => $request->precio,
                'stock' => $request->cantidad,
                'updated_at' => $date_update,
            ]);

            $file = $request->file('photo');
            $pro = Product::find($request->id);
            if ($file != "") {
                $extension = $file->getClientOriginalExtension();
                $name = Str::random(20);
                $fileName = $name . '.' . $extension;
                $path = public_path('images/products/'.$fileName);
                Image::make($file->getRealPath())
                    ->resize(150,200, function ($constraint){ 
                        $constraint->aspectRatio();
                    })
                    ->save($path,72);
                $pro->image = $fileName;
                $saved = $pro->save();
            }else{
            }
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
}
