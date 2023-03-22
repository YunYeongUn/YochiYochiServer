import { createStore } from "vuex";

import auth from "./auth/auth";
import community from "./Community/community";

const store = createStore({
  state: {
    rootState: "aaa",
  },
  mutations: {
    rootState(state, payload) {
      state.rootState = payload;
    },
  },
  getters: {
    rootState(state) {
      return state.rootState;
    },
  },
  modules: {
    auth,
    community,
  },
});

export default store;
