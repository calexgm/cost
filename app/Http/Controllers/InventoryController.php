<?php

namespace App\Http\Controllers;

use App\Product;
use App\Shop;
use Carbon\Carbon;
use App\SoldProduct;
use App\ProductCategory;
use Illuminate\Http\Request;
use Auth;
use DB;

class InventoryController extends Controller
{
    public function stats()
    {
        $categories = ProductCategory::all();
        $products = Product::all();
        $soldproductsbystock = SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')
        ->limit(15)
        ->get();
        $soldproductsbyincomes = SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('product_id')
        ->orderBy('incomes', 'desc')
        ->limit(15)
        ->get();

        $soldproductsbyavgprice = SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('product_id')
        ->orderBy('avg_price', 'desc')
        ->limit(15)
        ->get();
        //NUEVOS QUE YO HICE

        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
        $productscount = Product::join('product_categories as pc','products.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)->count();
        $productsexhausted = Product::where('stock', 0)->count();
        $userscount = DB::table('shop_user')->where('shop_id',$searchshop->shop_id)->count();

        $sales_today = DB::table('users')
        ->join('sales','sales.user_id','=','users.id')
        ->join('shop_user','shop_user.user_id','=','users.id')
        ->where('shop_user.shop_id', $searchshop->shop_id)
        ->select(DB::raw('SUM(total_amount) as sum'))
        ->first();
        return view('inventory.stats', [
            'productscount' => $productscount,
            'productsexhausted' => $productsexhausted,
            'userscount' => $userscount-1,
            'sale' => $sales_today,
            //viejas variables
            'products' => $products,
            'soldproductsbystock' => $soldproductsbystock,
            'soldproductsbyincomes' => $soldproductsbyincomes,
            'soldproductsbyavgprice' => $soldproductsbyavgprice
        ]);
    }
}
