<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Imágenes Carrusel</h3>      

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                                Añadir Imagen
                                <i class="fas fa-user-plus fa-fw"></i>
                            </button>
                        </div>              
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>                                    
                                    <th>Foto</th>  
                                    <th>Acciones</th>                                    
                                    <!--<th>Bio</th>                                    
                                    <th>Editar</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(imagen_carrusel,id) in imagenes_carrusel" :key="id">
                                    <td>{{id+1}}</td>                                    
                                    <td><img :src="'img/carrusel/'+imagen_carrusel.foto" class="img-responsive" height="50" width="50"></td>                                    
                                    <!--<td>{{user.bio}}</td>-->                                

                                    <td class="justify-items-center">
                                        <a href="#">
                                            <i class="fa fa-edit" @click="editModal(imagen_carrusel)"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteFacultad(imagen_carrusel.id)">
                                            <i class="fa fa-trash" style="color: red"></i>
                                        </a>
                                    </td>   
                                </tr>                                                 
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Añadir Imagen</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar Imagen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateImagen() : createImagen()">

                        <div class="modal-body">                              
                            <div class="form-group">                                
                                <v-file-input 
                                    v-model="foto" 
                                    accept="image/*"                                   
                                    show-size
                                    counter
                                    label="Foto" 
                                    @change="fotoCarrusel" 
                                    name="photo"                                     
                                    prepend-icon="mdi-camera">
                                </v-file-input>                                 
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
        <div class="titulo-seccion mt-5">
            Vista Previa del Carrusel
        </div>         
        <v-carousel :show-arrows="false" cycle>            
            <v-carousel-item
                v-for="(imagen_carrusel,i) in imagenes_carrusel"
                :key="i"
                :src="'img/carrusel/'+imagen_carrusel.foto"                                       
            ></v-carousel-item>   
        </v-carousel>     
    </div>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                imagenes_carrusel : [],
                foto: [],
                form: new Form({
                    id : '',                     
                    foto : '',                              
                }),                
            }
        },       
        methods: { 
            updateImagen(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/carrusel/'+this.form.id)
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
            editModal(imagen){
                //console.log(facultad)
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(imagen);     
                this.foto = new File([""], this.form.foto, {type: "text/plain", lastModified: new Date().toString()});          
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
                this.foto = [];
            },
            deleteImagen(id){
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
                        this.form.delete('api/carrusel/'+id).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'La Imagen ha sido Eliminada.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadImagenes(){                                               
                await axios.get("api/carrusel")
                    .then(response =>{
                        this.imagenes_carrusel = response.data;
                    })
                    .catch(error=>{
                        this.imagenes_carrusel = []
                    });                
            },        
            fotoCarrusel(e){      
                //console.log(e)   ;                      
                //let file = e.target.files[0];
                if(e != null){
                    let reader = new FileReader();  
                    let size = e.size;              
                    //console.log(reader);
                    let limit = 1024 * 1024 * 2;
                    if(size > limit){
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'El archivo es muy pesado!',
                        })
                        return false;
                    }
                    reader.onloadend = (e) => {
                        //console.log(reader.result);
                        this.form.foto = reader.result;
                    }
                    reader.readAsDataURL(e);
                }else{
                    console.log("Se debe agregar una foto");
                }
                
            },                
            createImagen(){
                this.$Progress.start();
                this.form.post('api/carrusel')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Imagen Añadida Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },            
            
        },
        created() {
            this.loadImagenes();
            Fire.$on('AfterCreate',() => {
               this.loadImagenes();
            }); 
        }
    }
</script>

