import Vue from 'vue';
import Base from './base';
import axios from 'axios';
import Routes from './routes';
import VueRouter from 'vue-router';
import VueJsonPretty from 'vue-json-pretty';
import Autocomplete from '@trevoreyre/autocomplete-vue'
import '@trevoreyre/autocomplete-vue/dist/style.css'

window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

let token = document.head.querySelector('meta[name="csrf-token"]');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.use(VueRouter);
Vue.use(Autocomplete);

Vue.prototype.$http = axios.create();

window.Horizon.basePath = '/' + window.Horizon.path;

let routerBasePath = window.Horizon.basePath + '/';

if (window.Horizon.path === '' || window.Horizon.path === '/') {
    routerBasePath = '/';
    window.Horizon.basePath = '';
}

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: routerBasePath,
});

Vue.component('vue-json-pretty', VueJsonPretty);
Vue.component('alert', require('./components/Alert.vue').default);

const app = Vue.component('app', require('./components/App.vue').default);
const root = document.getElementById('horizon');

Vue.mixin(Base);

Vue.directive('tooltip', function (el, binding) {
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover',
    });
});

new Vue({
    el: root,
    render: (createElement) =>
        createElement(app, {
            props: {
                appName: root.dataset.appName,
                assetsAreCurrent: root.dataset.assetsAreCurrent,
                isDownForMaintenance: root.dataset.isDownForMaintenance,
            },
        }),
    router
});
