export default class Gate{

    constructor(user){
        this.user = user;
    }


    isAdmin(){
        return this.user.tipo === 'admin';
    }

    isUser(){
        return this.user.tipo === 'user';
    }   


}