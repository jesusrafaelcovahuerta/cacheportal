<template>
    <div class="container pt-32">
        <div class="row">
		    <div class="col-6" v-for="(post, index) in posts" v-bind:index="index">
                <router-link class="boton2" :style="{ background: post.color}" :to="`/section/show/${post.section_id}`" >
                    <i v-bind:class="post.icon"></i><br> {{ post.section_title }}
                </router-link>
		    </div>
        </div>
    </div>
</template>
<script>
    export default {
        created() {
            this.getPosts();
            this.catchUser();
        },
        methods: {
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
                posts: []
            }
        }
    }
</script>