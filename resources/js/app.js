  
require('./bootstrap');
window.Vue = require('vue')
import Vue2Editor from "vue2-editor";
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
import router from './router'
import common from './common'
import ViewUi from 'view-design'
import 'view-design/dist/styles/iview.css';
import locale from 'view-design/dist/locale/en-US';
//Vue.use(ViewUI, );
Vue.use(ViewUi, { locale });
Vue.use(Vue2Editor);
Vue.mixin(common)
Vue.component('main-app', require('./components/main-app.vue').default)
// Vue.component('quill-component', require('./components/pages/QuillComponent.vue').default);
const app = new Vue({
    el: '#app', 
    router,
    
   
})