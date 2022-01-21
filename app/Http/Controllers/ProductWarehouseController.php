<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductWare;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;
use App\Shop_User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Str;

class ProductWarehouseController extends Controller
{
    public function index()
    {

        //Nuevas consultas
        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', Auth::id())->first('shop_id');
        $categories = ProductCategory::where('shop_id', $searchshop->shop_id)->where('status',1)->get();
        $products = ProductWare::join('product_categories as pc','product_warehouse.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)
        ->select('product_warehouse.name as product','pc.id as category', 'product_warehouse.price', 'product_warehouse.code_bar',
        'product_warehouse.stock','product_warehouse.status','product_warehouse.id','product_warehouse.description', 'product_warehouse.image')
        ->get();


        return view('inventory.productsware.index', compact('products', 'categories'));
    }

    public function exist(Request $request)
    {
        try {
            DB::beginTransaction();

            $code = $request->code;

            $prod = ProductWare::where('code_bar', $code)->first();
            
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
            $product = ProductWare::create([
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
            
            $product = ProductWare::find($request->id);
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
            $id = $request->id;
            $allval = $request->allval;
            $cantidad = $request->cantidad;

            $prod = ProductWare::where('id', $id)->first();

            if ($prod) {
                if ($allval == 0) {

                    $prods = Product::where('code_bar', $prod->code_bar)->first();
                    if ($prods) {
                        $count = $prods->stock + $cantidad;
                        Product::where('code_bar', $prod->code_bar)
                        ->update([
                            'stock' => $count
                        ]);
                        $count_rest = $prod->stock - $cantidad;
                        ProductWare::where('id', $id)
                        ->update([
                            'stock' => $count_rest
                        ]);
                        DB::commit();
                        return response()->json([
                            'response' => true,
                            'msg' => 'Salida de bodega con exito'
                        ]);
                    }else {
                        $count = $cantidad;
                        $count_rest = $prod->stock - $cantidad;
                        ProductWare::where('id', $id)
                        ->update([
                            'stock' => $count_rest
                        ]);
                        $create = Product::create([
                            'code_bar' => $prod->code_bar,
                            'name' => $prod->name,
                            'description' => $prod->description,
                            'product_category_id' => $prod->product_category_id,
                            'price' => $prod->price,
                            'stock' => $count,
                            'status' => 1,
                        ]);
                        DB::commit();
                        return response()->json([
                            'response' => true,
                            'msg' => 'Salida de bodega con exito'
                        ]);
                    }
                    
                }else {
                    $prods = Product::where('code_bar', $prod->code_bar)->first();
                    if ($prods) {
                        $count = $prod->stock + $prods->stock;
                        Product::where('code_bar', $prod->code_bar)
                        ->update([
                            'stock' => $count
                        ]);
                        ProductWare::where('id', $id)
                        ->update([
                            'stock' => 0
                        ]);
                        DB::commit();
                        return response()->json([
                            'response' => true,
                            'msg' => 'Salida de bodega con exito'
                        ]);
                    }else {
                        ProductWare::where('id', $id)
                        ->update([
                            'stock' => 0
                        ]);
                        $create = Product::create([
                            'code_bar' => $prod->code_bar,
                            'name' => $prod->name,
                            'description' => $prod->description,
                            'product_category_id' => $prod->product_category_id,
                            'price' => $prod->price,
                            'stock' => $prod->stock,
                            'status' => 1,
                        ]);
                        DB::commit();
                        return response()->json([
                            'response' => true,
                            'msg' => 'Salida de bodega con exito'
                        ]);
                    }
                }
                
            }else {
                DB::commit();
                return response()->json([
                    'response' => false,
                    'msg' => 'Error al encontrar este producto'
                ]);
            }
        } catch (Exception $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
                'msg' => 'Ocurrio un error'
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
            $product = ProductWare::where('id',$request->id)
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
            $pro = ProductWare::find($request->id);
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
