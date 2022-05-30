<template>
    <v-container>
        <div class="foros contenido">
            <v-card
                elevation="5"
                v-for="guia in guias"
                :key="guia.id"
                class="card-foro"
            >   
                <div class="titulos d-flex justify-space-between">
                    <v-card-title>{{guia.nombre_guia}}</v-card-title>                    
                </div>                                
                <router-link :to="`/Pasos?guia=${guia.id}`" class="linkComentarios">
                    <v-row
                        align="center"
                        justify="space-around"
                        class="contenedor-boton-comentar"
                    >
                        <v-btn
                            tile
                            color="success"
                            class="comentar-foro"
                        >
                        <v-icon left>
                            mdi-pencil
                        </v-icon>
                            Ver Pasos
                        </v-btn>
                    </v-row>
                </router-link>
            </v-card>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Guia</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateGuia() : createGuia()">
                        <div class="modal-body">
                            <div class="form-group">
                                <v-text-field 
                                    label="Nombre"  
                                    v-model="form.nombre_guia" 
                                    type="text" 
                                    name="nombre_guia"                                    
                                    prepend-icon="fa-solid fa-square-pen"                               
                                    :class="{ 'is-invalid': form.errors.has('nombre_guia') }">
                                </v-text-field>
                                <has-error :form="form" field="nombre_guia"></has-error>
                            </div>                                                                                                                        
                                                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Actualizar</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                guias : [],                
                form: new Form({ 
                    id : '',  
                    nombre_guia : '',                                                                                             
                })
            }
        },        
        methods: { 
            updateGuia(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/guias/'+this.form.id)
                .then(() => {
                    // success
                    $('#addNew').modal('hide');
                    Swal.fire(
                        'Actualizado!',
                        'Informacion Actualizada Correctamente.',
                        'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                    })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            editModal(guia){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(guia);                
            },
            newModal(){
                this.editmode = false;
                this.form.reset();                
                $('#addNew').modal('show');
            },
            deleteGuia(id){
                Swal.fire({
                    title: 'Estas Seguro?',
                    text: "Esta accion no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Borrar!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.delete('api/guias/'+id).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'La Guía ha sido Eliminado.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadGuia(){                                               
                await axios.get("api/guias")
                    .then(response =>{
                        this.guias = response.data;
                    })
                    .catch(error=>{
                        this.guias = []
                    });                
            },                      
            createGuia(){
                this.$Progress.start();
                this.form.post('api/guias')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Guía Creada Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            
        },
        created() {
            this.loadGuia();            
            Fire.$on('AfterCreate',() => {
               this.loadGuia();
            }); 
        }
    }
</script>