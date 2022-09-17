/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
require('./ladygasy');

import '@vueup/vue-quill/dist/vue-quill.snow.prod.css';
import 'vue-select/dist/vue-select.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// 1. On importe createApp
import { createApp } from "vue";
import {createRouter, createWebHashHistory, RouteRecordRaw} from 'vue-router';

// 2. On importe AppComponent.vue
const CategoryComponent = require("./components/CategoryComponent.vue").default;
const AttributeComponent = require('./components/AttributeComponent.vue').default;
const ProductComponent = require('./components/ProductComponent.vue').default;

// 3. On monte l'application Vue sur l'élément #app
const ProductRoutes: Array<RouteRecordRaw> = [
  { path: '/', component: require('./components/ProductList.vue').default },
  { path: '/product/new', component: require('./components/ProductEditor.vue').default, name: 'new-product' },
  { path: '/product/:id', component: require('./components/ProductEditor.vue').default, name: 'edit-product' }
];
const ProductRouter = createRouter({
  history:createWebHashHistory(),
  routes: ProductRoutes
})

createApp(CategoryComponent).mount("#app-category")
createApp(AttributeComponent).mount("#app-attribute")
createApp(ProductComponent)
  .use(ProductRouter)
  .mount('#app-admin-product');
