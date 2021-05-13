@extends('layouts.base')

@section('title',$creator[0]->nickname.'クリエイター情報')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')

    <?php
        function dateFormat($timestamp) {
            $year = date('Y', strtotime($timestamp));
            $month = strval(intval(date('m', strtotime($timestamp))));
            $day = strval(intval(date('d', strtotime($timestamp))));
            $date = $year.'/'.$month.'/'.$day;
            return $date;
        }
    ?>

    @component ('components.header')
        @slot('header_title')
            <span class="name">{{ $creator[0]->nickname }}</span>{{ __('クリエイター情報') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentBtmMar">

        <div id="profileHeader" class="profileHeaderNoBk">
            <div class="imgbox">
                @if (isset($creator[0]->profile_img))
                    <div class="thumbnail"><img src="{{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }}" alt="{{ $creator[0]->nickname }}"></div>
                @else
                    <div class="thumbnail"><img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $creator[0]->nickname }}"></div>
                @endif
            </div>
        </div>
        <div id="profileBox">
            <h1 class="name">{{ $creator[0]->nickname }}</h1>
            <p class="price">{{__('月額' . number_format($creator[0]->month_price) . '円')}}<span>{{__('（税込）')}}</span></p>
            <div class="score clm2">
                <dl>
                    <dt>{{__('投稿数')}}</dt>
                    <dd>{{ number_format($tweet_cnt) }}</dd>
                </dl>
                <dl>
                    <dt>{{__('会員数')}}</dt>
                    <dd>{{ number_format($creator[0]->follower_cnt) }}</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>{{__('総売上額')}}</dt>
                    <dd>0
                        <span class="period">
                            @php
                                echo '('.dateFormat($creator[0]->created_at).' ~ '.dateFormat(date("Y-m-d H:i:s")).')';
                            @endphp
                        </span>
                    </dd>
                </dl>
            </div>
            <div class="score scorePrice">
                <dl>
                    <dt>{{__('先月総売上')}}</dt>
                    <dd>0</dd>
                </dl>
                <dl>
                    <dt>{{__('今月暫定総売上')}}</dt>
                    <dd>0</dd>
                </dl>
            </div>
            @if ($creator[0]->visible === 1)
            <div class="btnBox">
                <p><a href="/{{ $creator[0]->account_id }}" class="btn btnBor btnBorLp">{{__('公開ページを確認')}}</a></p>
            </div>
            @endif

        </div>

        <div id="adminCreatorDetail" class="formBox normalFormBox">
            @role('superadministrator')
                <div id="changeMonthlyPrice">
                    <h2>月額変更</h2>
                    <p>月額は運営管理者しか変更できません。変更する場合は、金額を記入し「月額を変更する」ボタンを押してください。</p>
                    <div class="monthly_priceBox">
                        <input id="inMonthlyPrice" type="number" class="form-control @error('month_price') is-invalid @enderror"  name="month_price" value="{{$creator[0]->month_price}}" required autocomplete="month_price" autofocus>
                    </div>
                    @error('month_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <input id="inPriceUpdateCreatorId" type="hidden" name="creator_id" value="{{ $creator[0]->user_id }}">
                    <button id="btnUpdateCreatorPrice" type="submit" class="btn btnAd">{{ __('月額を変更する') }}</button>
                    <div id="updatedMonthlyPrice" style="color: red; display: none;"></div>
                </div>
            @endrole

            <dl>
                <dt>{{__('公開ステータス')}}</dt>
                <dd>
                    @if($creator[0]->visible === 0)
                        {{__('非公開')}}
                    @else
                        {{__('公開中')}}
                    @endif
                </dd>
            </dl>
            <dl>
                <dt>{{__('アカウントID')}}</dt>
                <dd>{{ $creator[0]->email }}</dd>
            </dl>
            <dl>
                <dt>{{__('名前')}}</dt>
                <dd class="nameBox">
                    <span>{{ $creator[0]->last_name.(' ') }}</span>
                    <span>{{ $creator[0]->first_name }}</span>
                </dd>
            </dl>
            <dl>
                <dt>{{__('メールアドレス')}}</dt>
                <dd>{{ $creator[0]->email }}</dd>
            </dl>
{{--            <dl>--}}
{{--                <dt>{{__('パスワード')}}</dt>--}}
{{--                <dd>--}}
{{--                    <p>{{__('*********')}}</p>--}}
{{--                    <p class="txtLink NoMrg right"><a href="{{ url('/password/creator/'.$creator[0]->user_id) }}">{{__('パスワードを変更する')}}</a></p>--}}
{{--                </dd>--}}
{{--            </dl>--}}

            <!--非公開/公開-->
            <form method="POST" action="{{ __('/creator/visible') }}">
                @csrf
                <input type="hidden" name="creator_id" value="{{ $creator[0]->user_id }}">
                <ul class="btnBox">
                    @if ($creator[0]->visible === 1)
                        <li>
                            <input type="hidden" name="visible" value="0">
                            <button type="button" class="btn btnAd2" data-toggle="modal" data-target="#visibleDr">{{__('クリエイターを非公開にする')}}</button>
                        </li>
                    @else
                        <li>
                            <input type="hidden" name="visible" value="1">
                            <button type="button" class="btn btnAd2" data-toggle="modal" data-target="#visibleDr">{{__('クリエイターを公開する')}}</button>
                        </li>
                    @endif
                </ul>
                <!--非公開/公開ポップアップ-->
                <div id="visibleDr" class="modal fade warningBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                @if ($creator[0]->visible === 1)
                                    <p class="titleText">{{__('クリエイターを非公開にする')}}</p>
                                @else
                                    <p class="titleText">{{__('クリエイターを公開する')}}</p>
                                @endif
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-warning">
                                @if ($creator[0]->visible === 1)
                                    <p class="center">{{__('非公開にしてもよろしいですか？')}}</p>
                                @else
                                    <p class="center">{{__('公開にしてもよろしいですか？')}}</p>
                                @endif
                            </div>
                            <ul class="btnBox modal-footer">
                                <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                                <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
            <!--削除-->
            <form method="POST" action="{{ __('/creator/del') }}" style="margin-top: 10px">
                @csrf
                <input type="hidden" name="creator_id" value="{{ $creator[0]->user_id }}">
                <button type="button" class="btn btnBor btnBorGy" data-toggle="modal" data-target="#removeDr">{{__('クリエイターを削除する')}}</button>
                <!--削除ポップアップ-->
                <div id="removeDr" class="modal fade warningBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="titleText">{{__('クリエイターを削除する')}}</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-warning">
                                <p>{{__('削除したら取り消せません。削除してもよろしいですか？')}}</p>
                            </div>
                            <ul class="btnBox modal-footer">
                                <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                                <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                            </ul>
                            </div>
                        </div>
                    </div>
            </form>

        </div>

        @component ('components.bottomFixed')
        @endcomponent

    </div><!--/contentWrap-->
@endsection
