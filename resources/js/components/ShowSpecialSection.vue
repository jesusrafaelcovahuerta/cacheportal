<template>
    <div class="container pt-32">
        <qrcode-stream @decode="onDecode"></qrcode-stream>

        <!-- toolbar bottom -->
        <div class="toolbar">
            <div class="container">
                <ul class="toolbar-bottom toolbar-wrap">
                    <li class="toolbar-item pt-10">
                        <button class="toolbar-link" @click="goBack">
                            <i class="icon ion-ios-arrow-back"></i> Regresar
                        </button>
                    </li>
                    <li class="toolbar-item">
                        <button class="toolbar-link" @click="goHome">
                            <i class="icon ion-ios-home"></i> Inicio
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
	
</template>
<script>
    import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'

    export default {
        created() {

        },
        methods: {
            Track(google_tag) {
                this.$gtag.event('page_view', {
                    page_title: google_tag
                });
            },
            onDecode (decodedString) {
                alert(decodedString);
            }
        },
        components: {
            QrcodeStream,
            QrcodeDropZone,
            QrcodeCapture,
            BeforeInstallPromptEvent 
        },
        data: function() {
            return {
                posts: [],
                post: '',
                polls: [],
                poll_question_posts: [],
                poll_quantity: 0,
                check_category_poll: '',
                form: {
                    yes_no_answer: [],
                    text_answer: []
                },
            }
        }
    }
</script>
<style scoped>
.boton2 {
  font-size: 25px !important;
}
</style>