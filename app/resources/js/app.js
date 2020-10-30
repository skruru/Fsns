/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { has } = require('lodash');

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

'use strict';

{
    document.addEventListener('DOMContentLoaded', function () {
        ///////トップの右のナビ//////////////
        const top_nav_items = document.querySelectorAll('.top_nav_item');
        const top_nav_item_spans = document.querySelectorAll('.top_nav_item_span');

        const team_items = document.querySelectorAll('.team_items');

        function mouse(current, target, todoclass) {
            for(let i = 0; i < target.length; i++){
               target[i].addEventListener('mouseover', () => {
                    current[i].classList.add(todoclass);
                }, false);
               target[i].addEventListener('mouseleave', () => {
                    current[i].classList.remove(todoclass);
                }, false);
            }
        }

        mouse(top_nav_item_spans, top_nav_items, 'move_span');

        mouse(team_items, team_items, 'show');

    });
}
