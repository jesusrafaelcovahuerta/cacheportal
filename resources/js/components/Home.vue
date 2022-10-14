<template>
    <div class="container pt-32">

        <div class="row">
            <hr>
            <h1><center><strong>Haz click en los botones para ver cada contenido</strong></center></h1>
        </div>
        <div class="row">
		    <div class="col-6" v-for="(post, index) in posts" v-bind:index="index">
                <div v-if="post.special_section_id == 1">
                    <div v-if="post.section_id == 46">
                        <button v-if="post.link_question_id == 1" class="boton2" :style="{ background: post.color}" v-on:click="goWeb('http://api.whatsapp.com/send/?phone=56934136117&text=Hola&type=phone_number&app_absent=0',post.google_tag)" >
                            <font class="section_title">Consulta tu saldo</font><br> <i v-bind:class="post.icon"></i>
                        </button>
                    </div>
                    <div v-if="post.section_id == 67">
                        <router-link @click.native="Track(post.google_tag)" class="boton2" :style="{ background: post.color}" :to="`/special_section/show/67`" >
                            <font class="section_title">Leer Qr</font><br><i v-bind:class="'fa-solid fa-qrcode'"></i>
                        </router-link>
                    </div>
                    <div v-if="post.section_id == 68">
                        <router-link @click.native="Track(post.google_tag)" class="boton2" :style="{ background: post.color}" :to="`/special_section/show/68`" >
                            <font class="section_title">Noticias</font><br><i v-bind:class="'fa-solid fa-newspaper'"></i>
                        </router-link>
                    </div>
                </div>
                <div v-else>
                    <div v-if="post.link_question_id == 2">
                        <router-link @click.native="Track(post.google_tag)" v-if="post.direct_content_question_id == 2 || post.direct_content_question_id == null" class="boton2" :style="{ background: post.color}" :to="`/section/show/${post.section_id}`" >
                            <font class="section_title">{{ post.section_title }}</font><br><i v-bind:class="post.icon"></i>
                        </router-link>
                        <router-link @click.native="Track(post.google_tag)" v-if="post.direct_content_question_id == 1" class="boton2" :style="{ background: post.color}" :to="`/section/content/show/${post.section_id}`" >
                            <font class="section_title">{{ post.section_title }}</font><br><i v-bind:class="post.icon"></i>
                        </router-link>
                        
                    </div>
                    <div v-else>
                        <button v-if="post.link_question_id == 1" class="boton2" :style="{ background: post.color}" v-on:click="goWeb(post.url,post.google_tag)" >
                            <font class="section_title">{{ post.section_title }}</font><br> <i v-bind:class="post.icon"></i>
                        </button>
                    </div>
                </div>
		    </div>
        </div>
        <b-modal ref="my-modal" hide-footer title="Nueva Noticia">
            <div class="d-block text-center">
                <img style="width: 100%;" :src="'/../frontend/images/mesa.jpg'" alt="">
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        created() {
            this.getPosts();
            this.catchUser();
            this.checkDate();
        },
        mounted() {
            this.showModal();
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
            showModal() {
                /*
                var currentDate = new Date();
                console.log(currentDate);
    
                var formatted_date = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                console.log(formatted_date);

                this.input = formatted_date;

                formatted_date = formatted_date.split("/")
                
                if(localStorage.getItem('storeDate') != null) {
                    app.input = localStorage.getItem('storeDate');

                    const date = app.input.split("/");

                    console.log(date[2])
             
                    if(date[2] != formatted_date[2]) {
                        this.$refs['my-modal'].show()
                    }
                    
                    this.$refs['my-modal'].show()
                    localStorage.setItem('storeDate', this.input)
                } else {

                
                    if(date[2] != formatted_date[2]) {
                        this.$refs['my-modal'].show()
                    }
                   
                    this.$refs['my-modal'].show()
                    localStorage.setItem('storeDate', formatted_date)
                }
                 */
            },
            hideModal() {
                this.$refs['my-modal'].hide()
            },
            toggleModal() {
                // We pass the ID of the button that we want to return focus to
                // when the modal has hidden
                this.$refs['my-modal'].toggle('#toggle-btn')
            },
            handleBlur(e) {
                this.$set(this.form, 'search', '');

                this.$gtag.event('page_view', {
                    page_title: 'Buscador de Google en Home'
                });
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