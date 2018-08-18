require('./bootstrap');
import Echo from 'laravel-echo';

window.io = require('socket.io-client');
window.Vue = require('vue');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6005'
});


Vue.component('chat-event', require('./components/ChatEvent.vue'));
const app = new Vue({
    el: '#app'
});
