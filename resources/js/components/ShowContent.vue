<template>
    <div class="container pt-32">
        <div class="row">
		    <div class="col-12" v-if="this.post.type_id == 1 || this.post.type_id == 2">
                <h1>{{ this.post.title }}</h1>
                <hr>
                <div v-if="url !== null">
                    <center>
                        <img v-bind:src="image_url">
                        <br>
                        <audio controls autoplay>
                            <source :src="url" type="audio/mpeg">
                        </audio>
                    </center>
                </div>
                <div v-if="videoID !== null">
                    <vimeo-player
                        class="vimeo"
                        ref="player"
                        :options="{ responsive: true, autoplay: true }"
                        :video-id="videoID"
                        @ready="onReady"
                        :autoplay="true"
                        :player-height="320"
                        :player-width="640"
                    ></vimeo-player>
                </div>
                <hr>	
                <h2>{{ this.post.description }}</h2>	    
            </div>
            <div class="col-12" v-if="this.post.type_id == 3" v-html="this.post.description">	    
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
            this.getPost();
            this.catchUser();
        },
        methods: {
            onReady() {
                this.playerReady = true
            },
            play () {
                this.$refs.player.play()
            },
            pause () {
                this.$refs.player.pause()
            },
            catchUser() {
                let formData = new FormData();
                formData.append('page', 'content_id_'+this.$route.params.id);
               
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
            getPost() {
                this.loading = true;

                axios.get('/api/content/detail/'+ this.$route.params.id)
                .then(response => {
                    this.post = response.data.data;
                    this.url = this.post.src;
                    this.image_url = '/storage/'+this.post.image;
                    this.videoID = this.post.video_id;
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
                videoID: null,
                height: 500,
                post: '',
                url: null,
                options: {
                    muted: true,
                    autoplay: true,
			    },
			    playerReady: false
            }
        }
    }
</script>