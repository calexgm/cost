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

        
        $product = DB::table('users')
        ->join('sales','sales.user_id','=','users.id')
        ->join('sold_products','sales.id','=','sold_products.sale_id')
        ->join('products','sold_products.product_id','=','products.id')
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

    public function year_search(Request $request){
        try {
            $year = $request->year;
            $mes = $request->mes;

            $sales = Sale::leftjoin('sold_products','sales.id','sold_products.sale_id')
            ->join('users','sales.user_id','users.id')
            ->select('sales.finalized_at','users.name',DB::raw('SUM(sold_products.qty) as sum'), DB::raw('COUNT(sale_id) as count'), DB::raw('sum(sold_products.total_amount) as total_amount'))
            ->groupBy('users.name','sales.id','sales.user_id','sales.total_amount','sales.finalized_at'
            ,'sales.created_at','sales.updated_at')
            ->orderBy('sales.created_at', 'desc')
            ->whereYear('sales.finalized_at', $year)
            ->whereMonth('sales.finalized_at', $mes)
            ->get();  

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

    public function get_search(){
        try {
            $sales = Sale::leftjoin('sold_products','sales.id','sold_products.sale_id')
            ->join('users','sales.user_id','users.id')
            ->select('sales.finalized_at','users.name',DB::raw('SUM(sold_products.qty) as sum'), DB::raw('COUNT(sale_id) as count'), DB::raw('sum(sold_products.total_amount) as total_amount'))
            ->groupBy('users.name','sales.id','sales.user_id','sales.total_amount','sales.finalized_at'
            ,'sales.created_at','sales.updated_at')
            ->orderBy('sales.created_at', 'desc')
            ->get();  

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

    public function quincena_search(Request $request){
        try {
            $year = $request->year;
            $mes = $request->mes;
            $quincena = $request->quincena;
            $ini = "";
            $fin = "";
            if ($quincena == 1) {
                $ini = 01;
                $fin = 15;
            } else if($quincena == 2){
                $ini = 16;
                $fin = 31;
            }

            $sales = Sale::leftjoin('sold_products','sales.id','sold_products.sale_id')
            ->join('users','sales.user_id','users.id')
            ->select('sales.finalized_at','users.name',DB::raw('SUM(sold_products.qty) as sum'), DB::raw('COUNT(sale_id) as count'), DB::raw('sum(sold_products.total_amount) as total_amount'))
            ->groupBy('users.name','sales.id','sales.user_id','sales.total_amount','sales.finalized_at'
            ,'sales.created_at','sales.updated_at')
            ->orderBy('sales.created_at', 'desc')
            ->whereDay('sales.finalized_at', '>=' ,$ini)
            ->whereDay('sales.finalized_at', '<=' ,$fin)
            ->whereYear('sales.finalized_at', $year)
            ->whereMonth('sales.finalized_at', $mes)
            ->get();  

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


