@extends('layouts.app')

@section('content')
    <div>
        <h2>{{ __("MEMBER'S CARD") }}</h2>
        <h3>{{ $user->account_id }}</h3>
        <div>アカウントID</div>
    </div>
    <div>
        <h2>{{ __('入会済みファンクラブ') }}</h2>
        <div class="post-data">
            @include('user/indexData')
        </div>
        <div class="ajax-load text-center">
            <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
        </div>
    </div>
@endsection
