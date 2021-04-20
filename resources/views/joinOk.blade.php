@extends('layouts.app')

@section('content')

    <h1>{{__('入会完了')}}</h1>
    <h3>{{__('入会が完了いたしました ')}}{{ $creator[0]->last_name }}{{ $creator[0]->first_name }}{{__('のコンテンツをお楽しみください')}}</h3>

    <a href="/{{ $creator[0]->account_id }}">{{ $creator[0]->last_name }}{{ $creator[0]->first_name }}の投稿を見る</a>
    マイページへ
@endsection
