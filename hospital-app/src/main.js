import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import axios from './axios'; // Import the configured axios instance
import store from './store'


const app = createApp(App);
app.config.globalProperties.$axios = axios;

createApp(App).use(router).use(store).mount('#app');
