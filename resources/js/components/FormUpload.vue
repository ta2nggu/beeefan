<template>
    <form @submit.prevent="handleSubmit">
        <div class="form-group">
            <label>Image</label>
            <file-input :files="files" v-on:file-change="setFiles" @file-clear="clearFiles"></file-input>
        </div>
        <div class="form-group">
            <button class="btn btn-success" type="submit" :disabled="disableUploadButton">Upload</button>
        </div>
        <progress-bar :progress="progress" v-if="isUploading"></progress-bar>
    </form>
</template>

<script>
import FileInput from "./FileInput";
import ProgressBar from "./ProgressBar";

export default {
    methods: {
        clearFiles() {
            this.files = []
            this.disableUploadButton = true
        },
        handleSubmit() {
            this.isUploading = true
            this.disableUploadButton = true
            let formData = new FormData();
            for (let file of this.files) {
                formData.append('file_name[]', file, file.name)
            }

            formData.append('file_name[]', this.files)

            axios.post('/api/upload', formData, {
                onUploadProgress: e => {
                    if (e.lengthComputable) {
                        this.progress = (e.loaded / e.total) * 100
                        console.log(this.progress)
                    }
                }
            })
                 .then(res => {
                     console.log("upload completed")
                     setTimeout(() => {
                         this.isUploading = false
                         this.files = []
                     }, 1000)
                 })
                 .catch(err => {
                     console.log('upload failed')
                 })
        },
        setFiles(files) {
            if (files !== undefined) {
                this.files = files
                this.disableUploadButton = false
            }
        }
    },
    components: {
        ProgressBar,
        FileInput
    },
    data() {
        return {
            files: '',
            progress: 0,
            isUploading: false,
            disableUploadButton: true
        }
    }
}
</script>

<style lang="css">

</style>
