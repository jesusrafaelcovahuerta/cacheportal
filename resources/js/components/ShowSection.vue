<template>
    <div class="container pt-32">
        <div v-if="post.video_id != 0" class="row">
            <h1><center>{{ post.section_title }}</center></h1>
            <iframe width="560" height="315" :src="`https://www.youtube.com/embed/${post.video_id}?autoplay=1`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div v-if="check_category_poll == 0 && post.video_id == 0">
            <div v-if="poll_question_posts == ''" class="row">
                <div class="col-12" v-for="(post, index) in posts" v-bind:index="index">
                    <router-link @click="Track(post.google_tag)" v-if="post.highlight_id == 0"  class="boton2" :style="{ background: post.color}" :to="`/category/show/${post.category_id}`"> 
                        <i v-bind:class="post.icon"></i><br> {{ post.name }}
                    </router-link>

                    <router-link @click="Track(post.google_tag)" v-if="post.highlight_id == 1"  class="botonhighlight" :style="{ background: post.color}" :to="`/category/show/${post.category_id}`"> 
                        <i v-bind:class="post.icon"></i><br> {{ post.name }}
                    </router-link>
                </div>
            </div>
            <div class="row" v-if="poll_question_posts != ''">
                <div v-if="poll_quantity == 1">
                    <div class="col-12" v-for="(post, index) in poll_question_posts" v-bind:index="index">
                        <form @submit.prevent="onSubmit" ref="createCollection" enctype="multipart/form-data">
                            <h2>{{ post.question }}</h2>
                            <h4>Selecciona la respuesta marcando en el circulo</h4>
                            <hr>
                            <div class="form-group" v-if="post.answer_type_id == 1">
                                <label class="question_poll_yes_no" style="font-size: 20px;" for="yes">Si</label>   <input style="font-size: 30px !important;" type="radio" sty v-model="form.yes_no_answer[index]" id="yes_no_asnwer" value="Si" required>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
                                <label class="question_poll_yes_no" style="font-size: 20px;" for="no">No</label>    <input type="radio" v-model="form.yes_no_answer[index]" id="yes_no_asnwer" value="No" required>

                            </div>
                            <div class="form-group" v-if="post.answer_type_id == 2">
                                <input
                                        type="text" 
                                        v-model="form.text_answer[index]" 
                                        class="form-control"
                                        placeholder="Ingresa la respuesta"
                                        required
                                >
                            </div>

                            <button
                                    type="submit" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Guardar</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div v-if="poll_quantity > 1">
                    <div class="col-md-12" v-for="(post, index) in polls" v-bind:index="index">
                        <router-link  class="pollboton" :style="{ background: '#572364'}" :to="`/poll/show/${post.poll_id}`"> 
                            {{ post.title }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="check_category_poll != 0 && post.video_id == 0">
            <div class="row">
                <div class="col-12" v-for="(post, index) in posts" v-bind:index="index">
                    <router-link v-if="post.highlight_id == 0"  class="boton2" :style="{ background: post.color}" :to="`/category/show/${post.category_id}`"> 
                        <i v-bind:class="post.icon"></i><br> {{ post.name }}
                    </router-link>

                    <router-link v-if="post.highlight_id == 1"  class="botonhighlight" :style="{ background: post.color}" :to="`/category/show/${post.category_id}`"> 
                        <i v-bind:class="post.icon"></i><br> {{ post.name }}
                    </router-link>
                </div>
            </div>
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
    export default {
        created() {
            this.checkVideo();
            this.checkCategoryPoll();
            this.getPollQuestions();
            this.getPollQuantity();
            this.getPosts();
            this.getPolls();
            this.Track();
            this.checkDate();
        },
        methods: {
            Track() {
                axios.get('/api/section/'+ this.$route.params.id +'/edit?api_token='+App.apiToken)
                .then(response => {
                    this.post = response.data.data;
                });

                console.log(this.post.google_tag);
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
            onSubmit(e) {
                this.loading = true;
                e.preventDefault();
                let currentObj = this;
    
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
            
                formData.append('poll_id', this.$route.params.id);
                formData.append('yes_no_answers', this.form.yes_no_answer);
                formData.append('text_answers', this.form.text_answer);

                axios.post('/api/poll/answer', formData, config)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                    this.$awn.success("La encuesta han sido contestada", {labels: {success: "Éxito"}});
                    this.$router.push('/');
                });
            },
            getPollQuantity() {
                axios.get('/api/poll/quantity/'+ this.$route.params.id)
                .then(response => {
                    this.poll_quantity = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            checkCategoryPoll() {
                axios.get('/api/section/poll/'+ this.$route.params.id)
                .then(response => {
                    this.check_category_poll = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            getPolls() {
                axios.get('/api/poll/all/'+ this.$route.params.id)
                .then(response => {
                    this.polls = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            getPollQuestions() {
                axios.get('/api/poll/show/'+ this.$route.params.id)
                .then(response => {
                    this.poll_question_posts = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            catchUser() {
                let formData = new FormData();
                formData.append('page', 'section_id_'+this.$route.params.id);
               
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
            checkVideo() {
                this.loading = true;

                axios.get('/api/section/'+ this.$route.params.id+'/edit')
                .then(response => {
                    this.post = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            getPosts() {
                this.loading = true;

                axios.get('/api/category/show/'+ this.$route.params.id)
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