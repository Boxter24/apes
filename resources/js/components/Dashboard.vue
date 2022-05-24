<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{users}}</h3>
                        <p>Usuarios Registrados HOY</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <router-link to="/usuariosHoy" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></router-link>                    
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{foros}}</h3>
                        <p>Foros Añadidos HOY</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <router-link to="/forosHoy" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></router-link>                    
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{comentarios}}</h3>
                        <p>Comentarios del Día</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <router-link to="/comentariosHoy" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></router-link>                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {                                
                users: [],
                foros: [],
                comentarios: [],
            }
        },   
        methods: {                                                                         
            async loadUsers(){                
                if(this.$gate.isAdmin()){
                    await axios.get("api/user/fecha").then(response => (this.users = response.data));                
                }
            },         
            async loadForo(){                                               
                await axios.get("api/foros/forosDelDia")
                    .then(response =>{
                        this.foros = response.data;
                    })
                    .catch(error=>{
                        this.foros = []
                    });                
            },                
            async loadComentario(){                                               
                await axios.get("api/comentarios/comentariosDelDia")
                    .then(response =>{
                        this.comentarios = response.data;
                    })
                    .catch(error=>{
                        this.comentarios = []
                    });                
            },  
        },
        created() {
            this.loadUsers();
            this.loadForo();
            this.loadComentario();
            Fire.$on('AfterCreate',() => {
               this.loadUsers();
            });          
        }
    }
</script>