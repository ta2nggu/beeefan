@extends('layouts.app')

@section('content')
{{--    21.04.15 김태영--}}
{{--    index 화면에서 바로 creator 등록 화면으로 이동--}}
{{--    index 화면에 creator list 보여줌--}}
{{--    creatorList.blade.php는 사용 안함--}}
    {{-- 運営者管理画面 운영자관리화면 --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Admin Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="/admin/creatorReg">クリエイター新規登録</a><br>

                        {{ $creator_list }}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>

        <a href="">運営者情報管理</a>
    </div>
@endsection
