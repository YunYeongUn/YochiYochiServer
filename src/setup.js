/* import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "./plugins/axios";

const app = createApp(App);

app.use(router);
app.use(store);

// Add axios instance to Vue prototype
app.config.globalProperties.$axios = axios;

// Add axios request interceptor
axios.interceptors.request.use(
  (config) => {
    // Do something before request is sent
    console.log("Request interceptor", config);
    return config;
  },
  (error) => {
    // Do something with request error
    console.log("Request interceptor error", error);
    return Promise.reject(error);
  }
);

// Add axios response interceptor
axios.interceptors.response.use(
  (response) => {
    // Do something with response data
    console.log("Response interceptor", response);
    return response;
  },
  (error) => {
    // Do something with response error
    console.log("Response interceptor error", error);
    return Promise.reject(error);
  }
);

app.mount("#app"); */
