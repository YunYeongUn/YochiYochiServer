import axios from "../../plugins/axios";
import { useCookies } from "vue3-cookies";
const { cookies } = useCookies();

export default {
  namespaced: true,
  state: {
    needLogin: true,
  },
  mutations: {
    needLogin(state, data) {
      state.needLogin = data;
    },
  },
  getters: {
    needLogin(state) {
      return state.needLogin;
    },
  },
  actions: {
    async login({ commit }, params) {
      try {
        const rs = await axios.post("http://localhost/api/login", params);
        console.log(rs);
        if (rs.data) {
          const access = rs.data.access_token;
          const refresh = rs.data.refresh_token;
          const { cookies } = useCookies();
          cookies.set("accessToken", access, { expires: 1 });
          cookies.set("refreshToken", refresh, { expires: 7 });
          commit("needLogin", false);
        }
        return rs.data.msg;
      } catch (err) {
        console.error(err);
        throw err;
      }
    },
    async verifyToken({ commit }) {
      try {
        const rs = await axios.post("http://localhost/api/auth");
        if (rs.data.ok) {
          return true;
        } else {
          console.error(rs.data.msg);
          alert(rs.data.result);
          commit("needLogin", true);
          return false;
        }
      } catch (err) {
        console.error(err);
        if (err.response && err.response.status === 401) {
          // Unauthorized error: JWT token is invalid or expired
          alert("Your session has expired. Please log in again.");
          commit("needLogin", true);
        } else if (err.response && err.response.status === 500) {
          // Internal server error
          alert("Internal server error. Please try again later.");
        } else {
          alert("Failed to verify token. Please try again later.");
        }
        throw err;
      }
    },
    async refreshToken({ commit }) {
      try {
        const rs = await axios.post("http://localhost/api/refresh");
        if (rs.data.ok) {
          const access = rs.data.access_token;
          const { cookies } = useCookies();
          cookies.set("accessToken", access, import.meta.env.VITE_ACCESS_TIME);
          commit("needLogin", false);
          return true;
        } else {
          console.error(rs.data.msg);
          commit("needLogin", true);
          return false;
        }
      } catch (err) {
        console.error(err);
        throw err;
      }
    },
  },
};
