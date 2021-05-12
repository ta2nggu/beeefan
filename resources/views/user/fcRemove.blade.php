@extends('layouts.base')

@section('title', 'マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_user.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @section('page_back')
            <div class="formBox"><a href="{{ route('joinFc', $creator[0]->account_id) }}" class="back userBack">{{ __('戻る') }}</a></div>
        @endsection
        @slot('header_title')
            <span class="name">{{ $creator[0]->nickname }}</span>{{ __('退会') }}
        @endslot
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar">
        <div class="removeBox">
            <form method="POST" action="{{ __('/mypage/fc/remove') }}" class="formBox normalFormBox">
                @csrf
                @error('cause')
                    <span class="invalid-feedback" role="alert" style="margin-bottom: 30px">
                        <strong>お手数ですが、退会前に「退会の理由」を選択してください。</strong>
                    </span>
                @enderror

                <h1>{{__('ファンクラブの退会')}}</h1>
                <p>{{__('こちらのページからファンクラブを退会することができます。退会する前に、必ず以下の注意事項をお読みになり、ご同意の上、ページ下部の退会ボタンから退会処理を行なってください。')}}</p>
                <h2>{{__('退会についてのご注意')}}</h2>
                <p>{{__('ファンクラブ限定コンテンツの閲覧ができなくなります。月の途中で退会した場合でも、1ヶ月分の料金が発生します。(日割計算にはなりません。) 退会後、同じ月に再度入会された場合は、2ヶ月分の料金が発生します。')}}</p>
                <h2>{{__('退会アンケート')}}</h2>
                <p>{{__('お手数ですが、今後のサービス向上のために退会アンケートにご協力ください。')}}</p>
                <dl class="readonlyBox">
                    <dt><label>{{ __('アカウントID') }}</label></dt>
                    <dd><p class="readonly inputCss">{{ Auth::user()->account_id }}</p></dd>
                </dl>
                <dl>
                    <dt><label>{{ __('退会の理由') }}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd>
                        <select name="cause" id="pet-select" class="@error('cause') is-invalid @enderror">
                            <option disabled selected value>{{ __('選択してください') }}</option>
                            <option value="{{ __('退会理由1') }}">{{ __('退会理由1') }}</option>
                            <option value="{{ __('退会理由2') }}">{{ __('退会理由2') }}</option>
                            <option value="{{ __('退会理由3') }}">{{ __('退会理由3') }}</option>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label>{{ __('ご意見・ご感想') }}</label></dt>
                    <dd><textarea rows="4" name="content" placeholder="{{ __('ご自由にご入力ください') }}"></textarea></dd>
                </dl>
                <p class="txtBox">{{__(' 退会手続きの直後から以下のファンクラブに含まれるコンテンツは見れなくなります。退会するファンクラブにお間違いのないよう、もう一度ファンクラブ内容をご確認ください。')}}</p>
                <h2>{{__('退会するファンクラブ')}}</h2>
                <div class="imgbox">
                    @if (isset($creator[0]->profile_img))
                        <div class="thumbnail"><img src="{{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }}" alt="{{ $creator[0]->nickname }}"></div>
                    @else
                        <div class="thumbnail"><img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $creator[0]->nickname }}"></div>
                    @endif
                    <div class="txt">
                        <p class="name">{{ $creator[0]->nickname }}</p>
                        <p class="price">{{__('月額' . number_format($creator[0]->month_price) . '円')}}<span>{{__('（税込）')}}</span></p>
                    </div>
                </div>

                <div class="centerCheckbox">
                    <input type="checkbox" id="join_chk" class="colorPi">
                    <label for="join_chk">{{ __('上記の内容に同意する')}}</label>
                </div>
                <ul class="btnBox">
                    <li><a href="{{ route('joinFc', $creator[0]->account_id) }}" class="btn btnBl">{{ __('退会をキャンセル') }}</a></li>
                    <li><button type="button" class="btn btnBor btnBorBl disabledBor" id="join_submit" disabled
                                data-toggle="modal"
                                data-target="#removeDr">{{ __('退会する') }}</button></li>
                </ul>
                <!--退会確認ポップアップ-->
                <div id="removeDr" class="modal fade warningBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="titleText">退会する</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-warning">
                                <p>退会したら取り消せません。退会してもよろしいですか？</p>
                            </div>
                            <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                            <input name="creator_id" type="hidden" value="{{ $creator[0]->user_id }}">
                            <ul class="btnBox modal-footer">
                                <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                                <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!--/contentWrap-->
@endsection
