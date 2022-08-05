<template>
    <div class="container pt-32">

        <div class="row">
            <hr>
            <h2><center><strong>Haz click en los botones para ver cada contenido</strong></center></h2>
        </div>
        <form action="https://www.google.com/search" class="example">
            <input type="text" @blur="handleBlur" v-model="form.search" name="q" placeholder="Buscar en Google.com">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
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
            handleBlur(e) {
                this.$set(this.form, 'search', '');
            },
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
                posts: [],
                form: {
                    search: 'Buscar en Google.com'
                }
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
/* || PRIMARY MENU || */

* {
  box-sizing: border-box;
}

/* Style the search field */
form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #fff;
  color: #000 !important;
}

/* Style the submit button */
form.example button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none; /* Prevent double borders */
  cursor: pointer;
}

form.example button:hover {
  background: #0b7dda;
}

/* Clear floats */
form.example::after {
  content: "";
  clear: both;
  display: table;
}

::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    black;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    black;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    black;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    black;
}
::-ms-input-placeholder { /* Microsoft Edge */
   color:    black;
}
::placeholder { /* Most modern browsers support this now. */
   color:    black;
}
</style>