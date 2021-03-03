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
        },
        addedEvent () {
            this.disableUploadButton = false;
        },
        processQueue() {
            this.disableUploadButton = true;
            this.$refs.myVueDropzone.processQueue();
        }
    }
}
</script>

<style>

</style>
