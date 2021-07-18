<template>
<div>
    <p class="infoTxt">投稿後に画像の変更・削除・並び替えはできません。<br>画像・動画合わせて6枚まで投稿可能です。<br>動画は10秒までアップロード可能です。</p>
    <vue-dropzone
        ref="myVueDropzone"
        id="dropzone"
        :options="dropzoneOptions"
        v-on:vdropzone-sending="sendingEvent"
        v-on:vdropzone-file-added="addedEvent"
        v-on:vdropzone-removed-file="removedEvent"
        v-on:vdropzone-success="successEvent"
        v-on:vdropzone-thumbnail="thumbnailEvent"
        v-on:vdropzone-drag-enter="dragEvent"
    >
    </vue-dropzone>
    <div class='more' ref='more'><div></div></div>
    <div class="msg">
        <textarea class="msgTextarea" v-model="msg" placeholder="テキストを入力してください (400文字以内)"></textarea>
    </div>

    <div class="btnDropUp">
        <button class="btnUpload btn btnPi" v-on:click="processQueue(1)" :disabled="disableUploadButton">投稿する</button>
    </div>
    <div class="btnDropUp">
        <button class="btnInvisible btn btnBorLp" v-on:click="processQueue(0)" :disabled="disableUploadButton">下書き保存</button>
    </div>
</div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Cropper from 'cropperjs'
import 'cropperjs/dist/cropper.css'

import * as draganddrop from '../draganddrop.js'

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
// transform cropper dataURI output to a Blob which Dropzone accepts
function dataURItoBlob(dataURI) {
    var byteString = atob(dataURI.split(',')[1]);
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ab], { type: 'image/jpeg' });
}
// modal window template
var modalTemplate = '<div class="modal"><div class="modalInner"><div><div class="image-container"></div><ul><li><button class="crop-cancel">取消</button></li><li><button class="crop-upload">適用</button></li></ul></div></div></div>';
let croping;

export default {
    name: 'Dropzone',
    props: {
        currentUser: {
            type: Number,
            required: true
        }
        , tweet_images :Array
    },
    components: {
        vueDropzone: vue2Dropzone
    },
    data() {
        return {
            msg:"",
            visible:1,
            main_img:"",
            main_img_mime_type:"",
            main_img_idx:0,
            include_video:0,
            file_cnt:0,
            disableUploadButton: true,
            imgPrivate: [],
            dropzoneOptions: {
                //21.03.21 김태영, url 앞에 '/' 없으면 web.php 을 바라보게 됨
                url: 'api/DropUp',
                thumbnailWidth: 320,
                thumbnailHeight: 320,
                headers: { "My-Awesome-Header": "header value" },
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 6, //10
                parallelUploads: 6, //10
                dictDefaultMessage: '',
                clickable: '.more',
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.mp4,.mkv,.avi,.MOV"
                // maxFilesize: 5//MB
            },
            editMode:0,//21.05.01 김태영, 편집하기
            tweet_id:null,//21.05.02 김태영, 편집하기
            tweet_image_id:[],//21.05.02 김태영, 편집하기
        }
    },
    mounted () {
        //mounted - vue js 처음 실행될 때
        this.$el.removeChild(this.$refs.more)
        let dropzone = this.$refs.myVueDropzone.dropzone
        dropzone.element.appendChild(this.$refs.more)

        //파일 선택 시 다중 선택 막기
        dropzone.hiddenFileInput.removeAttribute("multiple");

        $(document).change(function () {
            dropzone.hiddenFileInput.removeAttribute("multiple");
        });

        //21.07.16 김태영, drag and drop 제거
        // //재정렬 drag and drop 사용
        // $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});

        //21.05.01 김태영, 편집하기
        if (typeof this.tweet_images != "undefined") {
            this.editMode = 1;

            //21.07.17 김태영, drag and drop 제거 -> destroy 만 있어도 실행 됨
            // $('#dropzone').sortable('destroy');

            this.disableUploadButton = false;

            this.tweet_id = this.tweet_images[0].tweet_id;

            this.msg = this.tweet_images[0].msg;

            var _i, _len;
            for (_i = 0, _len = this.tweet_images.length; _i < _len; _i++) {
                var myBlob;
                var GetFileBlobUsingURL = function (url, convertBlob) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", url);
                    xhr.responseType = "blob";
                    xhr.addEventListener('load', function() {
                        convertBlob(xhr.response);
                    });
                    xhr.send();
                };
                var blobToFile = function (blob, name) {
                    blob.lastModifiedDate = new Date();
                    blob.name = name;
                    return blob;
                };
                var GetFileObjectFromURL = function(filePathOrUrl, convertBlob) {
                    GetFileBlobUsingURL(filePathOrUrl, function (blob) {
                        convertBlob(blobToFile(blob, 'testFile.jpg'));
                    });
                };
                var FileURL=this.tweet_images[_i].path;
                GetFileObjectFromURL(FileURL, function (fileObject) {
                    myBlob = fileObject;
                });
                var myFile = new File([myBlob], this.tweet_images[_i].name);
                myFile['private'] = this.tweet_images[_i].private;
                myFile['status'] = "queued";
                myFile['upload'] = {chunked: false};
                myFile['tweet_image_id'] = this.tweet_images[_i].tweet_image_id;
                dropzone.emit("addedfile", myFile);
                dropzone.emit("thumbnail", myFile, this.tweet_images[_i].path);
                dropzone.emit("complete", myFile);
                dropzone.files.push(myFile);

                dropzone.options.url = '../api/DropUp';
            }

            $('.more').css('display', 'none');
            $('.dz-remove').css('display', 'none');
            $('.dz-size').css('display', 'none');
        }

    },
    methods: {
        sendingEvent (file, xhr, formData) {
            formData.append('id', this.currentUser);
            formData.append('msg', this.msg);
            //21.03.20 김태영, tweet 공개여부
            formData.append('visible', this.visible);
            //21.03.22 김태영, tweets table 파일 총 개수
            formData.append('file_cnt', this.file_cnt);
            //21.03.22 김태영, video 포함 여부 체크
            formData.append('include_video', this.include_video);
            //21.03.22 김태영, 전체공개 대표 이미지 찾기
            formData.append('main_img', this.main_img);
            formData.append('main_img_mime_type', this.main_img_mime_type);
            //21.03.25 김태영, 전체공개 대표 이미지 index 추가
            formData.append('main_img_idx', this.main_img_idx);
            //21.05.01 김태영, 투고편집
            formData.append('editMode', this.editMode);
            //21.05.01 김태영, 투고편집
            formData.append('tweet_id', this.tweet_id);

            var str = file.previewElement.querySelector("input[name='private']");
            this.imgPrivate.push($(str).val());
            formData.append('private', this.imgPrivate);

            //21.05.02 김태영, 투고편집
            if (this.editMode === 1) {
                var strTweet_image_id = file.previewElement.querySelector("input[name='tweet_image_id']");
                this.tweet_image_id.push($(strTweet_image_id).val());
                formData.append('tweet_image_id', this.tweet_image_id);
            }
        },
        addedEvent (file) {
            //신규투고
            if (this.editMode === 0) {
                var varthis = this;
                let dropzone = this.$refs.myVueDropzone.dropzone;

                this.disableUploadButton = false;

                //21.03.03 김태영, 중복된 파일 제거
                var files = this.$refs.myVueDropzone.dropzone.files;
                if (files) {
                    var _i, _len;
                    for (_i = 0, _len = files.length; _i < _len - 1; _i++) // -1 to exclude current file
                    {
                        if (
                            files[_i].name === file.name
                            && files[_i].size === file.size
                            //&& files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()
                            )
                        {
                            this.$refs.myVueDropzone.dropzone.removeFile(file);
                            this.$fire({
                                text: "重複したファイルがあります。",
                                type: "error",
                                timer: 3000
                            }).then(r => {
                                console.log(r.value);
                            });
                            return;
                        }
                    }
                }

                var unique_field_id = new Date().getTime();
                var btnPrivate = document.createElement("div");
                btnPrivate.id = "btn" + unique_field_id;
                btnPrivate.className = "btnPrivate"
                file.previewElement.appendChild(btnPrivate);

                var inputPrivate = document.createElement("input");
                inputPrivate.id = "private" + unique_field_id;
                inputPrivate.className = 'inPrivate';
                inputPrivate.name = "private";
                inputPrivate.type = 'hidden';
                file.previewElement.appendChild(inputPrivate);

                btnPrivate.addEventListener('click', function (e) {
                    e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                    e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지

                    if(btnPrivate.innerText.toLowerCase() === '無料公開') {
                        btnPrivate.innerText = '有料公開';
                        btnPrivate.style.borderColor = '#dfa4ad';
                        btnPrivate.style.color = '#dfa4ad';
                        inputPrivate.value = '1';
                    }
                    else {
                        btnPrivate.innerText = '無料公開';
                        btnPrivate.style.borderColor = '#9cc5eb';
                        btnPrivate.style.color = '#9cc5eb';
                        inputPrivate.value = '0';
                    }
                });

                if (files[0] === file)
                {
                    btnPrivate.innerHTML = "無料公開";
                    btnPrivate.style.borderColor = '#9ac5ea';
                    btnPrivate.style.color = '#9ac5ea';
                    inputPrivate.value = '0';
                }
                else
                {
                    btnPrivate.innerText = '有料公開';
                    btnPrivate.style.borderColor = '#dfa4ad';
                    btnPrivate.style.color = '#dfa4ad';
                    inputPrivate.value = '1';
                }

                //21.03.15 김태영, 가이드 + 추가
                dropzone.files.length > 0
                    ? dropzone.element.appendChild(this.$refs.more)
                    : dropzone.element.removeChild(this.$refs.more)

                file.previewElement.querySelector('.dz-remove').innerHTML = '&#128465';

                //21.07.16 김태영, drag and drop 제거
                // //21.03.18 김태영, 파일 지우기, 공개여부 선택에 마우스 위로 올라올 경우 drop n drag 기능 제거
                // var divRemove = file.previewElement.querySelector('.dz-remove');
                // divRemove.addEventListener('mouseover', function (e) {
                //     e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                //     e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지
                //
                //     $('#dropzone').sortable('destroy');
                // });
                //
                // btnPrivate.addEventListener('mouseover', function (e) {
                //     e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                //     e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지
                //
                //     $('#dropzone').sortable('destroy');
                // });
                // var divPreview = file.previewElement.querySelector('.dz-details');
                // divPreview.addEventListener('mouseover', function (e) {
                //     e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                //     e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지
                //
                //     $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});
                //     divRemove.style.opacity = 0;
                // });
                // divPreview.addEventListener('mouseout', function (e) {
                //     e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                //     e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지
                //
                //     divRemove.style.opacity = 1;
                // });

                if (file.type.split('/')[0] == 'video') {
                    // var container = document.getElementById("contentWrap");
                    var video = document.createElement('video');
                    // video.className='video-js vjs-default-skin"'
                    var source = document.createElement('source');
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');

                    const reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = function(event) {
                        var w, h, ratio;
                        // video.src = event.target.result;
                        source.src = event.target.result;
                        source.type ='video/mp4';
                        video.appendChild(source);
                        // container.appendChild(video);
                        // container.appendChild(canvas);
                        video.currentTime = 0;
                        video.play();
                        // video.pause();

                        // video.ondurationchange = function() {
                        //     alert(video.duration);
                        // };

                        video.onloadeddata = (event) => {
                            // Calculate the ratio of the video's width to height
                            ratio = video.videoWidth / video.videoHeight;
                            // Define the required width as 100 pixels smaller than the actual video's width
                            w = video.videoWidth - 100;
                            // Calculate the height based on the video's width and the ratio
                            h = parseInt(w / ratio, 10);
                            // Set the canvas width and height to the values just calculated
                            canvas.width = w;
                            canvas.height = h;

                            // Define the size of the rectangle that will be filled (basically the entire element)
                            context.fillRect(0, 0, w, h);
                            // Grab the image from the video
                            context.drawImage(video, 0, 0, w, h);

                            video.pause();

                            //convert to desired file format
                            var dataURI = canvas.toDataURL('image/jpeg');

                            file.previewElement.querySelector(".dz-image img").src = dataURI;

                            if (video.duration > 10) {
                                varthis.$fire({
                                    text: "10秒以上の動画の為、10秒にカットして投稿します。",
                                    type: "error",
                                    timer: 3000
                                }).then(r => {
                                    console.log(r.value);
                                });
                            }
                        };
                    };
                }

                dropzone.hiddenFileInput.removeAttribute("multiple");
            }
            //투고편집
            else {
                var unique_field_id = new Date().getTime();
                var btnPrivate = document.createElement("div");
                btnPrivate.id = "btn" + unique_field_id;
                btnPrivate.className = "btnPrivate"
                //file.previewElement.querySelector(".dz-details").appendChild(btnPrivate);
                file.previewElement.appendChild(btnPrivate);

                var inputPrivate = document.createElement("input");
                inputPrivate.id = "private" + unique_field_id;
                inputPrivate.className = 'inPrivate';
                inputPrivate.name = "private";
                inputPrivate.type = 'hidden';
                file.previewElement.appendChild(inputPrivate);

                //tweet_image_id
                var inputTweet_image_id = document.createElement("input");
                inputTweet_image_id.id = "Tweet_image_id" + unique_field_id;
                inputTweet_image_id.className = 'inTweet_image_id';
                inputTweet_image_id.name = "tweet_image_id";
                inputTweet_image_id.type = 'hidden';
                file.previewElement.appendChild(inputTweet_image_id);
                inputTweet_image_id.value = file.tweet_image_id;

                btnPrivate.addEventListener('click', function (e) {
                    e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                    e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지

                    if(btnPrivate.innerText.toLowerCase() === '無料公開') {
                        btnPrivate.innerText = '有料公開';
                        btnPrivate.style.borderColor = '#dfa4ad';
                        btnPrivate.style.color = '#dfa4ad';
                        inputPrivate.value = '1';
                    }
                    else {
                        btnPrivate.innerText = '無料公開';
                        btnPrivate.style.borderColor = '#9cc5eb';
                        btnPrivate.style.color = '#9cc5eb';
                        inputPrivate.value = '0';
                    }
                });

                if (file.private === 0)
                {
                    btnPrivate.innerHTML = "無料公開";
                    btnPrivate.style.borderColor = '#9ac5ea';
                    btnPrivate.style.color = '#9ac5ea';
                    inputPrivate.value = '0';
                }
                else
                {
                    btnPrivate.innerText = '有料公開';
                    btnPrivate.style.borderColor = '#dfa4ad';
                    btnPrivate.style.color = '#dfa4ad';
                    inputPrivate.value = '1';
                }
            }

            if (file.type.split('/')[0] === 'image') {
                file.previewElement.querySelector(".dz-size").remove();
                file.previewElement.querySelector(".dz-filename").remove();
            }
        },
        removedEvent(file, error, xhr) {
            //21.03.15 김태영, 가이드 + 추가
            let dropzone = this.$refs.myVueDropzone.dropzone
            dropzone.files.length > 0
                ? dropzone.element.appendChild(this.$refs.more)
                : dropzone.element.removeChild(this.$refs.more)

            if (dropzone.files.length === 0) {
                dropzone.element.appendChild(this.$refs.more)
                this.disableUploadButton = true;
            }
        },
        processQueue(visible) {
            $('body, html').animate({ scrollTop: 0 }, 500);
            //21.03.20 김태영, visible 1 투고 저장, visible 0 임시저장(비공개)
            this.visible = visible;

            //신규투고
            if (this.editMode === 0) {
                var files = this.$refs.myVueDropzone.dropzone.files;

                //21.03.22 김태영, tweets table 파일 총 개수
                this.file_cnt = files.length;

                var _i, _len, chk = 0;
                for (_i = 0, _len = files.length; _i < _len; _i++) {
                    if (files[_i].previewElement.querySelector(".inPrivate").value === '0') {
                        chk++;
                        //break;
                    }
                }
                if (chk === 0) {
                    this.$fire({
                        //title: "Title",
                        text: "無料公開を1つ選択してください。",
                        type: "error",
                        timer: 3000
                    }).then(r => {
                        console.log(r.value);
                    });
                    return;
                }

                //21.07.17 김태영, drag & drop 기능 제거로 인해 정렬 필요 없음
                // files.sort(function (a, b) {
                //     return ($(a.previewElement).index() > $(b.previewElement).index()) ? 1 : -1;
                // })

                // 전체공개 이미지 check 반복문에 file remove 버튼 제거 로직이 있었으나 check 통과 후로 변경
                for (_i = 0, _len = files.length; _i < _len; _i++) {
                    files[_i].previewElement.querySelector(".dz-remove").remove();

                    //21.03.22 김태영, video 포함 여부 체크
                    var filetype = files[_i].type.split('/');
                    if (filetype[0] === 'video') {
                        this.include_video++;
                    }
                    //21.03.22 김태영, 전체공개 대표 이미지 찾기
                    if (files[_i].previewElement.querySelector(".inPrivate").value === '0') {
                        if (this.main_img === "") {
                            this.main_img = files[_i].name;
                            this.main_img_mime_type = files[_i].type;
                            this.main_img_idx = _i;
                        }
                    }
                }

                this.disableUploadButton = true;
                this.$refs.myVueDropzone.processQueue();
            }
            //투고 편집
            else {
                var files = this.$refs.myVueDropzone.dropzone.files;

                var _i, _len, chk = 0;
                for (_i = 0, _len = files.length; _i < _len; _i++) {
                    // if (files[_i].value === '0') {
                    if (files[_i].previewElement.querySelector(".inPrivate").value === '0') {
                        chk++;
                        //break;
                    }
                }

                if (chk === 0) {
                    this.$fire({
                        text: "無料公開を1つ選択してください。",
                        type: "error",
                        timer: 3000
                    }).then(r => {
                        console.log(r.value);
                    });
                    return;
                }

                for (_i = 0, _len = files.length; _i < _len; _i++) {
                    //21.03.22 김태영, 전체공개 대표 이미지 찾기
                    if (files[_i].previewElement.querySelector(".inPrivate").value === '0') {
                        if (this.main_img === "") {
                            this.main_img = files[_i].name;
                            this.main_img_mime_type = files[_i].type;
                            this.main_img_idx = _i;
                        }
                    }
                }

                this.disableUploadButton = true;
                this.$refs.myVueDropzone.processQueue();
            }
        },
        successEvent(file, response) {
            var url = '/creator/index';
            setTimeout(function() {
                window.location.href = url;
            }, 3000);
        },
        thumbnailEvent(file, dataUrl) {
            if (this.editMode === 0) {
                let myDropzone = this.$refs.myVueDropzone.dropzone

                // ignore files which were already cropped and re-rendered
                // to prevent infinite loop
                if (file.cropped) {
                    return;
                }

                var unixtime = new Date().getTime();

                // cache filename to re-assign it to cropped file
                var cachedFilename = unixtime + '_' + file.name.substring(0, file.name.lastIndexOf(".")) + '.jpeg';
                // remove not cropped file from dropzone (we will replace it later)
                myDropzone.removeFile(file);

                // dynamically create modals to allow multiple files processing
                var $cropperModal = $(modalTemplate);
                // 'Crop and Upload' button in a modal
                var $uploadCrop = $cropperModal.find('.crop-upload');
                var $cancelCrop = $cropperModal.find('.crop-cancel');

                $('.image-container img').remove();

                var $img = $('<img />');
                // initialize FileReader which reads uploaded file
                var reader = new FileReader();
                reader.onloadend = function () {
                    // add uploaded and read image to modal
                    $cropperModal.find('.image-container').html($img);
                    $img.attr('src', reader.result);

                    // $(".modal").on("shown.bs.modal", function() {
                    // initialize cropper for uploaded image
                    croping = new Cropper($('.image-container img')[0], {
                        aspectRatio: 1
                        // aspectRatio: 16 / 9,
                        , autoCropArea: 1
                        , movable: true
                        ,viewMode : 1
                        , cropBoxResizable: true,
                        minCropBoxHeight: 300,
                        minCropBoxWidth: 300
                        // ,minContainerWidth: 850
                    });
                    // })
                };

                // read uploaded file (triggers code above)
                reader.readAsDataURL(file);

                $cropperModal.modal('show');

                // listener for 'Crop and Upload' button in modal
                $uploadCrop.on('click', function () {
                    // get cropped image data
                    //var blob = $img.cropper('getCroppedCanvas').toDataURL();
                    var blob = croping.getCroppedCanvas().toDataURL(file.type, 0.9);
                    // transform it to Blob object
                    var newFile;
                    resizeImage({
                        file: dataURItoBlob(blob),
                        maxSize: 640//480
                    }).then(function (resizedImage) {
                        reader.onload = function (e) {
                            newFile = resizedImage;
                            // set 'cropped to true' (so that we don't get to that listener again)
                            newFile.cropped = true;
                            // assign original filename
                            newFile.name = cachedFilename;

                            // add cropped file to dropzone
                            myDropzone.addFile(newFile);
                            // upload cropped file with dropzone
                            $cropperModal.modal('hide');
                        };
                        reader.readAsDataURL(file);
                    });
                });
                $cancelCrop.on('click', function () {
                    $cropperModal.modal('hide');
                });
            }
        },
        dragEvent(event) {
            this.$fire({
                text: "追加ボタンを押してください。",
                type: "error",
                timer: 3000
            }).then(r => {
                console.log(r.value);
            });
            return;
        }
    }
}
</script>

<style>
.infoTxt{
    padding: 30px 0;
    color: #aaaaaa;
    font-size: 12px;
}
#dropzone {
    padding: 0;
    border: none;
    background-color: #fff;
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.dropzone .dz-clickable,
.dropzone .dz-preview{
   margin: 0 0 70px;
}
.dropzone .dz-preview{
    width: 49%;
    padding-top: 49%;
    background-color: #fff;
    position: relative;
}
.dropzone .dz-preview .dz-image{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 0 !important;
}
.dropzone .dz-preview img {
    width: 100%;
    filter: none !important;
    position: absolute;
}
.vue-dropzone>.dz-preview .dz-image img:not([src]){
    display: none;
}
.dropzone .dz-preview .btnPrivate {
    cursor: pointer;
    position: absolute;
    z-index: 0;
    border: 2px #9ac5ea solid;
    color:#9ac5ea;
    left: 0;
    bottom: -44px;
    background-color: #ffffff;
    border-radius: 20px;
    font-size: 14px;
    height: 34px;
    line-height: 34px;
    width: 80%;
    width: calc(100% - 40px);
    text-align: center;
}
.dropzone .dz-preview .dz-remove {
    display: block;
    cursor: pointer;
    opacity: 1 !important;
    font-size: 0;
    position: absolute;
    z-index: 0;
    bottom: -40px;
    right: 0;
    top: auto;
    border: none;
    width: 28px;
    height: 28px;
    background: url('/storage/icon/icon_delete.png') no-repeat center/cover;
}
.more {
    width: 100%;
    padding-top: 100%;
    cursor: pointer;
    position: relative;
}
.more div{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    padding-top: 100%;
    background-color: #f3f3f3;
}
.more div:before{
    content: "+";
    color: lightgray;
    font-size: 60px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}
.dz-preview + .more{
    width: 49%;
    padding-top: 49%;
}
.msg {
    width: 100%;
}
.msgTextarea {
    width: 100%;
    border-color: #e7e7e7;
    height: 140px;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 16px;
    font-family: '小塚ゴシック Pro','Kozuka Gothic Pro',メイリオ,Meiryo,sans-serif;
    font-weight: 400;
    font-style: normal;
}
.btnDropUp {
    width: 100%;
    margin-bottom: 10px;
}
.btnUpload {
    width: 100%;
    line-height: 60px;
}
.btnUpload:disabled {
    opacity: 0.6;
}
.btnInvisible {
    width: 100%;
    line-height: 60px;
}
.dropzone .dz-preview .dz-progress {
    opacity: 0;
}
.vue-dropzone>.dz-preview .dz-details {
    background-color: transparent;
    opacity: 0;
    color: black;
}
.vue-dropzone>.dz-file-preview .dz-details:before{
    content: "";
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    transform: translate(-50%,-50%);
    background: url('/storage/icon/icon_video.png') no-repeat center/cover;
}
.dropzone .dz-preview .dz-details .dz-size,
.dropzone .dz-preview .dz-details .dz-filename{
    display: none;
}
.dropzone .dz-preview:hover{
    z-index: 0;
}
.dropzone .dz-preview:hover .dz-image img{
    transform: none !important;
}
.dropzone > div:nth-of-type(n+8){
    display: none;
}
/*modal*/
.modal .modalInner{
    height: 100%;
    width: 100%;
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.modal .modalInner ul{
    margin-top: 15px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    position: absolute;
    bottom: 5%;
    left: 5%;
    width: 90%;
    z-index: 1;
}
.modal .modalInner li{
    width: 49%;
}
.modal .modalInner button {
    -webkit-box-sizing: content-box;
    -webkit-appearance: button;
    appearance: button;
    box-sizing: border-box;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    padding: 0;
    border: none;
    border-radius: 10px;
    padding: 12px 0;
}
.crop-upload{
    background-color: #b15a68;
    color: #fff;
}
.crop-cancel{
    background-color: #ededed;
    color: #b15a68;
}
.modal .cropper-modal{
    opacity: 0.8;
}
</style>
