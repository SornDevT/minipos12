import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import SideMenu from './components/SideMenu.vue';

const app = createApp(App)
app.component('SideMenu',SideMenu)
app.use(router)
app.mount('#app-vue');