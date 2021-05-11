/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
// loadMoreData infinite scrolling
// 사용하는 곳
// views/timeline.blade.php
// views/main.blade.php
// views/admin/index.blade.php
function loadMoreData(page) {
  //21.04.17 김태영, admin/index.blade.php creator 검색 기능을 위해 추가
  $search = $('#search_creator_input').length > 0 ? $('#search_creator_input').val() : null; //21.04.17 김태영, admin/index.blade.php creator 정렬 기능을 위해 추가

  if ($('#search_creator_select').length > 0) {
    $sorting = $('#search_creator_select').val().split(",")[0];
    $direction = $('#search_creator_select').val().split(",")[1];
  } else {
    $sorting = null;
    $direction = null;
  }

  $.ajax({
    url: '?page=' + page,
    type: 'get',
    //21.04.17 김태영, admin/index.blade.php creator 검색 기능을 위해 추가
    //21.04.18 김태영, sorting 정렬 추가
    data: {
      'search': $search,
      'sorting': $sorting,
      'direction': $direction
    },
    beforeSend: function beforeSend() {
      $(".ajax-load").show();
    }
  }).done(function (data) {
    if (data.html.trim() == "") {
      //21.04.27 kon, 注意文言なし
      $(".ajax-load").html("");
      return;
    }

    $(".ajax-load").hide(); // $("#post-data").append(data.html);
    // 21.03.28 김태영, main 화면에서 같이 사용하기 위해 클래스(.post-data)로 변경

    $(".post-data").append(data.html);
  }).fail(function (jqXHR, ajaxOptions, thrownError) {
    console.log("Server not responding..");
  });
} //21.05.06 kondo, first view hide


$(function () {
  if ($('.ajax-load').length) {
    var loadRange = $(".ajax-load").offset().top;
    var windowSize = $(window).height();

    if (loadRange < windowSize) {
      $(".ajax-load").hide();
    }
  }
}); //21.04.18 김태영, search 검색이나 sorting 정렬은 infinite scrolling 과 다르게 다시 조회 됨
//append가 아닌 html 내용을 새롭게 출력하기 위함

function loadMoreDataWithoutPage() {
  $search = $('#search_creator_input').length > 0 ? $('#search_creator_input').val() : null;

  if ($('#search_creator_select').length > 0) {
    $sorting = $('#search_creator_select').val().split(",")[0];
    $direction = $('#search_creator_select').val().split(",")[1];
  } else {
    $sorting = null;
    $direction = null;
  }

  $.ajax({
    url: '/admin/index',
    type: 'get',
    //검색어 search 변수에 담아서 보냄
    data: {
      'search': $search,
      'sorting': $sorting,
      'direction': $direction
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
      $('.post-data').html("データがありません。");
      return;
    } //검색 결과


    $('.post-data').html(data.html); //21.04.17 김태영, 검색 후 page 초기화 해줘야 다시 infinite scrolling 작동함

    page = 1;
  }) //검색 실패
  .fail(function (jqXHR, ajaxOptions, thrownError) {
    console.log("Server not responding..");
  });
}

var page = 1; //21.04.17 김태영, 검색기능을 사용하게 되면 다시 loading 이미지를 보여줘야 하기 때문에

var ajaxLoadImgTag = $(".ajax-load").length > 0 ? $(".ajax-load").html() : ""; //21.04.17 김태영, post-data class 존재할 때만

if ($(".post-data").length > 0) {
  $(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
      page++;
      loadMoreData(page);
    } // 21.03.28 김태영, ajax infinite scrolling 실행 될 때도 owl-carousel 선언해야 함, 선언 안하면 ajax로 html 붙일 때 적용 안됨
    // $('.owl-carousel').owlCarousel 선언이 없다면  div class에 owl-loaded owl-drag 안생긴다. image slider를 사용할 수 없음


    if ($(".owl-carousel").length > 0) {
      $('.owl-carousel').owlCarousel({
        center: true,
        items: 1,
        loop: true,
        onInitialized: counter,
        onTranslated: counter,
        margin: 10
      });
    }
  });
}

$(document).ready(function () {
  //21.04.17 김태영, owl-carousel class 존재할 때만
  if ($(".owl-carousel").length > 0) {
    $('.owl-carousel').owlCarousel({
      center: true,
      items: 1,
      loop: true,
      onInitialized: counter,
      onTranslated: counter,
      margin: 10
    });
  }
});

function counter(event) {
  var items = $(event.target).find(".owl-dot").length; // Number of items

  var item = $(event.target).find(".owl-dot.active").index() + 1; // Position of the current item
  // console.log(item+" / "+items);
  // console.log($(event.target));

  $(event.target).find('.counter').html(item + " / " + items);
} //21.04.17 김태영, admin index page 에서 creator 검색


$('#search_creator_input').on('keyup', function () {
  loadMoreDataWithoutPage();
}); //21.04.17 김태영, admin index page sorting select combo box

$('#search_creator_select').change(function () {
  loadMoreDataWithoutPage();
}); //21.04.19 김태영, 입회 이용약관 동의 체크 박스

$('#join_chk').change(function () {
  if (this.checked) {
    $('#join_submit').attr('disabled', false);
  } else {
    $('#join_submit').attr('disabled', true);
  }
}); //21.05.11 김태영, super admin이 creator 월 액 수정

$('#btnUpdateCreatorPrice').click(function () {
  $('#updatedMonthlyPrice').css('display', 'block');
  $.ajax({
    //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'post',
    // url: '{{ route('web.php에 선언된 route 경로') }}',
    url: '/creator/month_price',
    dataType: 'json',
    data: {
      'creator_id': $('#inPriceUpdateCreatorId').val(),
      'month_price': $('#inMonthlyPrice').val()
    },
    success: function success(data) {
      // console.log(data);
      $('#updatedMonthlyPrice').text('월액 수정 완료!!!');
    },
    error: function error(data) {
      // console.log("error" +data);
      $('#updatedMonthlyPrice').text('월액 수정 실패ㅜㅜ');
    }
  });
});
/******/ })()
;