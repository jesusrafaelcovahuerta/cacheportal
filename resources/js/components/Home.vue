<template>
    <div class="container pt-32">
        <form action="https://www.google.com/search" class="searchform" method="get" name="searchform" target="_blank">
            <input autocomplete="on" class="form-control search" style="color: #000 !important;" name="q" placeholder="" required="required"  type="text">
            <button class="button" type="submit" style="background-color: blueviolet !important; color: #fff !important;">Buscar</button>
        </form>
        <div class="row">
            <hr>
            <h2><center><strong>Haz click en los botones para ver cada contenido</strong></center></h2>
        </div>
        <div class="bar">
            <input class="searchbar" type="text" title="Search">
            <a href="#"> <img class="voice" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Google_mic.svg/716px-Google_mic.svg.png" title="Search by Voice"></a>
        </div>
        <div class="row">
		    <div class="col-6" v-for="(post, index) in posts" v-bind:index="index">
                <router-link @click.native="Track(post.google_tag)" v-if="post.link_question_id == 2" class="boton2" :style="{ background: post.color}" :to="`/section/show/${post.section_id}`" >
                    <font class="section_title">{{ post.section_title }}</font><br><i v-bind:class="post.icon"></i>
                </router-link>
                <button v-if="post.link_question_id == 1" class="boton2" :style="{ background: post.color}" v-on:click="goWeb(post.url,post.google_tag)" >
                    <font class="section_title">{{ post.section_title }}</font><br> <i v-bind:class="post.icon"></i>
                </button>
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
            Track(google_tag) {
                this.$gtag.event('page_view', {
                    page_title: google_tag
                });
            },
            hideModal() {
                this.modalShow = false;
            },
            goWeb(url, google_tag) {
                this.$gtag.event('page_view', {
                    page_title: google_tag
                });

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
<style scoped>
.alert-secondary {
  color: #FFF !important;
  background-color: rgb(47, 47, 98);
  text-align: center !important;
  font-weight: bold;
}
.grid{
  height:23px;
  position:relative;
  bottom:4px;
}
.bar{
  margin:0 auto;
  width:575px;
  border-radius:30px;
  border:1px solid #dcdcdc;
}
.bar:hover{
  box-shadow: 1px 1px 8px 1px #dcdcdc;
}
.bar:focus-within{
  box-shadow: 1px 1px 8px 1px #dcdcdc;
  outline:none;
}
.searchbar{
  height:45px;
  border:none;
  width:500px;
  font-size:16px;
  outline: none;
  
}
</style>