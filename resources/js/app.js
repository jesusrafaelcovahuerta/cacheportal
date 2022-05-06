require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import routes from './routes';
import VueAWN from "vue-awesome-notifications"
import VueMask from 'v-mask';
import vueVimeoPlayer from 'vue-vimeo-player';

Vue.component(
    'menu-component',
    require('./components/Menu.vue').default
);

Vue.use(vueVimeoPlayer)
Vue.use(VueAWN);
Vue.use(VueRouter);
Vue.use(VueMask);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
