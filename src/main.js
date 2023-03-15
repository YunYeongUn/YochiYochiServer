import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import axios from "axios";
import routes from "./router/";

const app = createApp(App);

app.use(routes);

app.config.globalProperties.axios = axios;

app.mount("#app");
