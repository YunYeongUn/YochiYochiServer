import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import AboutView from "../views/AboutView.vue";
import Profile from "../views/Profile.vue";
import Community from "../components/BoardList.vue";
import Qna from "../components/QnaList.vue";
import Movenet from "../components/MoveTest.vue";
import PostShow from "../components/Post.vue";

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
    path: "/community",
    name: "community",
    component: Community,
  },
  {
    path: "/qna",
    name: "Qna",
    component: Qna,
  },
  {
    path: "/movenet",
    name: "movenet",
    component: Movenet,
  },
  {
    path: "/community/:id",
    name: "Postshow",
    component: PostShow,
  },
  {
    path: "/qna/:id",
    name: "QnAshow",
    component: PostShow,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
