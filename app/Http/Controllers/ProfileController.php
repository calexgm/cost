<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Shop;

class ProfileController extends Controller
{
    
    public function edit()
    {
        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
        $membership = DB::table('membership_client')
        ->join('membership','membership_client.membership_id','=','membership.id')
        ->where('shop_id', $searchshop->shop_id)
        ->select('membership.name_membership','membership_client.date_star','date_end')
        ->first();

        $shop = Shop::where('id',$searchshop->shop_id)->first('name_shop');
        $vendedores = DB::table('shop_user')
        ->join('users','shop_user.user_id','=','users.id')
        ->where('rol_id', 2)
        ->where('shop_id',$searchshop->shop_id)
        ->select('users.id','users.name','users.email','users.created_at')
        ->get();

        return view('profile.edit',
        compact('vendedores','shop','membership'));
    }

    
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            auth()->user()->update($request->all());
            DB::commit();
            return response()->json([
                'response' => true,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
            ]);
        }
    }

    
    public function password(Request $request)
    {
        try {
            DB::beginTransaction();
            auth()->user()->update(['password' => Hash::make($request->get('password'))]);
            DB::commit();
            return response()->json([
                'response' => true,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'response' => false,
            ]);
        }
    }
}
