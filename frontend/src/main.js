import { createApp } from 'vue'
import './index.css'
import App from './App.vue'
import store from './store';
import router from './router';

const app = createApp(App);

app
  .use(store)
  .use(router)
  .mount('#app')
;