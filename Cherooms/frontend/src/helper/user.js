import Cookies from "js-cookie";
export default {
    set_user_logged(token){
        Cookies.set('userLogged',token, { sameSite:'strict',HttpOnly: false })
    },
    get_user_logged(){
        return Cookies.get('userLogged')
    },
    logout () {
        Cookies.remove('userLogged')
    },
    get_header_authorization_token(){
        if (Cookies.get("userLogged")){
            let header = {
                "Content-type" :"application/json; charset=UTF-8",
                "Authorization" :"Token " + Cookies.get('userLogged'),
            }      
            return header
        }
        else{
            return "No existe un usuario loguiado"
        }
    },
    set_user_register(username){
        Cookies.set("message_register",'Se creo correctamente el usuario ' + username )
    },
    get_user_register(){
        return Cookies.get("message_register")
    },
    delete_user_register(){
        Cookies.remove("message_register")
    }
};