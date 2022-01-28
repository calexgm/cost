<?php

namespace App\Http\Controllers;

use App\Client;
use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use DB;
use Auth;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $rol_id = Auth::user()->rol_id;
        $day = date('d');
        if ($rol_id == 2) {
            $sales = Sale::leftjoin('sold_products','sales.id','=','sold_products.sale_id')
            ->select('sales.id','sales.user_id',DB::raw('DATE_ADD(sales.finalized_at, INTERVAL 30 MINUTE) as finalized_at')
            ,'sales.created_at','sales.updated_at', DB::raw('sum(sold_products.total_amount) as total_amount'))
            ->where('sales.user_id', $id)
            ->groupBy('sales.id','sales.user_id','sales.total_amount','sales.finalized_at'
            ,'sales.created_at','sales.updated_at')
            ->orderBy('created_at', 'desc')
            ->get();  
        }else {
            $sales = Sale::leftjoin('sold_products','sales.id','=','sold_products.sale_id')
            ->select('sales.finalized_at as final_table','sales.id','sales.user_id',DB::raw('DATE_ADD(sales.finalized_at, INTERVAL 30 MINUTE) as finalized_at')
            ,'sales.created_at','sales.updated_at', DB::raw('sum(sold_products.total_amount) as total_amount'))
            ->whereDay('sales.created_at', null)
            ->OrwhereDay('sales.created_at', $day)
            ->groupBy('sales.id','sales.user_id','sales.total_amount','sales.finalized_at'
            ,'sales.created_at','sales.updated_at')
            ->orderBy('created_at', 'desc')
            ->get();  
        }
        
        $mifecha= date('Y-m-d H:i:s'); 
        return view('sales.index', compact('sales','mifecha' ));
    }

    
    public function create()
    {
        try {
            DB::beginTransaction();
            $date = Carbon::now();
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'created_at' => $date,
            ]);
            $sales = Sale::latest()->where('id', $sale->id)->get();
            
            DB::commit();
            return redirect('sales/'.$sale->id.'');
        } catch (Exeption $th) {
            DB::rollBack();
            return $th;
        }

    }

    
    public function show(Sale $sale)
    {
        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', Auth::id())->first('shop_id');
        $products = Product::join('product_categories as pc','products.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)
        ->where('products.status', 1)
        ->select('products.name as product','pc.name as category', 'products.price',
        'products.stock','products.status','products.id','products.description', 'products.image')
        ->get();
        //detalle
        $sales = Sale::select(DB::raw('DATE_ADD(sales.finalized_at, INTERVAL 30 MINUTE) as finalized_at'))
        ->where('sales.id', $sale->id)
        ->first();
        //FECHA ACTIAL 
        $mifecha= date('Y-m-d H:i:s'); 
        $total_amount = SoldProduct::where('sale_id', $sale->id)->sum('total_amount');
        return view('sales.show', ['mifecha' => $mifecha,'sales' => $sales,'sale' => $sale, 'products'=> $products, 'total_amount' => $total_amount]);
    }

    public function get_p()
    {
        try {
            $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', Auth::id())->first('shop_id');
        $products = Product::join('product_categories as pc','products.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)
        ->where('products.status', 1)
        ->select('products.name as product','pc.name as category', 'products.price',
        'products.stock','products.status','products.id','products.description', 'products.image')
        ->get();

        return response()->json([
            'response' => true,
            'data' => $products
        ]);
        } catch (Exception $th) {
            return response()->json([
                'response' => false,
                'data' => $th
            ]);
        }
        
    }

    
    public function finalize(Request $request)
    {
        try {
            DB::beginTransaction();
            $total = 0;
            $date = Carbon::now();
            $sale = SoldProduct::where('sale_id', $request->id)
            ->get();

            
            foreach ($sale as $key => $value) {
               $total += $value->total_amount;
            }
            $s = Sale::where('id', $request->id)
            ->update([
                'total_amount' => $total,
                'finalized_at' => $date,
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
        $sale->total_amount = $sale->products->sum('total_amount');

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->stock;
            if($sold_product->qty > $product_stock) return back()->withError("The product '$product_name' does not have enough stock. Only has $product_stock units.");
        }

        foreach ($sale->products as $sold_product) {
            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->product->save();
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->client->balance -= $sale->total_amount;
        $sale->save();
        $sale->client->save();

        return back()->withStatus('The sale has been successfully completed.');
    }
   
    public function store_product(Request $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::where('id', $request->id)->first();
            $calculo_cantidad = $product->stock - $request->count;
            if ($calculo_cantidad >= 0) {
                $total = $product->price * $request->count;
                $al_sale = SoldProduct::where('sale_id', $request->sale)
                ->where('product_id', $request->id)
                ->first();
                if ($al_sale) {
                    $c = $al_sale->qty + $request->count;
                    $total_a = $al_sale->total_amount + $total;
                    $sold = SoldProduct::where('sale_id', $request->sale)
                    ->where('product_id', $request->id)
                    ->update([
                        'qty' => $c,
                        'price' => $product->price,
                        'total_amount' => $total_a,
                    ]);
                    
                }else{
                    $sold = SoldProduct::create([
                        'sale_id' => $request->sale,
                        'product_id' => $request->id,
                        'qty' => $request->count,
                        'price' => $product->price,
                        'total_amount' => $total,
                    ]);
                    
                    
                }
                $prod = Product::find($request->id);
                $prod->stock -= $request->count;
                $prod->save();
            DB::commit();
            }else{
                return response()->json([
                    'response' => false,
                    'msg' => 'La cantidad solicitada no esta disponible.',
                ]);
            }
            $data = SoldProduct::join('products','sold_products.product_id','=','products.id')
            ->join('product_categories','products.product_category_id','=','product_categories.id')
            ->where('sale_id', $request->sale)
            ->select('product_categories.name as cate', 'products.name', 'products.id', 
            'sold_products.price', 'sold_products.qty','sold_products.total_amount','sold_products.created_at')
            ->get();
            $detail = SoldProduct::where('sale_id', $request->sale)
            ->select(DB::raw('count(product_id) as prods , SUM(qty) as qty, SUM(total_amount)as total'))
            ->where('sale_id', $request->sale)
            ->first();
            return response()->json([
                'response' => true,
                'data' => $data,
                'detail' => $detail,
                'msg' => 'Producto añadido con exito.'
               
            ]);
        } catch (Exception $th) {
            DB::rollBack();
            return $th;
            return response()->json([
                'response' => false,
                'msg' => $th
            ]);
        }
    }
    public function less_more(Request $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::where('id', $request->id)->first();
            $calculo_cantidad = $product->stock - $request->count;
            if ($calculo_cantidad >= 0) {
                $total = $product->price * $request->count;
                $al_sale = SoldProduct::where('sale_id', $request->sale)
                ->where('product_id', $request->id)
                ->first();
                if ($al_sale) {
                    $c = $al_sale->qty + $request->count;
                    if ($c == 0) {
                        $sold = SoldProduct::where('sale_id', $request->sale)
                        ->where('product_id', $request->id)
                        ->delete();
                    }else{
                        $total_a = $al_sale->total_amount + $total;
                        $sold = SoldProduct::where('sale_id', $request->sale)
                        ->where('product_id', $request->id)
                        ->update([
                            'qty' => $c,
                            'price' => $product->price,
                            'total_amount' => $total_a,
                        ]);
                    }
                }
                $prod = Product::find($request->id);
                $prod->stock -= $request->count;
                $prod->save();
            DB::commit();
            }else{
                return response()->json([
                    'response' => false,
                    'msg' => 'La cantidad solicitada no esta disponible.',
                ]);
            }
            $data = SoldProduct::join('products','sold_products.product_id','=','products.id')
            ->join('product_categories','products.product_category_id','=','product_categories.id')
            ->where('sale_id', $request->sale)
            ->select('product_categories.name as cate', 'products.name', 'products.id', 
            'sold_products.price', 'sold_products.qty','sold_products.total_amount','sold_products.created_at')
            ->get();
            $detail = SoldProduct::where('sale_id', $request->sale)
            ->select(DB::raw('count(product_id) as prods , SUM(qty) as qty, SUM(total_amount)as total'))
            ->where('sale_id', $request->sale)
            ->first();
            return response()->json([
                'response' => true,
                'data' => $data,
                'detail' => $detail,
                'msg' => 'Cantidad modificada con exito.'
               
            ]);
        } catch (Exception $th) {
            DB::rollBack();
            return $th;
            return response()->json([
                'response' => false,
                'msg' => $th
            ]);
        }
    }
    public function scann(Request $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::where('code_bar', $request->id)->first();
            if ($product) {
                $calculo_cantidad = $product->stock - 1;
                if ($calculo_cantidad >= 0) {
                    $total = $product->price * 1;
                    $al_sale = SoldProduct::where('sale_id', $request->sale)
                    ->where('product_id', $product->id)
                    ->first();
                    if ($al_sale) {
                        $c = $al_sale->qty + 1;
                        $total_a = $al_sale->total_amount + $total;
                        $sold = SoldProduct::where('sale_id', $request->sale)
                        ->where('product_id', $product->id)
                        ->update([
                            'qty' => $c,
                            'price' => $product->price,
                            'total_amount' => $total_a,
                        ]);
                        
                    }else{
                        $sold = SoldProduct::create([
                            'sale_id' => $request->sale,
                            'product_id' => $product->id,
                            'qty' => 1,
                            'price' => $product->price,
                            'total_amount' => $total,
                        ]);
                        
                        
                    }
                    $prod = Product::find($product->id);
                    $prod->stock -= $request->count;
                    $prod->save();

                    $s = Sale::where('id', $request->sale)
                        ->update([
                        'finalized_at' => null,
                    ]);
                DB::commit();
                }else{
                    return response()->json([
                        'response' => false,
                        'msg' => 'La cantidad solicitada no esta disponible.',
                    ]);
                }
                $data = SoldProduct::join('products','sold_products.product_id','=','products.id')
                ->join('product_categories','products.product_category_id','=','product_categories.id')
                ->where('sale_id', $request->sale)
                ->select('product_categories.name as cate', 'products.name', 'products.id', 
                'sold_products.price', 'sold_products.qty','sold_products.total_amount','sold_products.created_at')
                ->get();
                $detail = SoldProduct::where('sale_id', $request->sale)
                ->select(DB::raw('count(product_id) as prods , SUM(qty) as qty, SUM(total_amount)as total'))
                ->where('sale_id', $request->sale)
                ->first();
                return response()->json([
                    'response' => true,
                    'data' => $data,
                    'detail' => $detail,
                    'msg' => 'Producto añadido con exito.'
                   
                ]);
            }else {
                return response()->json([
                    'response' => false,
                    'msg' => 'Producto no encontrado.',
                ]);
            }
        } catch (Exception $th) {
            DB::rollBack();
            return $th;
            return response()->json([
                'response' => false,
                'msg' => $th
            ]);
        }
    }

    public function editproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request)
    {
        try {
            DB::beginTransaction();

            $price = Product::where('id', $request->id)->first('price');
            $total = $price->price * $request->cantidad;
            $sold = SoldProduct::where('sale_id', $request->sale)
            ->where('product_id', $request->id)
            ->update([
                'qty' => $request->cantidad,
                'price' => $price->price,
                'total_amount' => $total,
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

    public function destroyproduct(Request $request)
    {
        try {

            DB::beginTransaction();
            $prod_sold = SoldProduct::where('sale_id', $request->sale)
            ->where('product_id', $request->id)
            ->first();

            $prod = Product::find($request->id);
            $prod->stock += $prod_sold->qty;
            $prod->save();
            
            $prod_sold->delete();
            $detail = SoldProduct::where('sale_id', $request->sale)
            ->select(DB::raw('count(product_id) as prods , SUM(qty) as qty, SUM(total_amount)as total'))
            ->where('sale_id', $request->sale)
            ->first();
            DB::commit();
            return response()->json([
                'response' => true,
                'detail' => $detail,
                'id' => $prod->id,
               
            ]);
        } catch (Exception $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
                'data' => $th
            ]);
        }
    }
    public function get_edit_product(Request $request)
    {
        try {
            DB::beginTransaction();

            $delete = SoldProduct::where('sale_id', $request->sale)
            ->where('product_id', $request->id)
            ->first();

            DB::commit();
            return response()->json([
                'response' => true,
                'data' => $delete,
               
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
