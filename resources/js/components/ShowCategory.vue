<template>
    <div class="container pt-32">
        <div class="row">
		    <div class="col-12" v-for="(post, index) in posts" v-bind:index="index">
                <router-link class="boton2" :style="{ background: '#0e385d'}" :to="`/content/show/${post.content_id}`"> 
                    <i v-bind:class="post.icon"></i><br> {{ post.title }}
                </router-link>
		    </div>
        </div>
        <!-- toolbar bottom -->
        <div class="toolbar">
            <div class="container">
                <ul class="toolbar-bottom toolbar-wrap">
                    <li class="toolbar-item pt-20">
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
    export default {
        created() {
            this.getPosts();
            this.catchUser();
            this.checkDate();
        },
        methods: {
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
                formData.append('page', 'category_id_'+this.$route.params.id);
               
                axios.post('/api/user/catch', formData)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            goHome() {
                this.$router.push('/')
            },
            goBack() {
                this.$router.go(-1)
            },
            getPosts() {
                this.loading = true;

                axios.get('/api/content/show/'+ this.$route.params.id)
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
                posts: []
            }
        }
    }
</script>