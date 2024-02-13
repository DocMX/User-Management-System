import { createApp } from 'vue'
import './index.css'
import CKEditor from '@ckeditor/ckeditor5-vue'
import App from './App.vue'
import store from './store';
import router from './router';
import axiosClient from './axios';

const app = createApp(App);

app
  .use(store)
  .use(router)
  .use(CKEditor)
  .mount('#app')
;