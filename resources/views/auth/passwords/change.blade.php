@extends('layouts.app')

@section('content')
<h1>パスワード変更</h1>
<form method="POST" action="{{ __('/password/change') }}" >
    @csrf

    @foreach ($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
    @endforeach

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{__('現在のパスワード')}}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{__('新しいパスワード')}}</label>

        <div class="col-md-6">
            <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{__('新しいパスワード(確認)')}}</label>

        <div class="col-md-6">
            <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                変更する
            </button>
        </div>
    </div>
</form>

<div class="form-group row mb-0">
    <div class="col-md-8 offset-md-4">
        <button class="btn btn-secondary" onclick="history.back();">
            変更せずに戻る
        </button>
    </div>
</div>
@endsection
