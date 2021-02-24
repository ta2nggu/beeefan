@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Creator Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        こんにちは。{{ $user[0]->nickname }} 様。


                        <br><br>
                        투고 수 : <br>
                        회원 수 : <br>
                        수익 : <br>
                        <br>
{{--                        <a href="/creator_write/{{ $user[0]->nickname }}">신규투고</a><br>--}}
                        <a href="/creator_write">신규투고</a><br>
                        <a href="">설정변경</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
