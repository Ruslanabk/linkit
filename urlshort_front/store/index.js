import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = () => new Vuex.Store({

  state: {
    token: '',
    user: {
      id: '',
      username: '',
      email: '',
    },
    links: []
  },
  mutations: {
    setToken (state, nToken) {
      state.token = nToken;
    },
    setLinks(state, links){
      state.links = links;
    },
    setUserData(state, user){
      state.user = user;
    }
  }
})

export default store