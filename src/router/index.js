import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import AboutView from "../views/AboutView.vue";
import Profile from "../views/Profile.vue";
import Community from "../components/BoardList.vue";
import Qna from "../components/QnaList.vue";
import Movenet from "../components/MoveTest.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/about",
    name: "about",
    component: AboutView,
  },
  {
    path: "/profile",
    name: "profile",
    component: Profile,
  },
  {
    path: "/board/1",
    name: "community",
    component: Community,
  },
  {
    path: "/board/2",
    name: "Qna",
    component: Qna,
  },
  {
    path: "/movenet",
    name: "movenet",
    component: Movenet,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
