import { createStore } from 'vuex'
import user from "../helper/user"
import { getAPI } from '../axios-api';
import router from '@/router';


export const store = createStore({
  state () {
    return {
      ruta_foto: "http://localhost:8000",
      username : null,
      token : null,
      auth : false,
    }
  },
  mutations : {
    SET_LOGIN(state, params){
      state.username = params.username
      state.auth = true
      state.token = params.token
    },
    SET_LOGOUT(state){
      state.username = null,
      state.token = ""
      state.auth = false
    },
    REFRESH_LOGIN(state,token){
      state.auth = true
      state.token = token
    },
    SET_LOGOUT_REFRESH(state,params){
      state.auth = false
      state.username = params.username
      state.token = params.token
    }
  },
  actions : {
    login({dispatch},credentials){
      const url = "/login-api/"
              user.delete_user_register()
              getAPI.post(url , {username : credentials.username, password: credentials.password} )
              .then(response => {
                let params = { username : credentials.username , token : response.data["token"]}
                  user.set_user_logged(response.data["token"])
                  return   dispatch('doLogin',params)
              })
              .catch(error => {
                return error
              })
    },
    logout({dispatch}){
      let token = this.state.token
      console.log("El token es: "+token)
      let url = "logout/?token="+this.state.token
      getAPI.get(url)
      .then(response => {
          user.logout()
          return dispatch('doLogout')
      })
      .catch(
          error =>{
              return(error)
          }
      )
    },
    doLogin({commit},params){
      if (params.username && params.token){
        commit('SET_LOGIN',params)
        router.push("/panel_publicacion/")
      }
        else{
          commit('SET_LOGIN',"","")
        }
    },
    doLogout({commit}){
      commit('SET_LOGOUT')
      router.push("/login/");
    },
    getLogin({commit}){
      getAPI.get(
        "obtener_usuario/?token="+user.get_user_logged(),{
          headers : user.get_header_authorization_token()
        }
      ).then(response => {
          console.log("llegamos al metodo")
          commit('REFRESH_LOGIN',response.data.token)       
      }).catch(
       error =>{
        user.delete_user_register()
        let param = {'username': null,token : null}
        commit("SET_LOGOUT_REFRESH",param)
       }
      )
    },
    setLogin({commit}){
      if (user.get_user_logged()){
          commit("REFRESH_LOGIN",user.get_user_logged())
          this.dispatch("getLogin")
      }
      else {
        commit("SET_LOGOUT")
      }
    }
  },
})

