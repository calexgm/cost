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
        //validamos que la tienda y el usuario esten activos
        $user = Auth::user();
        $status = $user->status;
        $searchshop_id = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
        $status_shop = DB::table('shops')->where('id',$searchshop_id->shop_id)->first('id');
        //NUEVOS QUE YO HICE
        if ($status == 1 && $status_shop->id == 1) {
        $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
        $productscount = Product::join('product_categories as pc','products.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)->count();
        $productsexhausted = Product::where('stock', 0)->count();
        $userscount = DB::table('shop_user')->where('shop_id',$searchshop->shop_id)->count();

        $sales_today = DB::table('users')
        ->join('sales','sales.user_id','=','users.id')
        ->join('shop_user','shop_user.user_id','=','users.id')
        ->where('shop_user.shop_id', $searchshop->shop_id)
        ->whereDay('sales.finalized_at', date('d'))
        ->select(DB::raw('SUM(total_amount) as sum'))
        ->first();
        return view('inventory.stats', [
        'productscount' => $productscount,
        'productsexhausted' => $productsexhausted,
        'userscount' => $userscount-1,
        'sale' => $sales_today,
        //viejas variables
        ]);
        }else{
            Auth::logout();
            return view('auth.login');     
        }
        
        
    }
}
