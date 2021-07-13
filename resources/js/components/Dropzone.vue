<template>
<div>
<!--    <textarea v-model="msg" placeholder="メッセージを入力してください"></textarea>-->
    <p class="infoTxt">投稿後に画像の変更・並び替えはできません。</p>
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
                // url: 'api/DropUp',
                //21.03.21 김태영, url 앞에 '/' 없으면 web.php 을 바라보게 됨
                url: 'api/DropUp',
                thumbnailWidth: 320,
                thumbnailHeight: 320,
                headers: { "My-Awesome-Header": "header value" },
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 10,
                parallelUploads: 10,
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

        //재정렬 drag and drop 사용
        $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});
        // $(document).ready(function() {
        //     //div list
        //     // $('#dropzone').sortable({container: '#dropzone', nodes: ':not(#dropzone, .more)'});
        //     $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});
        // });

        //21.05.01 김태영, 편집하기
        if (typeof this.tweet_images != "undefined") {
            this.editMode = 1;

            $('#dropzone').sortable('destroy');

            this.disableUploadButton = false;

            this.tweet_id = this.tweet_images[0].tweet_id;

            this.msg = this.tweet_images[0].msg;

            var _i, _len;
            for (_i = 0, _len = this.tweet_images.length; _i < _len; _i++) {
                //var lastModified = Date.now();
                //var mockFile = { name: this.tweet_images[_i].name, private : this.tweet_images[_i].private, status: "queued", size: 0, type:this.tweet_images[_i].mime_type, upload: {chunked: false}, lastModified :lastModified, lastModifiedDate:new Date(lastModified) }
                //var mockFile = new File({ name: this.tweet_images[_i].name, private : this.tweet_images[_i].private, status: "queued", size: 0, type:this.tweet_images[_i].mime_type, upload: {chunked: false}});

                // dropzone.options.addedfile.call(dropzone, mockFile);
                // dropzone.options.thumbnail.call(dropzone, mockFile, this.tweet_images[_i].path);
                // dropzone.options.complete.call(dropzone, mockFile);

                // dropzone.emit("addedfile", mockFile);
                // dropzone.emit("thumbnail", mockFile, this.tweet_images[_i].path);
                // dropzone.emit("complete", mockFile);
                // dropzone.files.push(mockFile);
                //console.log(dropzone);

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
                var FileURL=this.tweet_images[_i].path;//"test/test.jpg"
                GetFileObjectFromURL(FileURL, function (fileObject) {
                    // console.log(fileObject);
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

            //var str = file.previewElement.querySelector("#private" + file.name.toString()).value;
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
                this.disableUploadButton = false;

                //21.03.03 김태영, 중복된 파일 제거
                var files = this.$refs.myVueDropzone.dropzone.files;
                if (files) {
                    var _i, _len;
                    for (_i = 0, _len = files.length; _i < _len - 1; _i++) // -1 to exclude current file
                    {
                        if(files[_i].name === file.name
                            && files[_i].size === file.size
                            && files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString())
                        {
                            this.$refs.myVueDropzone.dropzone.removeFile(file);
                        }
                    }
                }

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

                // this.$refs.myVueDropzone.dropzone.default_configuration.emit("thumbnail", file, "http://path/to/image");

                //21.03.15 김태영, 가이드 + 추가
                let dropzone = this.$refs.myVueDropzone.dropzone
                dropzone.files.length > 0
                    ? dropzone.element.appendChild(this.$refs.more)
                    : dropzone.element.removeChild(this.$refs.more)

                file.previewElement.querySelector('.dz-remove').innerHTML = '&#128465';

                //21.03.18 김태영, 파일 지우기, 공개여부 선택에 마우스 위로 올라올 경우 drop n drag 기능 제거
                var divRemove = file.previewElement.querySelector('.dz-remove');
                divRemove.addEventListener('mouseover', function (e) {
                    e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                    e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지

                    $('#dropzone').sortable('destroy');
                });

                //21.03.19 김태영, 모바일 touchstart 테스트
                // function handleStart(evt) {
                //     console.log('a');
                // }

                // divRemove.addEventListener("touchstart", handleStart, {passive: true});
                // var clickEvent = (function() {
                //     if ('ontouchstart' in document.documentElement === true) {
                //         console.log('bbb');
                //         return 'touchstart';
                //     } else {
                //         console.log('ccc');
                //         return 'click';
                //     }
                // })();
                //
                // divRemove.addEventListener(clickEvent,function(){
                //     console.log('aaa');
                // });
                btnPrivate.addEventListener('mouseover', function (e) {
                    e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                    e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지

                    $('#dropzone').sortable('destroy');
                });
                var divPreview = file.previewElement.querySelector('.dz-details');
                divPreview.addEventListener('mouseover', function (e) {
                    e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                    e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지

                    $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});
                    divRemove.style.opacity = 0;
                });
                divPreview.addEventListener('mouseout', function (e) {
                    e.preventDefault(); // click이벤트 외의 이벤트 막기위해
                    e.stopPropagation(); // 부모태그로의 이벤트 전파를 중지

                    divRemove.style.opacity = 1;
                });

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
            // var files = this.$refs.myVueDropzone.dropzone.files;
            // console.log(files);
            // var myDiv = files[0].previewElement.querySelector(".btnPrivate");
            // files[0].previewElement.removeChild(myDiv);

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
                // if (chk != 1) {
                    // alert('전체공개 이미지를 하나 이상 선택해주세요');
                    this.$fire({
                        //title: "Title",
                        // text: "전체공개 이미지를 하나 이상 선택해주세요",
                        text: "無料公開を1つ選択してください。",
                        type: "error",
                        timer: 3000
                    }).then(r => {
                        console.log(r.value);
                    });
                    return;
                }

                //21.03.19 김태영, drag n drop 후 전송 전 재정렬
                // var filesReorder = this.$refs.myVueDropzone.dropzone.getQueuedFiles();
                // Sort theme based on the DOM element index
                files.sort(function (a, b) {
                    return ($(a.previewElement).index() > $(b.previewElement).index()) ? 1 : -1;
                })
                //21.03.21 김태영, removeAllFiles, addFile 기능 필요 없음
                // // Clear the dropzone queue
                // this.$refs.myVueDropzone.dropzone.removeAllFiles();
                // // Add the reordered files to the queue
                // // this.$refs.myVueDropzone.dropzone.handleFiles(files);
                // var i = 0;
                // for(i; i < files.length; i++){
                //     this.$refs.myVueDropzone.dropzone.addFile(files[i]);
                // }

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
                // var files = dropzone.querySelectorAll(".inPrivate");
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
                // if (chk != 1) {
                    // alert('전체공개 이미지를 하나 이상 선택해주세요');
                    this.$fire({
                        //title: "Title",
                        // text: "전체공개 이미지를 하나 이상 선택해주세요",
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
                // console.log(this.$refs.myVueDropzone.dropzone.files);
                // console.log(this.$refs.myVueDropzone.files);
                //this.$refs.myVueDropzone.dropzone.processQueue();
                this.$refs.myVueDropzone.processQueue();
            }
        },
        successEvent(file, response) {
            var url = this.editMode === 0 ? '/creator/index' : '/creator/invisible';

            setTimeout(function() {
                window.location.href = url;
            }, 3000);
        },
        thumbnailEvent(file, dataUrl) {
            let myDropzone = this.$refs.myVueDropzone.dropzone

            // ignore files which were already cropped and re-rendered
            // to prevent infinite loop
            if (file.cropped) {
                return;
            }

            var unixtime = new Date().getTime();

            // cache filename to re-assign it to cropped file
            var cachedFilename = unixtime + '_' + file.name;//unixtime 추가
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
                // croping = new Cropper($('.image-container img').get(0), {
                croping = new Cropper($('.image-container img')[0], {
                        aspectRatio: 1
                        // aspectRatio: 16 / 9,
                        ,autoCropArea: 1
                        ,movable: true
                        ,cropBoxResizable: true
                        // ,minContainerWidth: 850
                    });
                // })
            };

            // read uploaded file (triggers code above)
            reader.readAsDataURL(file);

            $cropperModal.modal('show');

            // listener for 'Crop and Upload' button in modal
            $uploadCrop.on('click', function() {
                // get cropped image data
                //var blob = $img.cropper('getCroppedCanvas').toDataURL();
                var blob = croping.getCroppedCanvas().toDataURL(file.type, 0.9);
                // transform it to Blob object
                // var newFile = dataURItoBlob(blob);
                var newFile;
                resizeImage({
                    file: dataURItoBlob(blob),
                    maxSize: 480
                }).then(function (resizedImage) {
                    reader.onload = function(e){
                        newFile = resizedImage;
                        // set 'cropped to true' (so that we don't get to that listener again)
                        newFile.cropped = true;
                        // assign original filename
                        newFile.name = cachedFilename;

                        // add cropped file to dropzone
                        myDropzone.addFile(newFile);
                        // upload cropped file with dropzone
                        // myDropzone.processQueue();
                        $cropperModal.modal('hide');
                    };
                    reader.readAsDataURL(file);
                });
                // // set 'cropped to true' (so that we don't get to that listener again)
                // newFile.cropped = true;
                // // assign original filename
                // newFile.name = cachedFilename;
                //
                // // add cropped file to dropzone
                // myDropzone.addFile(newFile);
                // // upload cropped file with dropzone
                // // myDropzone.processQueue();
                // $cropperModal.modal('hide');
            });
            $cancelCrop.on('click', function() {
                $cropperModal.modal('hide');
            });
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
   margin: 0 0 80px;
}
.dropzone .dz-preview{
    width: 49%;
    height: auto;
    background-color: #fff;
}
.dropzone .dz-preview img {
    width: 100%;
}
.dropzone .dz-preview .btnPrivate {
    cursor: pointer;
    z-index: 30;
    position: absolute;
    border: 2px #9ac5ea solid;
    color:#9ac5ea;
    left: 0;
    bottom: -50px;
    background-color: #ffffff;
    border-radius: 20px;
    font-size: 14px;
    height: 34px;
    line-height: 34px;
    max-width: 200px;
    width: 80%;
    text-align: center;
}
.dropzone .dz-preview .dz-remove {
    display: block;
    cursor: pointer;
    opacity: 1;
    font-size: 0;
    position: absolute;
    bottom: -50px;
    right: 0;
    border: none;
    width: 20%;
    height: 36px;
    background: url('/storage/icon/icon_delete.png') no-repeat center/70% #fff;
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
    margin-top: 30px;
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
/*modal*/
.modal .modalInner{
    height: 100vh;
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
</style>
