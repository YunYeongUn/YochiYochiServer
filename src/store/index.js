import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

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
  plugins: [
    createPersistedState({
      paths: ["auth"],
    }),
  ],
});

export default store;
