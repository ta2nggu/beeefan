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

    $(".ajax-load").hide();
    $("#post-data").append(data.html);
  }).fail(function (jqXHR, ajaxOptions, thrownError) {
    console.log("Server not responding..");
  });
}

var page = 1;
$(window).scroll(function () {
  if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
    page++;
    loadMoreData(page);
  }
});
/******/ })()
;