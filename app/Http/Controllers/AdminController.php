<?php

namespace App\Http\Controllers;
use App\Models\Creator;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('role:administrator');
    }

//    아직 미완 크리에이터 벨리데이션 체크 꼭 완성 시키기
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'account_id' => ['required', 'string', 'min:2', 'max:20','unique:users', 'regex:/^[\w-]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nickname' => ['required','string','min:2','unique:users','regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
//            'nickname' => ['required','string','min:2','unique:users','regex:/^\S*$/u'],
        ]);
    }

    public function admin_creatorReg(Request $request){
        $user = User::create([
            'account_id' => $request->input('account_id'),
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->attachRole('creator');

        //create 를 사용하기 위해선 Model에 $fillable 에 선언이 되어 있어야 함
        Creator::create([
            'user_id' => $user->id,
            'nickname' => $request->input('nickname'),//クリエイター名 = nickname
            'month_price' => $request->input('month_price'),
        ]);

//        21.04.15 김태영, index 화면으로 이동
//        return $this->index();
        return redirect('/admin/index')->with('verified', true);
    }

    public function admin_creatorRegPage()
    {
        return view("admin.creatorRegPage");
    }

    public function admin_creatorList(){
        $creator_list = DB::table("users")
//            ->select(DB::raw("users.name"))21.04.15 김태영, 제거
            ->join("role_user","role_user.user_id","=","users.id")
            ->where('role_user.role_id', '=', 2)
            ->get();
        return view("admin.creatorList", [
            'creator_list'=>$creator_list
        ]);
    }

    public function index(Request $request){
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

        //21.04.15 김태영, Creator list 추가
//        $creator_list = DB::table("users")
//            ->join("role_user","role_user.user_id","=","users.id")
//            ->where('role_user.role_id', '=', 2)
//            ->paginate(3);

        if ($request->sorting != null) {
            $creators = DB::table("creators")
                ->where('creators.nickname', 'LIKE','%'.$request->search."%")
                ->orderBy($request->sorting, $request->direction)
                ->paginate(3);
        }
        else {
            $creators = DB::table("creators")
                ->where('creators.nickname', 'LIKE','%'.$request->search === null?$request->search:''."%")
                ->orderBy('created_at', 'desc')
                ->paginate(3);
        }

//        21.04.16 김태영, creator list ajax
        if ($request->ajax()) {
            $view = view('admin.indexData', compact( 'creators'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('admin.index',[
            'creators_cnt'=>$creators_cnt,
            'users_cnt'=>$users_cnt,
            'creators'=>$creators
        ]);
    }

    public function notice() {
        $notices = Notice::orderby('created_at', 'desc')->get();

        return view('admin.notice', compact('notices'));
    }

    public function notice_store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|max:400',
            'body' => 'required',
        ]);

//        return dd($validated);

        $this->middleware('auth');
        $this->user =  \Auth::user();

        //공지하기
        Notice::create([
            'from_user_id' => $this->user->id,//작성자
//            'to_user_id' => 받는사람이 null이면 전체 공개
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return redirect('/admin/notice');
    }

    public function notice_delete(Request $request) {
        Notice::find($request->notice_id)->delete();

        return redirect('/admin/notice');
    }
}
