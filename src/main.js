import { createApp } from "vue";
import "./style.css";
/* import { Quasar } from "quasar";
import "@quasar/extras/material-icons/material-icons.css";
import "quasar/src/css/index.sass"; */

import router from "./router";
import store from "./store";
import axios from "./plugins/axios";
import axiosInterceptor from "./plugins/interceptor";
axiosInterceptor(store);

import App from "./App.vue";
const app = createApp(App);

app.use(router(store));
app.use(store);
app.provide("$axios", axios);
app.mount("#app");
