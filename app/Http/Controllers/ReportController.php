<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Product;
use App\Sale;

class ReportController extends Controller
{
    public function index(){
       return view('reports.index');
    }

    public function get_sales_month(){

        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
        
        $year = date('Y');
        $sales_today = DB::table('users')
        ->join('sales','sales.user_id','=','users.id')
        ->join('shop_user','shop_user.user_id','=','users.id')
        ->where('shop_user.shop_id', $searchshop->shop_id)
        ->where('finalized_at', '!=', null)
        ->whereYear('finalized_at', $year)
        ->select(DB::raw('SUM(total_amount) as sum'),DB::raw('DATE_FORMAT(finalized_at, "%Y-%m") as fecha'))
        ->groupBy('fecha')
        ->get();

        return response()->json([
            'response' => true,
            'data' => $sales_today
        ]);
        

        
    }
    public function more_product(){

        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
        $product = Product::join('product_categories as pc','products.product_category_id','=','pc.id')
        ->where('pc.shop_id', $searchshop->shop_id)->get();

        $product = DB::table('users')
        ->join('sales','sales.user_id','=','users.id')
        ->join('sold_products','sales.id','=','sold_products.sale_id')
        ->join('products','sold_products.product_id','=','products.id')
        ->where('user_id', $user->id)
        ->where('sales.finalized_at' ,'!=',null)
        ->select('products.name','sold_products.qty')
        ->orderBY('qty', 'desc')
        ->limit(5)
        ->get();
        
        return response()->json([
            'response' => true,
            'data' => $product
        ]);
    } 

    public function sales_users(){

        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');

        $sales = DB::table('users')
        ->join('sales','sales.user_id','=','users.id')
        ->join('sold_products','sales.id','=','sold_products.sale_id')
        ->select('users.name', DB::raw('COUNT(users.id) as sum'))
        ->groupBy('name')
        ->get();

        return response()->json([
            'response' => true,
            'data' => $sales
        ]);
    } 

    public function year_search(){
        try {
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
                //->whereDay('sales.finalized_at', null)
                //->OrwhereDay('sales.finalized_at', $day)
                ->groupBy('sales.id','sales.user_id','sales.total_amount','sales.finalized_at'
                ,'sales.created_at','sales.updated_at')
                ->orderBy('created_at', 'desc')
                ->get();  
            }

            return response()->json([
                'response' => true,
                'data' => $sales
            ]);
        } catch (\Throwable $th) {
            return $th;
            return response()->json([
                'response' => false,
            ]);
        }
    }
}


