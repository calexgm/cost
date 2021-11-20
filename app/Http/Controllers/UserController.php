<?php

namespace App\Http\Controllers;

use App\User;
use App\Shop_User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    
    public function index(User $model)
    {
        $user = Auth::user();
        $searchshop = DB::table('shop_user')->where('user_id', Auth::id())->get('shop_id');
        $users = DB::table('shop_user')
        ->join('users','shop_user.user_id','=','users.id')
        ->where('users.id','!=', Auth::id())
        ->where('shop_user.shop_id', $searchshop[0]->shop_id)
        ->select('users.*')
        ->get();

        return view('users.index', compact('users'));
    }

    public function edit_user(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            return response()->json([
                'response' => true,
                'data' => $user,
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
            $date_update = Carbon::now();
            $user = Auth::user();
            $searchshop = DB::table('shop_user')->where('user_id', $user->id)->first('shop_id');
            $shop_id = $searchshop->shop_id;

            

            if (User::where('email', $request->email)->exists()) {
                return response()->json([
                    'response' => false,
                    'error' => true
                ]);
            }else{
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'rol_id' => 2,
                    'status' => 1,
                ]);
                
                $create_su = Shop_User::create([
                    'shop_id' => $shop_id,
                    'user_id' => $user->id,
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

            if ($request->check == "true") {
                $user = User::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'updated_at' => $date_update,
            ]);
            }else {
                $user = User::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'updated_at' => $date_update,
                ]);
            }
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

    public function status_user(Request $request)
    {

        try {
            DB::beginTransaction();
            $date_update = Carbon::now();

            User::where('id', $request->id)
            ->update([
                'status' => $request->status,
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
}
