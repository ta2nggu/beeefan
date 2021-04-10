<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('role:administrator');
    }

    public function admin_creatorReg(Request $request){
        $user = User::create([
            'account_id' => $request->input('account_id'),
            'sex' => $request->input('sex'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'nickname' => $request->input('nickname'),
            'birth_date' => $request->input('birth_date'),
        ]);
        $user->attachRole('creator');

        $creator_list = DB::table("users")
            ->select(DB::raw("users.name"))
            ->join("role_user","role_user.user_id","=","users.id")
            ->where('role_user.role_id', '=', 2)
            ->get();
        return view("admin.creatorList", [
            'creator_list'=>$creator_list
        ]);
    }

    public function admin_creatorRegPage()
    {
        return view("admin.creatorRegPage");
    }

    public function admin_creatorList(){
        $creator_list = DB::table("users")
            ->select(DB::raw("users.name"))
            ->join("role_user","role_user.user_id","=","users.id")
            ->where('role_user.role_id', '=', 2)
            ->get();
        return view("admin.creatorList", [
            'creator_list'=>$creator_list
        ]);
    }

    public function index(){
        //Creator 수
        $creators_cnt = DB::table("users")
//                       ->select(DB::raw("COUNT(1) as cnt"))
                       ->join("role_user","role_user.user_id","=","users.id")
                       ->where('role_user.role_id', '=', 2)
//                       ->get();
                       ->count();
        //User
        $users_cnt = DB::table("users")
                               //->select(DB::raw("COUNT(1) as cnt"))
                               ->join("role_user","role_user.user_id","=","users.id")
                               ->where('role_user.role_id', '=', 3)
                               //->get();
                               ->count();

        return view('admin.index',[
            'creators_cnt'=>$creators_cnt,
            'users_cnt'=>$users_cnt
        ]);
    }
}
