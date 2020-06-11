/*
|--------------------------------------------------------------------------
| Init js library
|--------------------------------------------------------------------------
|
| First we will load all of this project's JavaScript dependencies which
| includes Vue and other libraries. It is a great starting point when
| building robust, powerful web applications using Vue and Laravel.
|
*/

require('./bootstrap');

import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import VueDataTables from 'vue-data-tables'
import Http from './utils/fetch';
import router from './router/index';
import store from './store/index';
import i18n from './lang/index';
import App from './App';
import Distpicker from 'v-distpicker'
import VueQuillEditor from 'vue-quill-editor'
import HighchartsVue from 'highcharts-vue'

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(ElementUI);
Vue.use(VueDataTables)
Vue.use(Http);
Vue.use(VueQuillEditor, /* { default global options } */)
Vue.use(HighchartsVue)

Vue.component('v-distpicker', Distpicker)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
export const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    template: '<App/>',
    components: {App}
});

/* Set vue instance and vuex store as window variable, so we can ccess your i18n in your chrome */
//window['vue'] = app
//window.store = store
