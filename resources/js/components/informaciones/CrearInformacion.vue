<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informaciones</h3>      

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                                Añadir Info
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
                                    <th>Nombre</th>                                    
                                    <th>Descripcion</th>
                                    <th>Enlace</th>  
                                    <th>Foto</th>  
                                    <th>Acciones</th>                                    
                                    <!--<th>Bio</th>                                    
                                    <th>Editar</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(informacion,id) in informaciones" :key="id">
                                    <td>{{id+1}}</td>
                                    <td>{{informacion.nombre_informacion}}</td>
                                    <td>{{informacion.descripcion_informacion}}</td>
                                    <td>{{informacion.enlace_informacion}}</td>                                    
                                    <td><img :src="'img/informaciones/'+informacion.foto" class="img-responsive" height="50" width="50"></td>                                    
                                    <!--<td>{{user.bio}}</td>-->                                

                                    <td class="justify-items-center">
                                        <a href="#">
                                            <i class="fa fa-edit" @click="editModal(informacion)"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteInformacion(informacion.id)">
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Informacion</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar Informacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateInformacion() : createInformacion()">

                        <div class="modal-body">
                            <div class="form-group">
                                <v-text-field 
                                    label="Nombre" 
                                    v-model="form.nombre_informacion" 
                                    type="text" 
                                    name="nombre_informacion"                                    
                                    prepend-icon="fa-solid fa-square-pen"                               
                                    :class="{ 'is-invalid': form.errors.has('nombre_informacion') }">
                                </v-text-field>
                                <has-error :form="form" field="nombre_informacion"></has-error>
                            </div>                                                                                                                        

                            <div class="form-group">
                                <v-textarea 
                                    label="Descripción"
                                    v-model="form.descripcion_informacion" 
                                    name="descripcion_informacion" 
                                    id="descripcion_informacion"                                    
                                    value="Ingrese una palabra clave"
                                    prepend-icon="fa-solid fa-file-lines"
                                    :class="{ 'is-invalid': form.errors.has('descripcion_informacion') }">
                                </v-textarea>
                                <has-error :form="form" field="descripcion_informacion"></has-error>
                            </div>  

                            <div class="form-group">                                
                                <v-file-input 
                                    v-model="foto"  
                                    accept="image/*"                                   
                                    show-size
                                    counter
                                    label="Foto" 
                                    @change="fotoInformacion" 
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
    </div>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                informaciones : [],
                foto: [],
                form: new Form({
                    id : '',
                    nombre_informacion : '',                    
                    descripcion_informacion : '', 
                    enlace_informacion: '',
                    foto : '',                              
                }),                
            }
        },        
        methods: { 
            updateInformacion(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/informaciones/'+this.form.id)
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
            editModal(informacion){
                //console.log(facultad)
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(informacion);
                this.foto = new File([""], this.form.foto, {type: "text/plain", lastModified: new Date().toString()});
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                this.foto = [];
                $('#addNew').modal('show');
            },
            deleteInformacion(id){
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
                        this.form.delete('api/facultades/'+id).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'La Información ha sido Eliminada.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadInformacion(){                                               
                await axios.get("api/informaciones")
                    .then(response =>{
                        this.informaciones = response.data;                        
                    })
                    .catch(error=>{
                        this.informaciones = []
                    });                
            },        
            fotoInformacion(e){      
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
            createInformacion(){
                this.$Progress.start();
                this.form.post('api/informaciones')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Información Creada Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },            
            
        },
        created() {
            this.loadInformacion();
            Fire.$on('AfterCreate',() => {
               this.loadInformacion();
            }); 
        }
    }
</script>

