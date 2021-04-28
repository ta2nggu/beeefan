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

import * as draganddrop from '../draganddrop.js'

export default {
    name: 'Dropzone',
    props: {
        currentUser: {
            type: Number,
            required: true
        }
    },
    components: {
        vueDropzone: vue2Dropzone
    },
    data() {
        return {
            msg:"",
            visible:1,
            main_img:"",
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
                parallelUploads: 5,
                dictDefaultMessage: '',
                clickable: '.more'
            },
        }
    },
    mounted () {
        //mounted - vue js 처음 실행될 때
        this.$el.removeChild(this.$refs.more)
        let dropzone = this.$refs.myVueDropzone.dropzone
        dropzone.element.appendChild(this.$refs.more)


        //재정렬 drag and drop 사용
        $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});
        // $(document).ready(function() {
        //     //div list
        //     // $('#dropzone').sortable({container: '#dropzone', nodes: ':not(#dropzone, .more)'});
        //     $('#dropzone').sortable({container: '#dropzone', nodes: '.dz-preview'});
        // });
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
            //21.03.25 김태영, 전체공개 대표 이미지 index 추가
            formData.append('main_img_idx', this.main_img_idx);

            //var str = file.previewElement.querySelector("#private" + file.name.toString()).value;
            var str = file.previewElement.querySelector("input[name='private'");
            this.imgPrivate.push($(str).val());
            formData.append('private', this.imgPrivate);
        },
        addedEvent (file) {
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
                // alert('전체공개 이미지를 하나 이상 선택해주세요');
                this.$fire({
                    //title: "Title",
                    text: "전체공개 이미지를 하나 이상 선택해주세요",
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
            files.sort(function(a, b){
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
                        this.main_img_idx = _i;
                    }
                }
            }

            this.disableUploadButton = true;
            this.$refs.myVueDropzone.processQueue();
        },
        successEvent(file, response) {
            setTimeout(function() {
                window.location.href = '/creator/index';
            }, 3000);
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

.dropzone .dz-preview{
    width: 49%;
    height: auto;
    padding-bottom: 60px;
    margin: 0 0 50px;
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
    bottom: 10px;
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
    cursor: pointer;
    opacity: 1;
    font-size: 0;
    position: absolute;
    bottom: 10px;
    right: 0;
    border: none;
    width: 20%;
    height: 36px;
}
.dropzone .dz-preview .dz-remove:before{
    content: "";
    display: block;
    width: 70%;
    height: 100%;
    background: url('/storage/icon/icon_delete.png') no-repeat center/contain #fff;
    position: absolute;
    top: 0;
    left: 15%;
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
    margin-top: 50px;
    width: 100%;
}
.msgTextarea {
    width: 100%;
    border-color: #e7e7e7;
    height: 140px;
    padding: 20px 5%;
    border-radius: 5px;
    margin-bottom: 20px;
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
    background-color: #Ddabb4;
    opacity: 0;
}

</style>
