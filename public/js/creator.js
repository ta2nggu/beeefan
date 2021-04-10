/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/creator.js ***!
  \*********************************/
// function handleFileSelect(evt) {
//     var files = evt.target.files; // FileList object
//
//     console.log(evt.nextElementSibling);
//
//     // Loop through the FileList and render image files as thumbnails.
//     for (var i = 0, f; f = files[i]; i++) {
//
//         // Only process image files.
//         if (!f.type.match('image.*')) {
//             continue;
//         }
//
//         var reader = new FileReader();
//
//         // Closure to capture the file information.
//         reader.onload = (function(theFile) {
//             return function(e) {
//                 // // Render thumbnail.
//                 // var span = document.createElement('span');
//                 // span.innerHTML = ['<img class="thumb" src="', e.target.result,
//                 //     '" title="', escape(theFile.name), '"/>'].join('');
//                 // document.getElementById('list').insertBefore(span, null);
//             };
//         })(f);
//
//         // Read in the image file as a data URL.
//         reader.readAsDataURL(f);
//     }
// }
// //document.getElementsByClassName('inputfile').addEventListener('change', handleFileSelect, false);
// var elements = document.getElementsByClassName("inputfile");
// Array.from(elements).forEach(function(element) {
//     element.addEventListener('change', handleFileSelect, false);
// });
var inputs = document.querySelectorAll('.inputfile');
Array.prototype.forEach.call(inputs, function (input) {
  var label = input.nextElementSibling,
      labelVal = label.innerHTML;
  input.addEventListener('change', function (evt) {
    var files = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.

    for (var i = 0, f; f = files[i]; i++) {
      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader(); // Closure to capture the file information.

      reader.onload = function (theFile) {
        return function (e) {
          label.style.backgroundImage = "url(" + e.target.result + ")";
          label.innerHTML = ""; // // Render thumbnail.
          // var span = document.createElement('span');
          // span.innerHTML = ['<img class="thumb" src="', e.target.result,
          //     '" title="', escape(theFile.name), '"/>'].join('');
          // document.getElementById('list').insertBefore(span, null);
        };
      }(f); // Read in the image file as a data URL.


      reader.readAsDataURL(f);
    }
  });
});
/*21.04.08 김태영, creator mypage background_img, profile_img */

$(document).ready(function (e) {
  $('#input_background_img').change(function () {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#preview_background_img').attr('src', e.target.result);
    };

    reader.readAsDataURL(this.files[0]);
  });
  $('#input_profile_img').change(function () {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#preview_profile_img').attr('src', e.target.result);
    };

    reader.readAsDataURL(this.files[0]);
  }); // 21.04.10 김태영, add link

  $('#btnLinkSave').click(function () {
    $('.required_alert.display_text').css('display', 'none');
    $('.required_alert.url').css('display', 'none'); // 표시 문자

    var display_text = $('#display_text').val();
    var url = $('#url').val();

    if (display_text === "") {
      $('.required_alert.display_text').css('display', 'block');
      $('#display_text').focus();
      return;
    }

    if (url === "") {
      $('.required_alert.url').css('display', 'block');
      $('#url').focus();
      return;
    }

    $('#display_text').val('');
    $('#url').val('');
    var result = '<a href="' + url + '" target="_blank" >' + display_text + '</a>';
    $('#instruction').append(result);
    $('#add_link').modal('hide');
  });
}); // 21.04.09 김태영, add hyper link
//div 수정할 수 있도록 해준다

document.getElementById("instruction").contentEditable = 'true';
/******/ })()
;