import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import Vuex from 'vuex'
import vuexI18n from 'vuex-i18n'
import router from './routes'
import moment from 'moment'
import storeData from './store/store.js'
import vSelect from 'vue-select'
import FlashMessage from '@smartweb/vue-flash-message';
import common from './common'
// import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        'https://unpkg.com/kidlat-css/css/kidlat.css'
    ]
}

// Vue.use(VueHtmlToPaper);

Vue.use(FlashMessage);
Vue.mixin(common)
require('./bootstrap');

window.Vue = require('vue');
Vue.use(Vuex);


const store = new Vuex.Store(storeData);

Vue.use(vuexI18n.plugin, store);
const translationsDe = {
    "My nice title": "Ein schöner Titel",
    "content": "Dies ist ein toller Inhalt"
};


Vue.i18n.set(default_locale_lang);


window.Fire = new Vue();


import swal from 'sweetalert2'
window.swal = swal


import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})

Vue.use(Vuetify);
const opts = {}
export default new Vuetify(opts)

Vue.component('v-select', vSelect)
Vue.component('table_editable', require('./components/TableEditable.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    store,
    router,
    created() {
        this.$store.dispatch("loaddictionary");
    }
});