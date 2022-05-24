<template>  
    <div class="container">
        <div class="titulo-seccion">
            Comentario:
        </div>         
        <v-row class="comentario-foro">
            {{foro.comentario_foro}}
        </v-row>
        <div class="contenido mx-2 d-flex">
            <v-btn            
                fab
                dark
                color="indigo" 
                @click="newModal" data-toggle="modal" data-target="#addNew"       
                style="margin-left: 12px"  
            >
                <v-icon 
                    dark
                    class="mx-auto"
                >
                    mdi-plus
                </v-icon>
            </v-btn>
            <p class="titulo-seccion align-center" style="margin-top: 15px; margin-left: 10px;">Añadir Respuesta</p>
        </div>  
        <div class="titulo-seccion" style="margin-top: 15px">
            Respuestas:  
        </div>         
        <v-timeline
            dense
            clipped
        >    
            <v-timeline-item
                v-for="comentario in comentarios"
                :key="comentario.id"
                large
            >
            <template v-slot:icon>
                <v-avatar>
                <img :src="'img/profile/'+comentario.foto">
                </v-avatar>
            </template>
            <template>
                <span>{{comentario.name}}</span>
            </template>
            <v-card class="elevation-2">
                <v-card-title class="text-h5">
                Respuesta a : {{comentario.nombre_foro}}    
                </v-card-title>
                <v-card-text>{{comentario.comentario}}</v-card-text>
            </v-card>
            </v-timeline-item>
        </v-timeline>
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
                    <form @submit.prevent="editmode ? updateComentario() : createComentario()">
                        <div class="modal-body">                            
                            <div class="form-group">
                                <v-textarea 
                                    label="Comentario" 
                                    v-model="form.comentario" 
                                    name="comentario" 
                                    id="comentario"                                    
                                    value="Ingrese una respuesta"
                                    prepend-icon="fa-solid fa-file-lines"
                                    :class="{ 'is-invalid': form.errors.has('comentario') }">
                                </v-textarea>
                                <has-error :form="form" field="comentario"></has-error>
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
    </div>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                foro : [],
                comentarios : [],                
                form: new Form({ 
                    id : '',
                    id_foro : this.$route.query.foro,
                    comentario : '',                                        
                    id_usuario : '1',                   
                    fecha_comentario : '',                                                                            
                })
            }
        },        
        methods: { 
            updateComentario(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/comentarios/'+this.form.id)
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
            editModal(comentario){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(comentario);                
            },
            newModal(){
                this.editmode = false;
                this.form.reset();                
                $('#addNew').modal('show');
            },
            deleteComentario(id){
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
                            'El Comentario ha sido Eliminado.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadComentario(){                                               
                await axios.get("api/comentarios/"+this.$route.query.foro)
                    .then(response =>{
                        this.comentarios = response.data;
                    })
                    .catch(error=>{
                        this.comentarios = []
                    });                
            }, 
            async loadForo(){                                               
                await axios.get("api/foros/"+this.$route.query.foro)
                    .then(response =>{
                        this.foro = response.data;
                    })
                    .catch(error=>{
                        this.foro = []
                    });                
            },                     
            createComentario(){
                this.$Progress.start();
                this.form.post('api/comentarios')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Comentario Creado Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            
        },
        created() {
            this.loadComentario();            
            this.loadForo();            
            Fire.$on('AfterCreate',() => {
               this.loadComentario();
            }); 
        }
    }
</script>