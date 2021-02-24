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

                        <a href="/admin_creatorRegPage">クリエイター新規登録</a><br>

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
