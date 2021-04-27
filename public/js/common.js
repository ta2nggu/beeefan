/******/ (() => { // webpackBootstrap
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
}); //menuDrawer

$(function () {
  $('#menuDrawer').on('click', function () {
    $(this).toggleClass('active');
    $("#menuDrawerContent").toggleClass('active');
  });
});
/******/ })()
;