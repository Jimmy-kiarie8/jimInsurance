
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue()
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import Print from 'vue-print-nb'

import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// import printer from "vue-printer";
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
Vue.use(ElementUI);

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// import dashboard from'./components/Dashboard.vue';
import myHeader from'./components/include/Header.vue';
import myUser from'./components/master/users/User.vue';
import myFooter from'./components/include/Footer';
import mysubsicriber from'./components/emails/Subscribe.vue';
import myProfile from'./components/users/Profile.vue';
import myRoles from'./components/users/roles/Roles.vue';
import myPolicy from'./components/Policy/Policy.vue';
// import myCertificate from'./components/certificate/Certificate.vue';
import myReports from'./components/reports/Reports.vue';
import myCompany from'./components/company/Company.vue';
import myClient from'./components/clients/Client.vue';
import myClasses from'./components/master/insclass';
import myType from'./components/master/instype';
import myinsPolicy from'./components/master/policy/Policy.vue';
import myCoverage from'./components/master/coverage';
import mycompanyProfile from'./components/master/company/Company.vue';


const routes = [
    // {path: '/', component: dashboard },
    {path: '/users', component: myUser },
    {path: '/roles', component: myRoles },
    {path: '/profile', component: myProfile },
    // {path: '/subscribers', component: mysubsicriber },
    {path: '/', component: myPolicy },
    // {path: '/certificates', component: myCertificate },
    {path: '/reports', component: myReports },
    {path: '/company', component: myCompany },
    {path: '/clients', component: myClient },
    {path: '/classes', component: myClasses },
    {path: '/types', component: myType },
    {path: '/inspolicy', component: myinsPolicy },
    {path: '/coverage', component: myCoverage },
    {path: '/companyprofile', component: mycompanyProfile },

]


const router = new VueRouter({
    // mode: 'history',
        routes // short for `routes: routes`
    })

const app = new Vue({
    el: '#app',
    components: {
        myHeader, myUser, mysubsicriber, myProfile, myPolicy, 
        myReports, myCompany, myClient, myClasses, myType, myinsPolicy,
         myCoverage, myRoles, mycompanyProfile, myFooter,
    },
    router,
});
