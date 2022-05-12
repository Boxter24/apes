<template>
    <v-container>
        <div class="contenido mx-2 d-flex">
            <v-btn            
                fab
                dark
                color="indigo" 
                @click="newModal" data-toggle="modal" data-target="#addNew"         
            >
                <v-icon 
                    dark
                    class="mx-auto"
                >
                    mdi-plus
                </v-icon>
            </v-btn>
            <p class="titulo-seccion align-center" style="margin-top: 15px; margin-left: 10px;">Añadir Foro</p>
        </div>

        <div class="foros contenido">
            <v-card
                elevation="5"
                v-for="foro in foros"
                :key="foro.id"
            >   
                <div class="titulos d-flex justify-space-between">
                    <v-card-title>{{foro.nombre_foro}}</v-card-title>
                    <div class="datos">
                        <p class="titulosDatos">Fecha de Publicación: 22-04-2021</p>
                        <p class="titulosDatos">Publicado por José Q.</p>
                    </div>
                </div>                
                <v-card-text>{{foro.comentario_foro}}</v-card-text>
            </v-card>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Foro</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateForo() : createForo()">
                        <div class="modal-body">
                            <div class="form-group">
                                <v-text-field 
                                    label="Nombre"  
                                    v-model="form.nombre_foro" 
                                    type="text" 
                                    name="nombre_foro"                                    
                                    prepend-icon="fa-solid fa-square-pen"                               
                                    :class="{ 'is-invalid': form.errors.has('nombre_foro') }">
                                </v-text-field>
                                <has-error :form="form" field="nombre_foro"></has-error>
                            </div>                                                                                                                        

                            <div class="form-group">
                                <v-textarea 
                                    label="Comentario" 
                                    v-model="form.comentario_foro" 
                                    name="comentario_foro" 
                                    id="comentario_foro"                                    
                                    value="Ingrese una palabra clave"
                                    prepend-icon="fa-solid fa-file-lines"
                                    :class="{ 'is-invalid': form.errors.has('comentario_foro') }">
                                </v-textarea>
                                <has-error :form="form" field="comentario_foro"></has-error>
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
                foros : [],                
                form: new Form({ 
                    id : '',  
                    nombre_foro : '',                    
                    comentario_foro : '',
                    id_usuario : '1',                                                                                               
                })
            }
        },        
        methods: { 
            updateForo(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/foros/'+this.form.id)
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
            editModal(foro){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(foro);                
            },
            newModal(){
                this.editmode = false;
                this.form.reset();                
                $('#addNew').modal('show');
            },
            deleteforo(id){
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
                        this.form.delete('api/foros/'+id).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'El foro ha sido Eliminado.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadForo(){                                               
                await axios.get("api/foros")
                    .then(response =>{
                        this.foros = response.data;
                    })
                    .catch(error=>{
                        this.foros = []
                    });                
            },                      
            createForo(){
                this.$Progress.start();
                this.form.post('api/foros')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Foro Creado Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            
        },
        created() {
            this.loadForo();            
            Fire.$on('AfterCreate',() => {
               this.loadForo();
            }); 
        }
    }
</script>