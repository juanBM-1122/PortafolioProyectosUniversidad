import './assets/main.css'
import './css/style.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from "axios";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const options = {
    transition: "Vue-Toastification__fade",
    maxToasts: 20,
    newestOnTop: true
  };

axios.defaults.baseURL = "http://localhost:8000";

const app = createApp(App)

app.use(router)
app.use(Toast, options);

app.mount('#app')
