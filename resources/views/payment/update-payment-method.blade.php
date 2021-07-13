@extends('layouts.base')

@section('title','決済方法選択')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $( document ).ready(function() {
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            var ajaxLoadImgTag = $(".ajax-load").length > 0 ? $(".ajax-load").html() : "";

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                } else {
                    // The card has been verified successfully...
                    console.log(typeof setupIntent.payment_method);
                    e.preventDefault();
                    $.ajax({
                        url: '/stripe/savePaymentMethod',
                        type: 'post',
                        //검색어 search 변수에 담아서 보냄
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'payment_method': setupIntent.payment_method
                        },
                        beforeSend: function beforeSend() {
                            //loading image 보여주기
                            $(".ajax-load").html(ajaxLoadImgTag);
                            $(".ajax-load").show();
                        }
                    }) //검색 호출 끝날 때
                        .done(function (data) {
                            //loading image 숨김
                            $(".ajax-load").hide(); //검색 결과 없을 때

                            if (data.html.trim() == "") {
                                $('.post-data').html("failed");
                                return;
                            } //검색 결과


                            $('.post-data').html(data.html); //21.04.17 김태영, 검색 후 page 초기화 해줘야 다시 infinite scrolling 작동함

                            page = 1;
                        }) //검색 실패
                        .fail(function (jqXHR, ajaxOptions, thrownError) {
                            console.log("Server not responding..");
                        });
                }
            });
        });
    </script>

@endsection
@section('body','')

@section('content')
    <input id="card-holder-name" type="text" placeholder="card holder name">

    <!-- Stripe Elements Placeholder -->
    <div id="card-element"></div>

    <button id="card-button" data-secret="{{ $intent->client_secret }}">
        Update Payment Method
    </button>
    <div class="ajax-load" style="display: none">
        <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
    </div>

    <div class="post-data">

    </div>
@endsection
