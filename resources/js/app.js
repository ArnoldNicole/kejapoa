  
require('./bootstrap');

window.Vue = require('vue')
import Vue2Editor from "vue2-editor";
import router from './router'
import common from './common'
import ViewUi from 'view-design'
import 'view-design/dist/styles/iview.css';
import locale from 'view-design/dist/locale/en-US';
import Echo from 'laravel-echo'
//Vue.use(ViewUI, );
Vue.use(ViewUi, { locale });
Vue.use(Vue2Editor);
Vue.mixin(common)
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    //authEndpoint: '/channels/authorize',
    forceTLS:true, //process.env.PUSHER_TLS_MODE,
});
Vue.component('main-app', require('./components/main-app.vue').default)
Vue.component('registration-form', require('./components/pages/registerLandlord').default)
Vue.component('house-search', require('./components/pages/houseSearch').default)
Vue.component('chat-area', require('./components/pages/chat.vue').default);
// Vue.component('quill-component', require('./components/pages/QuillComponent.vue').default);
const app = new Vue({
    el: '#app', 
    router,
    
   
})