/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import '../css/app.css';
import '../css/app.scss';
import 'bootstrap';
import Vue from 'vue';
import App from './views/App.vue';
import Stats from './views/Stats.vue';
import axios from 'axios';
import store from './store';

Vue.prototype.$axios = axios;


new Vue({
    el: "#app",
    store,
    render: h => h(App)
})
new Vue({
    el: "#stats",
    store,
    render: h => h(Stats)
})

require ('./table.js');
require ('./activity.js');
require ('./autocomplete.js');


