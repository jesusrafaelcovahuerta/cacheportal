<template>
    <div>
        <PhotoCapture v-model="imageBase64" />
        <VideoCapture uploadUrl="<example-server-address.com>" v-model="videoUrl" />
    </div>
</template>

<script>
import 'vue-media-recorder/src/assets/scss/main.scss'
import {PhotoCapture, VideoCapture} from 'vue-media-recorder'

export default {
    data(){
        return {
            imageBase64: null,
            videoUrl: null,
        }
    },
    components:{
        PhotoCapture,
        VideoCapture
    }
}
</script>