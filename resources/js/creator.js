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



var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
    var label	 = input.nextElementSibling,
        labelVal = label.innerHTML;

    input.addEventListener( 'change', function( evt )
    {
        var files = evt.target.files; // FileList object

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    label.style.backgroundImage = "url(" + e.target.result + ")";
                    label.innerHTML = "";
                    // // Render thumbnail.
                    // var span = document.createElement('span');
                    // span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    //     '" title="', escape(theFile.name), '"/>'].join('');
                    // document.getElementById('list').insertBefore(span, null);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    });
});

//21.07.15 김태영, creator profile image, background image cropper js 적용
import Cropper from 'cropperjs'
import 'cropperjs/dist/cropper.css'
var modalTemplate = '<div class="modal"><div class="modalInner"><div><div class="image-container"></div><ul><li><button class="crop-cancel">取消</button></li><li><button class="crop-upload">適用</button></li></ul></div></div></div>';
let croping;

const renameFile = (originalFile, newName) => {
    return new File([originalFile], newName, { type: originalFile.type, lastModified: originalFile.lastModified, });
};

var resizeImage = function (settings) {
    var file = settings.file;
    var maxSize = settings.maxSize;
    var reader = new FileReader();
    var image = new Image();
    var canvas = document.createElement('canvas');
    var dataURItoBlob = function (dataURI) {
        var bytes = dataURI.split(',')[0].indexOf('base64') >= 0 ?
            atob(dataURI.split(',')[1]) :
            unescape(dataURI.split(',')[1]);
        var mime = dataURI.split(',')[0].split(':')[1].split(';')[0];
        var max = bytes.length;
        var ia = new Uint8Array(max);
        for (var i = 0; i < max; i++)
            ia[i] = bytes.charCodeAt(i);
        return new Blob([ia], { type: 'image/jpeg'});
    };
    var resize = function () {
        var width = image.width;
        var height = image.height;
        if (width > height) {
            if (width > maxSize) {
                height *= maxSize / width;
                width = maxSize;
            }
        } else {
            if (height > maxSize) {
                width *= maxSize / height;
                height = maxSize;
            }
        }
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
        var dataUrl = canvas.toDataURL('image/jpeg');
        return dataURItoBlob(dataUrl);
    };
    return new Promise(function (ok, no) {
        if (!file.type.match(/image.*/)) {
            no(new Error("Not an image"));
            return;
        }
        reader.onload = function (readerEvent) {
            image.onload = function () { return ok(resize()); };
            image.src = readerEvent.target.result;
        };
        reader.readAsDataURL(file);
    });
};

function dataURItoBlob(dataURI) {
    var byteString = atob(dataURI.split(',')[1]);
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ab], { type: 'image/jpeg' });
}

/*21.04.08 김태영, creator mypage background_img, profile_img */
$(document).ready(function (e) {
    function doCropper(type) {
        var input_tag, preview_img;
        if (type == 'back') {
            input_tag = $('#input_background_img');
            preview_img = $('#preview_background_img');
        }
        else {
            input_tag = $('#input_profile_img');
            preview_img = $('#preview_profile_img');
        }
        let reader = new FileReader();
        reader.readAsDataURL(input_tag[0].files[0]);

        reader.onload = (e) => {
            if (input_tag[0].files[0].cropped) {
                return;
            }

            var unixtime = new Date().getTime();

            // cache filename to re-assign it to cropped file
            var cachedFilename = unixtime + '_' + input_tag[0].files[0].name;

            // dynamically create modals to allow multiple files processing
            var $cropperModal = $(modalTemplate);
            // 'Crop and Upload' button in a modal
            var $uploadCrop = $cropperModal.find('.crop-upload');
            var $cancelCrop = $cropperModal.find('.crop-cancel');

            $('.image-container img').remove();

            var $img = $('<img />');

            var reader2 = new FileReader();
            reader2.onloadend = function () {
                // add uploaded and read image to modal
                $cropperModal.find('.image-container').html($img);
                $img.attr('src', reader2.result);

                croping = new Cropper($('.image-container img')[0], {
                    aspectRatio: type == 'back' ? 32 / 15 : 1
                    // aspectRatio: 16 / 9,
                    ,autoCropArea: 1
                    ,movable: true
                    ,cropBoxResizable: true
                    // ,minContainerWidth: 850
                });
            };

            // read uploaded file (triggers code above)
            reader2.readAsDataURL(input_tag[0].files[0]);

            $cropperModal.modal('show');

            // listener for 'Crop and Upload' button in modal
            $uploadCrop.on('click', function() {
                // get cropped image data
                var blob = croping.getCroppedCanvas().toDataURL(input_tag[0].files[0].type, 0.9);
                // transform it to Blob object
                var newFile;
                resizeImage({
                    file: dataURItoBlob(blob),
                    maxSize: type == 'back' ? 640 : 250
                }).then(function (resizedImage) {
                    reader.onload = function(e){
                        newFile = resizedImage;
                        // set 'cropped to true' (so that we don't get to that listener again)
                        newFile.cropped = true;
                        // assign original filename
                        newFile.name = cachedFilename;

                        // add cropped file to dropzone
                        // var unixtime = new Date().getTime();
                        // var newFile = renameFile(reader, unixtime + '_' + $('#input_background_img')[0].files[0].name);
                        let container = new DataTransfer();
                        let newFileObject = new File([newFile], newFile.name);
                        container.items.add(newFileObject);

                        var reader_preview = new FileReader();
                        reader_preview.onload = function(e) {
                            preview_img.attr('src', reader_preview.result);
                        }
                        reader_preview.readAsDataURL(newFile);

                        input_tag[0].files = container.files;

                        // upload cropped file with dropzone
                        $cropperModal.modal('hide');
                    };
                    reader.readAsDataURL(input_tag[0].files[0]);
                });
            });
            $cancelCrop.on('click', function() {
                $cropperModal.modal('hide');
            });
        }
    }

    $('#input_background_img').change(function(){
        // let reader = new FileReader();
        //
        // reader.onload = (e) => {
        //     $('#preview_background_img').attr('src', e.target.result);
        // }
        // reader.readAsDataURL(this.files[0]);

        doCropper('back');
    });

    $('#input_profile_img').change(function(){
        // let reader = new FileReader();
        //
        // reader.onload = (e) => {
        //     $('#preview_profile_img').attr('src', e.target.result);
        // }
        // reader.readAsDataURL(this.files[0]);

        doCropper('profile');
    });

    // 21.04.10 김태영, add link
    $('#btnLinkSave').click(function() {

        $('.required_alert.display_text').css('display', 'none');
        $('.required_alert.url').css('display', 'none');

        // 표시 문자
        var display_text = $('#display_text').val();
        var url = $('#url').val();

        if (display_text === ""){
            $('.required_alert.display_text').css('display', 'block');
            $('#display_text').focus();
            return;
        }
        if (url === ""){
            $('.required_alert.url').css('display', 'block');
            $('#url').focus();
            return;
        }

        $('#display_text').val('');
        $('#url').val('');
        var result = '<p><a href="' + url + '" target="_blank" >' + display_text +  '</a></p>';
        $('#instruction').append(result);
        $('#add_link').modal('hide');
    });

    $('#c_mypage_submit').click(function() {
        $('#c_mypage_instruction').val($('#instruction').html());
        console.log($('#input_background_img').val());
    });
});

// 21.04.09 김태영, add hyper link
//div 수정할 수 있도록 해준다
if (document.getElementById("instruction") != null)
    document.getElementById("instruction").contentEditable='true';
