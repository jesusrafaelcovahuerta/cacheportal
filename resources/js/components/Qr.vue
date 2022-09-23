<template>
    <div>
        <vue-web-cam />
    </div>
</template>

<script>
import { WebCam } from "vue-web-cam";


export default {
    data(){
        return {
            imageBase64: null,
            videoUrl: null,
        }
    },
    components: {
        WebCam
    }
}
</script>