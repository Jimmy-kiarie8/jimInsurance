
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import Print from 'vue-print-nb'

import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css'

import printer from "vue-printer";
import JsonExcel from 'vue-json-excel'
// import test from "vue-test";
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(Vuex)
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(Print); 
Vue.component('downloadExcel', JsonExcel)

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

let dashboard = require('./components/Dashboard.vue');

let myHeader = require('./components/include/Header.vue');
let myUser = require('./components/users/User.vue');
let myBranch = require('./components/branches/Branch.vue');
let mysubsicriber = require('./components/emails/Subscribe.vue');
let myProfile = require('./components/users/Profile.vue');
let myRoles = require('./components/users/roles/Roles.vue');
let myPolicy = require('./components/Policy/Policy.vue');
let myCertificate = require('./components/certificate/Certificate.vue');
let myReports = require('./components/reports/Reports.vue');
let myCompany = require('./components/company/Company.vue');
let myClient = require('./components/clients/Client.vue');

const routes = [
    {path: '/', component: dashboard },
    {path: '/users', component: myUser },
    {path: '/branches', component: myBranch },
    {path: '/profile', component: myProfile },
    {path: '/subscribers', component: mysubsicriber },
    {path: '/policy', component: myPolicy },
    {path: '/certificates', component: myCertificate },
    {path: '/reports', component: myReports },
    {path: '/company', component: myCompany },
    {path: '/clients', component: myClient },
]


const router = new VueRouter({
    // mode: 'history',
        routes // short for `routes: routes`
    })

const app = new Vue({
    el: '#app',
    components: {
        myHeader, myUser, mysubsicriber, myProfile, dashboard, myBranch, myPolicy, myCertificate, printer,
        myReports, myCompany, myClient
    },
    router,
});
