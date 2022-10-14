<template>
    <div class="container pt-32">
        <div class="container pt-32" v-if="this.$route.params.id == 67">
            <h1><center>Si necesitas leer algún Qr puede utilizar esta sección para hacerlo, solo debe colocar la camara sobre el mismo</center></h1>
            <hr>
            <qrcode-stream @decode="onDecode"></qrcode-stream>

           
        </div>
        <div class="container pt-32" v-if="this.$route.params.id == 68">
            <h1><center>Noticias</center></h1>
            <hr>
            <div v-for="(post, index) in posts" v-bind:index="index">
                <h4>{{ post.title }} - <router-link :to="`/information/show/${post.datum_id}`">Ver Noticia Completa</router-link></h4>
                <hr>
            </div>

            <v-pagination v-model="currentPage" 
                            :page-count="total"
                            @input='getPosts'
                            :classes="bootstrapPaginationClasses"
                            :labels="paginationAnchorTexts"
                            ></v-pagination>
        </div>
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
            this.getPosts();
        },
        methods: {
            Track(google_tag) {
                this.$gtag.event('page_view', {
                    page_title: google_tag
                });
            },
            getPosts() {
                this.loading = true;

                axios.get('/api/information?page='+this.currentPage)
                .then(response => {
                    this.posts = response.data.data.data;
                    this.total = response.data.data.last_page;
                    this.currentPage = response.data.data.current_page;
                    this.rowsQuantity = response.data.data.total;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            onDecode (decodedString) {
                window.open(
                    decodedString,
                    '_blank'
                );
            },
            goHome() {
                this.$router.push('/')
            },
            goBack() {
                this.$router.go(-1)
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