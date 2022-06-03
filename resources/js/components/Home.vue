<template>
    <div class="container pt-32">
        <div class="row">
		    <div class="col-6" v-for="(post, index) in posts" v-bind:index="index">
                <router-link v-if="post.link_question_id == 2" class="router_boton2" :style="{ background: post.color}" :to="`/section/show/${post.section_id}`" >
                    <br>{{ post.section_title }}<br> <i v-bind:class="post.icon"></i><br> 
                </router-link>
                <button v-if="post.link_question_id == 1" class="boton2" :style="{ background: post.color}" v-on:click="goWeb(post.url)" >
                    {{ post.section_title }}<br> <i v-bind:class="post.icon"></i>
                </button>
		    </div>
        </div>
        <b-modal id="modal-center" v-model="modalShow" centered title="Bienvenidos al nuevo portal">
            <p class="my-4 h3 text-justify">
                Este es el nuevo portal de la Fundación Conecta Mayor.<br><br>
                Estaremos haciendo algunos cambios para facilitarle nuevo contenido de aprendizaje y entretención.<br><br>
                Esperamos ser un aporte en tu uso del internet.<br><br>
                <strong>Haz click en el botón verde de "Cerrar" para ver el portal.</strong>
            </p>
            <template #modal-footer="{ ok }">
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button size="lg" variant="success" @click="ok()">
                Cerrar
                </b-button>
            </template>
        </b-modal>
    </div>
</template>
<script>
    export default {
        created() {
            this.getPosts();
            this.catchUser();
            this.checkDate();
            this.modalShow();
        },
        methods: {
            modalShow() {
                this.modalShow = true;

                axios.post('/api/modal/catch')
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            hideModal() {
                this.modalShow = false;
            },
            goWeb(url) {
                window.location.href = url;
            },
            checkDate() {
                let formData = new FormData();
                formData.append('page', 'Home');
               
                axios.post('/api/content/date', formData)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                        console.log(error);
                });
            },
            catchUser() {
                let formData = new FormData();
                formData.append('page', 'Home');
               
                axios.post('/api/user/catch', formData)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                        console.log(error);
                });
            },
            getPosts() {
                this.loading = true;

                axios.get('/api/section/home')
                .then(response => {
                    this.posts = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        },
        data: function() {
            return {
                modalShow: '',
                posts: []
            }
        }
    }
</script>