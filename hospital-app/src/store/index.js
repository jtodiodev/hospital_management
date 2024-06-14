import { createStore } from 'vuex'

export default createStore({
  state() {
    return {
      user: null,
    }
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user
    },
  },
  actions: {
    async login({ commit }, user) {
      commit('SET_USER', user)
    },
  },
  modules: {
  },
})