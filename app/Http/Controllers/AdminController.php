<?php

namespace App\Http\Controllers;
use App\Models\Creator;
use App\Models\Following;
use App\Models\Notice;
use App\Models\tweet;
use App\Models\Tweet_image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('role:administrator|superadministrator');
    }

    //21.05.06 김태영, 잘못이해하고 만들었다.. 사용 안함
//    아직 미완 크리에이터 벨리데이션 체크 꼭 완성 시키기
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'last_name' => ['required', 'string', 'max:255'],
//            'first_name' => ['required', 'string', 'max:255'],
//            'account_id' => ['required', 'string', 'min:2', 'max:20','unique:users', 'regex:/^[\w-]*$/'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
//            'nickname' => ['required','string','min:2','unique:users','regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
////            'nickname' => ['required','string','min:2','unique:users','regex:/^\S*$/u'],
//        ]);
//    }

    public function admin_creatorReg(Request $request){
        //21.05.06 김태영, validation check 추가
        $validated = $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'account_id' => ['required', 'string', 'min:2', 'max:20','unique:users', 'regex:/^[\w-]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nickname' => ['required','string','min:2'],//,'unique:creators','regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
            'month_price' => ['required','integer','max:1000000'],
        ]);

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
        return redirect('/admin/index')->with('flash_message', 'クリエイターの登録が完了しました')->with('verified', true);
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
//        $creators_cnt = DB::table("users")
////                       ->select(DB::raw("COUNT(1) as cnt"))
//                       ->join("role_user","role_user.user_id","=","users.id")
//                       ->where('role_user.role_id', '=', 2)
////                       ->get();
//                       ->count();
        //21.05.08 creators count 변경
        $creators_cnt = Creator::count();
        //21.05.12 kondo,follow count
        $followings_cnt = Following::count();
        //User
        $users_cnt = DB::table("users")
                               //->select(DB::raw("COUNT(1) as cnt"))
                               ->join("role_user","role_user.user_id","=","users.id")
                               ->where('role_user.role_id', '=', 4)
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
            'followings_cnt'=>$followings_cnt,
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
        $notice = Notice::find($request->notice_id);

        if ($notice != null) {
            $notice->delete();
        }

        return redirect('/admin/notice');
    }

    //21.05.09 김태영, 관리자 관리 화면
    public function admins($admin_id) {
        $admins = DB::table("users")
            ->join("role_user","role_user.user_id","=","users.id")
            ->whereIn('role_user.role_id', [1, 2])//1 super admin, 2 admin
            ->where('users.id', '!=', \Auth::user()->id)
            ->get();

        if ($admin_id != 'list') {
            $new = User::find($admin_id);
        }
        else {
            $new = '';
        }

        return view('admin.admins', compact('admins', 'new'));
    }

    public function adminReg() {

        return view('admin.adminReg');
    }

    public function adminReg_store(Request $request) {
        $validated = $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'account_id' => ['required', 'string', 'min:2', 'max:20','unique:users', 'regex:/^[\w-]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $new = User::create([
            'account_id' => $request->input('account_id'),
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $new->attachRole('administrator');

        return redirect('/admin/admins/'.$new->id);
    }

    public function adminDetail($admin_id) {
        $admin = User::find($admin_id);

        if($admin === null) {
            return redirect('/admin/admins/list');
        }

        return view('admin.adminDetail', compact('admin'));
    }

    public function admin_delete(Request $request) {
        $admin = User::find($request->input('admin_id'));

        if($admin != null) {
            $admin->delete();
        }

        return redirect('/admin/admins/list')->with('flash_message', $admin->last_name.' '.$admin->first_name.'を削除しました');
    }

    //21.05.10 김태영, creator 관리 상세
    public function creatorDetail($creator_id) {
        //Creator info
        $creator = Creator::join('users', 'users.id', '=', 'creators.user_id')->where('creators.user_id', $creator_id)->get();

        //投稿数 투고 수
        $tweet_cnt = tweet::where('user_id', $creator_id)->count();

        //21.05.11 김태영, creators 테이블에 field 생성
//        //会員数 회원 수
//        $follower_cnt = Following::where('creator_id', $creator_id)->count();

        //総売上額(利益) 총 매출액(이익)
        //先月総売上(利益) 지난달 총 매출(이익)
        //今月暫定総売上(利益) 이달 잠정 총 매출(이익)
        // -> 결제 확정 이후

        return view('admin.creatorDetail', compact('creator', 'tweet_cnt'));
    }

    public function updateCreatorPrice(Request $request) {
        $creator_id = $request->input('creator_id');
        $month_price = $request->input('month_price');

        //DB 쿼리 결과는 성공시 true를 반환한다.
        $result = DB::table('creators')->where('user_id', $creator_id)->update(
            ['month_price' => $month_price]
        );

        return response()->json(array('msg'=> $result), 200);
    }

    public function updateCreatorVisible(Request $request) {
        Creator::where('user_id', $request->input('creator_id'))->update(
            ['visible' => $request->input('visible')]
        );

        return redirect('/admin/index')->with('verified', true);
    }

    public function deleteCreator(Request $request) {
        //삭제되는 creator의 투고 찾기
        $tweets = DB::table('tweets')->where('user_id', $request->creator_id)->get();

        //투고 이미지들 삭제
        foreach ($tweets as $tweet) {
            Tweet_image::where('tweet_id', $tweet->id)->delete();
        }

        //투고 삭제
        tweet::where('user_id', $request->creator_id)->delete();

        //권한 삭제
        DB::table('role_user')->where('user_id', $request->creator_id)->delete();

        //입회 정보 삭제
        Following::where('creator_id', $request->creator_id)->delete();

        //creator 테이블 삭제
        Creator::where('user_id', $request->creator_id)->delete();

        //user 테이블 삭제
        $result = User::where('id', $request->creator_id)->delete();

        //업로드 폴더 삭제
        if ($result === 1) {
            File::deleteDirectory(storage_path('app/public/images/'.$request->creator_id));
        }

        return redirect('/admin/index')->with('verified', true);
    }
}
