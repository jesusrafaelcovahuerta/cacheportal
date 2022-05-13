<template>
    <div>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">
                Editar Contenido
            </h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div v-if="loading">
                            <center>
                                <clip-loader :color="color"></clip-loader>
                            </center>
                        </div>
                        <div v-else>
                            <form @submit.prevent="onSubmit" ref="createBill" enctype="multipart/form-data">
                                <div v-if="errors.length" class="alert alert-danger" role="alert">
                                    <b>Por favor, corrija los siguientes errores:</b>
                                    <ul>
                                        <li v-for="error in errors">{{ error }}</li>
                                    </ul>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Categoría <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.category_id"
                                        >
                                            <option :value="null">-Seleccionar-</option>
                                            <option v-for="category_post in category_posts" :key="category_post.category_id" :value="category_post.category_id">{{ category_post.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Tipo de Contenido <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.type_id"
                                        >
                                            <option :value="null">-Seleccionar-</option>
                                            <option :value="1">Video</option>
                                            <option :value="2">Audio</option>
                                            <option :value="3">Texto</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Título <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="text" 
                                        v-model="form.title" 
                                        class="form-control"
                                        placeholder="Ingresa el título"
                                        >
                                        <span class="col-sm-12">{{charactersLeft}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <div v-if="form.type_id == 1">
                                            <label for="exampleInputEmail1">ID del Video Vimeo <h6 class="m-0 text-danger float-right">*</h6></label>
                                            <input
                                            type="text" 
                                            v-model="form.video_id" 
                                            class="form-control"
                                            placeholder="Ingresa el ID"
                                            >
                                        </div>
                                        <div v-if="form.type_id == 2">
                                            <label for="exampleInputEmail1">Src</label>
                                            <input
                                            type="text" 
                                            v-model="form.src" 
                                            class="form-control"
                                            placeholder="Ingresa el src del audio"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Google Tag <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="text" 
                                        v-model="form.google_tags" 
                                        class="form-control"
                                        placeholder="Ingresa el nombre"
                                        >
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="exampleInputEmail1">Fecha de Inicio <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="date" 
                                        v-model="form.start_date" 
                                        class="form-control"
                                        placeholder="Ingresa la fecha de inicio"
                                        >
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="exampleInputEmail1">Fecha de Termino <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="date" 
                                        v-model="form.end_date" 
                                        class="form-control"
                                        placeholder="Ingresa la fecha de termino"
                                        >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Tipo de Icono <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.icon_type_id"
                                        >
                                            <option :value="2">Ionic Icon</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Ionic Icon - <a href="https://ionicframework.com/docs/v3/ionicons/" target= "_blank">Ver iconos</a></label>
                                        <input
                                            type="text" 
                                            v-model="form.fai" 
                                            class="form-control"
                                            placeholder="Ingresa el icono"
                                        >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8" v-if="form.type_id == 1 || form.type_id == 2">
                                        <label for="exampleInputEmail1">Descripción <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="text" 
                                        v-model="form.description" 
                                        class="form-control"
                                        placeholder="Ingresa el texto"
                                        >
                                    </div>
                                    <div class="col-sm-8" v-if="form.type_id == 3">
                                        <vue-editor v-model="form.description"></vue-editor>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="exampleInputEmail1">Posición <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="number" 
                                        v-model="form.position" 
                                        class="form-control"
                                        placeholder="Ingresa la posición"
                                        >
                                    </div>
                                </div>

                                <button v-if="post.status == 1"
                                type="submit"
                                class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Actualizar</span>
                                </button>
                                <router-link v-if="post.status == 1" to="/content" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-times"></i>
                                    </span>
                                    <span class="text">Cancelar</span>
                                </router-link>
                            </form>
                            <button v-if="post.status == 2" v-on:click="acceptPost"
                            type="submit"
                            class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Aceptar</span>
                            </button>
                            <router-link v-if="post.status == 2" to="/content" class="btn btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="text">Regresar</span>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import { ClipLoader } from 'vue-spinner/dist/vue-spinner.min.js';
    import { VueEditor } from "vue2-editor";
    export default {
        components: {
            ClipLoader,
            VueEditor
        },
        created() {
            this.getCategoryList();
            this.getPost();
            this.storeAudit();
        },
        data: function() {
            return {
                errors: [],
                color: '#0A2787',
                loading: false,
                category_posts: [],
                form: {
                    category_id: null,
                    type_id: null,
                    title: '',
                    icon_type_id: 2,
                    video_id: '',
                    google_tags: '',
                    icon: '',
                    fai: '',
                    image: '',
                    description: '',
                    start_date: '',
                    end_date: '',
                    status: '',
                }
            }
        },
        methods: {
            acceptPost() {
                if(confirm("¿Realmente usted quiere aceptar el contenido?")) {
                    this.loading = true; //the loading begin
                    axios.get('/api/content/accept/'+this.$route.params.id+'?api_token='+App.apiToken).then(response => {
                        
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.loading = false;
                        this.getPosts();
                        this.$awn.success("El registro ha sido aceptado", {labels: {success: "Éxito"}});
                        this.$router.push('/content');
                    });

                    let formData = new FormData();
                    formData.append('page', 'AcceptContent - '+this.$route.params.id);
                
                    axios.post('/api/audit/store?api_token='+App.apiToken, formData)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.loading = false;
                        this.$awn.success("El registro ha sido aceptado", {labels: {success: "Éxito"}});
                        this.$router.push('/content');
                    });
                }
            },
            storeAudit() {
                let formData = new FormData();
                formData.append('page', 'EditContent - Content Id: '+this.$route.params.id);
               
                axios.post('/api/audit/store?api_token='+App.apiToken, formData)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getPost() {
                axios.get('/api/content/'+ this.$route.params.id +'/edit?api_token='+App.apiToken)
                .then(response => {
                    this.post = response.data.data;
                    
                    this.$set(this.form, 'category_id', this.post.category_id);
                    this.$set(this.form, 'type_id', this.post.type_id);
                    this.$set(this.form, 'video_id', this.post.video_id);
                    this.$set(this.form, 'title', this.post.title);
                    this.$set(this.form, 'google_tags', this.post.google_tags);
                    var icon = this.post.icon;
                    var icon_detail = icon.split(' ');
                    var icon_detail = icon_detail[1];
                    var icon_detail = icon_detail.split('-');
                    var icon = 'ios-'+icon_detail[2];
                    this.$set(this.form, 'fai', icon);
                    this.$set(this.form, 'description', this.post.description);
                    this.$set(this.form, 'start_date', this.post.start_date);
                    this.$set(this.form, 'end_date', this.post.end_date);
                    this.$set(this.form, 'position', this.post.position);
                    this.$set(this.form, 'status', this.post.status);
                });
            },
            getCategoryList() {
                axios.get('/api/category/list?api_token='+App.apiToken)
                .then(response => {
                    this.category_posts = response.data.data;
                });
            },
            onSubmit(e) {
                this.loading = true; //the loading begin
                e.preventDefault();
                let currentObj = this;
    
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                if(this.form.category_id != null
                    && this.form.type_id != null
                    && this.form.title != ''
                    && this.form.google_tags != ''
                    && this.form.fai != ''
                    && this.form.description != ''
                    && this.form.start_date != ''
                    && this.form.position != ''
                ) {
                    let formData = new FormData();
                    formData.append('category_id', this.form.category_id);
                    formData.append('type_id', this.form.type_id);
                    formData.append('video_id', this.form.video_id);
                    formData.append('title', this.form.title);
                    formData.append('google_tags', this.form.google_tags);
                    formData.append('icon', this.form.icon);
                    formData.append('fai', this.form.fai);
                    formData.append('description', this.form.description);
                    formData.append('start_date', this.form.start_date);
                    formData.append('end_date', this.form.end_date);
                    formData.append('position', this.form.position);

                    axios.post('/api/content/update/'+this.$route.params.id+'?api_token='+App.apiToken, formData, config)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.loading = false;
                        this.$awn.success("El registro ha sido agregado", {labels: {success: "Éxito"}});
                        this.$router.push('/content');
                    });
                } else {
                    this.loading = false;
                    this.errors = [];
                    
                    if (this.form.branch_office_id == null) {
                        this.errors.push('La categoría es obligatoria.');
                    }

                    if (this.form.type_id == null) {
                        this.errors.push('El tipo de contenido es obligatorio.');
                    }

                    if (this.form.title == '') {
                        this.errors.push('El título es obligatorio.');
                    }

                    if (this.form.google_tags == '') {
                        this.errors.push('Los tags son obligatorios.');
                    }

                    if (this.form.description == '') {
                        this.errors.push('La descripción es obligatoria.');
                    }

                    if (this.form.start_date == '') {
                        this.errors.push('La fecha inicial es obligatoria.');
                    }

                    if (this.form.position == '') {
                        this.errors.push('La posición es obligatoria.');
                    }

                    $('html,body').scrollTop(0);

                    e.preventDefault();
                }
            },

        },
        computed: {
            isDisabled() {
                return true;
            },
            charactersLeft() {
                var char = this.form.title,
                    limit = 15;

                return (limit - char) + " / " + limit + " caracteres disponibles";
            }
        }
    }
</script>
<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>
