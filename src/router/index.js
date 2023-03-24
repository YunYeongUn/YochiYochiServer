import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import AboutView from "../views/AboutView.vue";
import Profile from "../views/Profile.vue";
import Community from "../components/BoardList.vue";
import Qna from "../components/QnaList.vue";
import Movenet from "../components/MoveTest.vue";
import PostShow from "../components/Post.vue";
import Login from "../components/Login.vue";
import { useCookies } from "vue3-cookies";
const { cookies } = useCookies();

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

export default function (store) {
  const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  router.beforeEach(async (to, from, next) => {
    if (import.meta.env.VITE_IS_LOGIN === "Y") {
      const access = cookies.get("accessToken");
      const refresh = cookies.get("refreshToken");

      //@@ refreshToken이 없을 경우 로그인 창 띄우기
      if (refresh === null) {
        console.warn("need login...");

        store.commit("auth/needLogin", true);
      } else if (access === null && refresh !== null) {
        //refreshToken은 있고 accessToken만 있을 경우 재발급요청
        await store.dispatch("auth/verifyToken");
      } else {
        //토큰이 다 있다면 페이지 이동 전 토큰 검증
        console.log("토큰인증시도...");
        await store.dispatch("auth/verifyToken");
      }
      return next();
    } else {
      store.commit("auth/needLogin", false);
      return next();
    }
  });
  return router;
}
