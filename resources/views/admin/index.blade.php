@extends('layouts.app')

@section('content')
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
                            クリエイター数 : {{ $creators_cnt }}<br>
                            会員数 : {{ $users_cnt }}<br>
                            ..
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <a href="/admin/creators">クリエイター情報管理</a><br>
        <a href="">運営者情報管理</a>
    </div>
@endsection
