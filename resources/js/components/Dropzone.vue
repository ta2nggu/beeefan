<template>
<div>
<!--    <textarea v-model="msg" placeholder="メッセージを入力してください"></textarea>-->
    <textarea v-model="msg" placeholder="メッセージを入力してください"></textarea>
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
    <button class="btn btn-success" v-on:click="processQueue" :disabled="disableUploadButton">투고하기</button>
</div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

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
            disableUploadButton: true,
            imgPrivate: [],
            dropzoneOptions: {
                url: 'api/DropUp',
                thumbnailWidth: 200,
                thumbnailHeight: 200,
                headers: { "My-Awesome-Header": "header value" },
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 5,
                parallelUploads: 5
            },
        }
    },
    methods: {
        sendingEvent (file, xhr, formData) {
            formData.append('id', this.currentUser);
            formData.append('msg', this.msg);

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

                if(btnPrivate.innerText.toLowerCase() === '全体公開') {
                    btnPrivate.innerText = '会員公開';
                    btnPrivate.style.backgroundColor = '#000000';
                    inputPrivate.value = '1';
                }
                else {
                    btnPrivate.innerText = '全体公開';
                    btnPrivate.style.backgroundColor = '#FF0000';
                    inputPrivate.value = '0';
                }
            });

            if (files[0] === file)
            {
                btnPrivate.innerHTML = "全体公開";
                btnPrivate.style.backgroundColor = '#FF0000';
                inputPrivate.value = '0';
            }
            else
            {
                btnPrivate.innerText = '会員公開';
                inputPrivate.value = '1';
            }
        },
        removedEvent(file, error, xhr) {
            // var files = this.$refs.myVueDropzone.dropzone.files;
            // console.log(files);
            // var myDiv = files[0].previewElement.querySelector(".btnPrivate");
            // files[0].previewElement.removeChild(myDiv);
        },
        processQueue() {
            var files = this.$refs.myVueDropzone.dropzone.files;

            var _i, _len, chk = 0;
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                if (files[_i].previewElement.querySelector(".inPrivate").value === '0') {
                    chk++;
                    //break;
                }
                files[_i].previewElement.querySelector(".dz-remove").remove();
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

            this.disableUploadButton = true;
            this.$refs.myVueDropzone.processQueue();
        },
        successEvent(file, response) {
            setTimeout(function() {
                window.location.href = '/creator';
            }, 3000);
        }
    }
}
</script>

<style>
.dropzone .dz-preview .btnPrivate {
    cursor: pointer;
    z-index: 30;
    position: absolute;
    border: 2px #fff solid;
    color:#fff;
    margin-left: 135px;
    bottom: 165px;
    background-color: #000000;
}
</style>
