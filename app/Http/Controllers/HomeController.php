<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $user = \Auth::user();
        $user = DB::table("role_user")
            ->where('user_id', '=', $user->id)
            ->first();
        $role = $user->role_id;
        if ($role === 1 || $role === 2 ) {
            return redirect(route('admin'));
        } elseif ($role === 3) {
            return redirect(route('creator'));
        } elseif ($role === 4) {
            return redirect(route('userIndex'));
        }
        return redirect(route('top'));
    }
}
