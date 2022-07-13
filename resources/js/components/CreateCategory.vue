<template>
    <div>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">
                Crear Categoría
            </h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0 font-weight-bold text-primary">Información</h6>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="m-0 text-danger float-right">* Campos Obligatorios</h6>
                        </div>
                    </div>
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
                                        <label for="exampleInputEmail1">Nombre <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="text" 
                                        v-model="form.name" 
                                        maxlength="36"
                                        class="form-control"
                                        placeholder="Ingresa el nombre"
                                        >
                                        <span class="col-sm-12">{{charactersLeft}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">Google Tag <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="text" 
                                        v-model="form.google_tag" 
                                        class="form-control"
                                        placeholder="Ingresa el google tag"
                                        >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="exampleInputEmail1">Alianza <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.alliance_id"
                                        >
                                            <option :value="null">-Seleccionar-</option>
                                            <option v-for="alliance_post in alliance_posts" :key="alliance_post.rut" :value="alliance_post.rut">{{ alliance_post.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="exampleInputEmail1">Sección <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.section_id"
                                        >
                                            <option :value="null">-Seleccionar-</option>
                                            <option v-for="section_post in section_posts" :key="section_post.section_id" :value="section_post.section_id">{{ section_post.section_title }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="exampleInputEmail1">Color <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <v-input-colorpicker v-model="color" @change="handleChange" />
                                            </div>
                                            <div class="col-sm-10">
                                                <input
                                                type="text" 
                                                v-model="form.color" 
                                                class="form-control"
                                                placeholder="Ingresa el color"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="exampleInputEmail1">Posición <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <input
                                        type="number" 
                                        v-model="form.position" 
                                        class="form-control"
                                        placeholder="Ingresa la posición"
                                        >
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="exampleInputEmail1">Tipo de Icono <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.icon_type_id"
                                        >
                                            <option :value="null">Seleccionar</option>
                                            <option :value="1">Personalizado</option>
                                            <option :value="2">Fa Icon</option>
                                            <option :value="3">Ionic Icon</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6" v-if="form.icon_type_id == 1">
                                        <label for="exampleInputEmail1">Icono</label>
                                        <input ref="file" accept="image/png" type="file" class="form-control" v-on:change="onFileChange">
                                    </div>
                                    <div class="col-sm-6" v-if="form.icon_type_id == 2">
                                        <label for="exampleInputEmail1">Fa Icon - <a href="https://fontawesome.com/icons" target= "_blank">Ver iconos</a></label>
                                        <input
                                            type="text" 
                                            v-model="form.fai" 
                                            class="form-control"
                                            placeholder="Ingresa el icono"
                                        >
                                    </div>
                                    <div class="col-sm-6" v-if="form.icon_type_id == 3">
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
                                    <div class="col-sm-6">
                                        <label for="exampleInputEmail1">¿Es destacada la categoría? <h6 class="m-0 text-danger float-right">*</h6></label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                        v-model="form.highlight_id"
                                        >
                                            <option :value="0">No</option>
                                            <option :value="1">Si</option>
                                        </select>
                                    </div>
                                </div>
                                <button 
                                type="submit"
                                class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Guardar</span>
                                </button>
                                <router-link to="/category" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-times"></i>
                                    </span>
                                    <span class="text">Cancelar</span>
                                </router-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import { ClipLoader } from 'vue-spinner/dist/vue-spinner.min.js';
    import InputColorPicker from 'vue-native-color-picker';

    export default {
        components: {
            ClipLoader,
            "v-input-colorpicker": InputColorPicker
        },
        created() {
            this.getAlliaceList();
            this.getSectionList();
            this.getRol();
            this.storeAudit();
        },
        data: function() {
            return {
                errors: [],
                color: "#0f4c81",
                loading: false,
                alliance_posts: [],
                section_posts: [],
                noFile: false,
                noFile_icon_imagen: false,
                form: {
                    alliance_id: null,
                    section_id: null,
                    name: '',
                    color: '',
                    position: '',
                    icon_type_id: null,
                    google_tag: '',
                    fai: '',
                    highlight_id: 0
                }
            }
        },
        methods: {
            storeAudit() {
                let formData = new FormData();
                formData.append('page', 'CreateCategory');
               
                axios.post('/api/audit/store?api_token='+App.apiToken, formData)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            handleChange() {
                this.form.color = this.color;
            },
            onFileChange(e){
                this.file = e.target.files[0];
                this.noFile = e.target.files.length;
            },
            onIconChange(e){
                this.icon_image = e.target.files[0];
                this.noFile_icon_imagen = e.target.files.length;
            },
            getAlliaceList() {
                axios.get('/api/alliance/list?api_token='+App.apiToken)
                .then(response => {
                    this.alliance_posts = response.data.data;
                });
            },
            getSectionList() {
                axios.get('/api/section/list?api_token='+App.apiToken)
                .then(response => {
                    this.section_posts = response.data.data;
                });
            },
            onSubmit(e) {
                this.loading = true; //the loading begin
                e.preventDefault();
                let currentObj = this;
    
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                if (typeof this.icon_image !== 'undefined') {
                    var icon_image_size = this.icon_image.size;
                } else {
                    var icon_image_size = 0;
                }

                if(this.form.alliance_id != null
                    && this.form.section_id != null
                    && this.form.name != ''
                    && this.form.google_tag != ''
                    && this.form.name.length <= 28
                    && this.form.color != ''
                    && this.form.position != ''
                    && (this.icon_image != null || this.form.fai != '')
                    && (icon_image_size <= 1024 * 1024)
                ) {
                    let formData = new FormData();
                    formData.append('alliance_id', this.form.alliance_id);
                    formData.append('section_id', this.form.section_id);
                    formData.append('name', this.form.name);
                    formData.append('color', this.form.color);
                    formData.append('position', this.form.position);
                    formData.append('file', this.file);
                    formData.append('icon_type_id', this.form.icon_type_id);
                    if(this.form.icon_type_id == 1) {
                        formData.append('icon_image', this.icon_image);
                    } else {
                        formData.append('icon', this.form.fai);
                    }
                    formData.append('highlight_id', this.form.highlight_id);
                    formData.append('google_tag', this.form.google_tag);

                    axios.post('/api/category/store?api_token='+App.apiToken, formData, config)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.loading = false;
                        this.$awn.success("El registro ha sido agregado", {labels: {success: "Éxito"}});
                        this.$router.push('/category');
                    });
                } else {
                    this.loading = false;
                    this.errors = [];
                    
                    if (this.form.alliance_id == null) {
                        this.errors.push('La alianza es obligatoria.');
                    }
                    if (this.form.section_id == null) {
                        this.errors.push('La sección es obligatoria.');
                    }
                    if (this.form.name == '') {
                        this.errors.push('El nombre es obligatorio.');
                    }
                    if (this.form.google_tag == '') {
                        this.errors.push('La etiqueta de Google es obligatoria.');
                    }
                    if (this.form.name.length > 28) {
                        this.errors.push('El nombre debe tener menos de 28 caracteres.');
                    }
                    if (this.form.color == '') {
                        this.errors.push('El color es obligatorio.');
                    }
                    if (this.form.position == '') {
                        this.errors.push('La posición es obligatoria.');
                    }
                   if (this.form.icon_type_id == null) {
                        this.errors.push('El tipo de icono es obligatorio.');
                    }
                    if (this.form.icon_type_id == 1 && this.icon_image == null) {
                        this.errors.push('El icono es obligatorio.');
                    }
                    if (this.form.icon_type_id == 2 && this.form.fai == '') {
                        this.errors.push('El icono es obligatorio.');
                    } 
                    if (this.form.icon_type_id == 1 && (icon_image_size > 1024 * 1024)) {
                        this.errors.push('La imagen del icono es muy pesada.');
                    }

                    $('html,body').scrollTop(0);

                    e.preventDefault();
                }
            },
            getRol() {
                axios.get('/api/user?api_token='+App.apiToken)
                .then(response => {
                    this.rol_id = response.data.data.rol_id;
                });
            }
        },
        computed: {
            isDisabled() {
                return true;
            },
            charactersLeft() {
                var char = this.form.name.length,
                    limit = 36;

                return (limit - char) + " / " + limit + " caracteres disponibles";
            }
        }
    }
</script>
<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>
