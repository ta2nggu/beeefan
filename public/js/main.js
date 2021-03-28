/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
function loadMoreData(page) {
  $.ajax({
    url: '?page=' + page,
    type: 'get',
    beforeSend: function beforeSend() {
      $(".ajax-load").show();
    }
  }).done(function (data) {
    if (data.html.trim() == "") {
      $(".ajax-load").html("No more records found");
      return;
    }

    $(".ajax-load").hide(); // $("#post-data").append(data.html);
    // 21.03.28 김태영, main 화면에서 같이 사용하기 위해 클래스(.post-data)로 변경

    $(".post-data").append(data.html);
  }).fail(function (jqXHR, ajaxOptions, thrownError) {
    console.log("Server not responding..");
  });
}

var page = 1;
$(window).scroll(function () {
  if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
    page++;
    loadMoreData(page);
  } // 21.03.28 김태영, ajax infinite scrolling 실행 될 때도 owl-carousel 선언해야 함, 선언 안하면 ajax로 html 붙일 때 적용 안됨
  // $('.owl-carousel').owlCarousel 선언이 없다면  div class에 owl-loaded owl-drag 안생긴다. image slider를 사용할 수 없음


  $('.owl-carousel').owlCarousel({
    center: true,
    items: 1,
    loop: false,
    margin: 10
  });
});
$(document).ready(function () {
  $('.owl-carousel').owlCarousel({
    center: true,
    items: 1,
    loop: false,
    margin: 10
  });
});
/******/ })()
;