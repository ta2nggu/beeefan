<template>
    <div>
        <div class="input-group">
            <input type="text" :value="getFilesName()" readonly class="form-control" placeholder="Choose your images">
            <span class="input-group-btn">
                <button v-if="files.length" class="btn btn-default" type="button" @click="$emit('file-clear')">
                    remove
                </button>
                <button class="btn btn-default" type="button" @click="showFilePicker">
                    Open
                </button>
            </span>
        </div>
        <input type="file" ref="file" style="display:none;" @change="onChange" multiple>
    </div>
</template>

<script>
export default {
    props: ['files'],
    methods: {
        showFilePicker() {
            this.$refs.file.click();
        },
        onChange(event) {
            let files = event.target.files
            this.$emit('file-change', files)
        },
        getFilesName() {
            let filesName = []

            if (this.files.length > 0) {
                for (let file of this.files) {
                    filesName.push(file.name)
                }
            }

            return filesName.join(", ");
        }
    }
}
</script>

<style lang="css">

</style>
