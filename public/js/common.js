/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/common.js ***!
  \********************************/
//font
(function (d) {
  var config = {
    kitId: 'uiw2dop',
    scriptTimeout: 3000,
    async: true
  },
      h = d.documentElement,
      t = setTimeout(function () {
    h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
  }, config.scriptTimeout),
      tk = d.createElement("script"),
      f = false,
      s = d.getElementsByTagName("script")[0],
      a;
  h.className += " wf-loading";
  tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
  tk.async = true;

  tk.onload = tk.onreadystatechange = function () {
    a = this.readyState;
    if (f || a && a != "complete" && a != "loaded") return;
    f = true;
    clearTimeout(t);

    try {
      Typekit.load(config);
    } catch (e) {}
  };

  s.parentNode.insertBefore(tk, s);
})(document); //moreArea


$(function () {
  $('.moreBtn').on('click', function () {
    if ($(this).parent().hasClass('open')) {
      $(this).html('..続きを読む');
      $(this).parent().removeClass('open');
    } else {
      $(this).html('閉じる');
      $(this).parent().addClass('open');
    }
  });
}); //infoBox

$(function () {
  $('#infoBox .ttl').on('click', function () {
    $(this).toggleClass('active');
    $(this).next().slideToggle();
  });
}); //helpBox

$(function () {
  $('.helpBox dt').on('click', function () {
    $(this).toggleClass('active');
    $(this).next().slideToggle();
  });
});
$(function () {
  /* ログアウト（2重モーダル） */
  $('#warningLogoutBtn').on('click', function () {
    $('#menuDr').modal('hide');
    $('#warningLogout').modal('show');
  });
  /* 投稿削除（2重モーダル） */

  $('.postEditDelete').on('click', function () {
    $(this).parents('.postEditBox').modal('hide');
    $(this).parents('.postEditBox').nextAll('.warningDre').modal('show');
  });
  /* 下書きへ（2重モーダル） */

  $('.postEditInvisible').on('click', function () {
    $(this).parents('.postEditBox').modal('hide');
    $(this).parents('.postEditBox').nextAll('.warningInvi').modal('show');
  });
});
$(function () {
  //同意して入会
  $('#join_chk').change(function () {
    var prop = $('#join_submit').prop('disabled');

    if (prop) {
      $('#join_submit').prop('disabled', false);
    } else {
      $('#join_submit').prop('disabled', true);
    }
  });
});
/******/ })()
;