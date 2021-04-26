@extends('layouts.app')

@section('content')
    <h1>メールアドレス変更</h1>

    <h2>{{ __('現在のメールアドレス') }}</h2>
    <h3>{{ $user[0]->email }}</h3>

    <form method="POST" action="{{ __('/email/change') }}" >
        @csrf

        @foreach ($errors->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach

        <div class="form-group row">
            <label for="new_email" class="col-md-4 col-form-label text-md-right">{{__('新しいメールアドレス')}}</label>

            <div class="col-md-6">
                <input id="new_email" type="text" class="form-control" name="email" autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <label for="confirm_email" class="col-md-4 col-form-label text-md-right">{{__('新しいメールアドレス(確認)')}}</label>

            <div class="col-md-6">
                <input id="confirm_email" type="text" class="form-control" name="confirm_email" autocomplete="off">
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
