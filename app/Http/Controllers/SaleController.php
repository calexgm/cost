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
        $sales = Sale::latest()->get();

        return view('sales.index', compact('sales'));

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
        return view('sales.show', ['sale' => $sale, 'products'=> $products]);
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
               $prod = Product::where('id', $value->product_id)
               ->decrement('stock',$value->qty);
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

    public function storeproduct(Request $request, Sale $sale, SoldProduct $soldProduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldProduct->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus('Product successfully registered.');
    }
    //miio
    public function store_product(Request $request)
    {
        try {
            DB::beginTransaction();

            $price = Product::where('id', $request->id)->first('price');
            $total = $price->price * $request->cantidad;
            $al_sale = SoldProduct::where('sale_id', $request->sale)
            ->where('product_id', $request->id)
            ->first();

            if ($al_sale) {
                $c = $al_sale->qty + $request->cantidad;
                $total_a = $al_sale->total_amount + $total;
                $sold = SoldProduct::where('sale_id', $request->sale)
                ->where('product_id', $request->id)
                ->update([
                    'qty' => $c,
                    'price' => $price->price,
                    'total_amount' => $total_a,
                ]);
            }else{
                $sold = SoldProduct::create([
                    'sale_id' => $request->sale,
                    'product_id' => $request->id,
                    'qty' => $request->cantidad,
                    'price' => $price->price,
                    'total_amount' => $total,
                ]);
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

            $delete = SoldProduct::where('sale_id', $request->sale)
            ->where('product_id', $request->id)
            ->delete();

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

    public function addtransaction(Sale $sale)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.addtransaction', compact('sale', 'payment_methods'));
    }

    public function storetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1) ]);
                }
                break;
        }

        $transaction->create($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully registered transaction.');
    }

    public function edittransaction(Sale $sale, Transaction $transaction)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.edittransaction', compact('sale', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: '. $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: '. $request->get('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully modified transaction.');
    }

    public function destroytransaction(Sale $sale, Transaction $transaction)
    {
        $transaction->delete();

        return back()->withStatus('Transaction deleted successfully.');
    }
}
