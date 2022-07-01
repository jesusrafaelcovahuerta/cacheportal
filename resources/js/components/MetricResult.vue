<template>
    <div>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">
                Resultado de Metricas
            </h1>
            <hr>
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                </div>
                <div class="card-body">
                    <GChart
                    type="PieChart"
                    :options="options"
                    :data="data"
                    /> 
                </div>
            </div>

        </div>
        
    </div>
    
</template>

<script>
    import vPagination from 'vue-plain-pagination';
    import { ClipLoader } from 'vue-spinner/dist/vue-spinner.min.js';
    import moment from 'moment'
    import { GChart } from 'vue-google-charts/legacy'

    export default {
        created() {
            this.getRol();
            this.getCityGraphic();
            this.storeAudit();
        },
        methods: {
            getCityGraphic() {
                axios.get('/api/metric/city?api_token='+App.apiToken)
                .then(response => {
                    this.data = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            storeAudit() {
                let formData = new FormData();
                formData.append('page', 'Audit');
               
                axios.post('/api/audit/store?api_token='+App.apiToken, formData)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getRol() {
                axios.get('/api/user?api_token='+App.apiToken)
                .then(response => {
                    this.rol_id = response.data.data.rol_id;
                });
            }
        },
        components: { 
            vPagination,
            ClipLoader,
            GChart
        },
        data: function() {
            return {
                color: '#0A2787',
                loading: false,
                form: {
                    rol_id: null
                },
                branch_office_posts: [],
                supervisor_posts: [],
                rol_id: this.rol_id,
                postsSelected: "",
                posts: [],
                data: [],
                options: {
                    width: 500,
                    height: 400
                },
                currentPage: 1,
                total: 0,
                rowsQuantity: ''
            }
        }
    }
</script>
