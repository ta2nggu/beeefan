import Vue from 'vue'
import axios from 'axios'
import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import VueRouter from 'vue-router'
import VueSimpleAlert from "vue-simple-alert"

Vue.use(Datetime)
Vue.use(VueRouter)
Vue.use(VueSimpleAlert)

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('form-upload', require('./components/FormUpload.vue').default);//21.02.25 김태영, 테스트 업로드 주석
// Vue.component('form-write', require('./components/FormWrite.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#image-form-wrapper',
// })

// const datetime = new Vue({
//     el: '#birth_date',
// })

const routes = [
    { path: '/register', component: Datetime.default },
    // { path: '/creator_write', component: require('./components/FormWrite.vue').default }
    //Creator 투고 page에서 사용하는 file drag & drop
    { path: '/creator/write', component: require('./components/Dropzone.vue').default }
    //21.03.25 김태영, TimelineSlider.vue 제거
    // //Timeline image slider
    // //path 동적으로 매칭할 땐 앞에 : 을 표기, ex):creator
    // { path: '/:creator/timeline/:start', component: require('./components/TimelineSlider.vue').default }

    //21.05.01 김태영, 투고 편집
    , { path: '/creator/edit/:tweet_id', component: require('./components/Dropzone.vue').default }
]

const router = new VueRouter({
    routes: routes,
    mode: "history"
    // base: 'creator'//prefix같은 개념
})

const app = new Vue({
    router
}).$mount('#app')
