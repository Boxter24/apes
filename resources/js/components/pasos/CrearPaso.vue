<template>
    <v-app class="container">
        <div class="row mt-5">
            <div class="col-md-12"> 
                <div class="card-tools">                            
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                        Añadir Paso
                        <i class="fas fa-user-plus fa-fw"></i>
                    </button>
                </div>        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pasos</h3>      
                        <div class="card-tools">
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="buscar"
                                single-line
                                hide-details
                            ></v-text-field>                            
                        </div>              
                    </div>
                    <!-- /.card-header -->
                    <v-card>                        
                        <v-data-table
                            :headers="headers"
                            :items="pasos"
                            :search="search"
                        >   
                            <template v-slot:item.foto="{ item }">
                                <div class="p-2">
                                    <v-img :src="'img/pasos/'+item.foto" :alt="item.foto" width="50px" height="50px"></v-img>
                                </div>
                            </template>
                            <template v-slot:item.accion="{ item }">
                                <a href="#">
                                    <i class="fa fa-edit" @click="editModal(item)"></i>
                                </a>
                                /
                                <a href="#" @click="deletePaso(item.id)">
                                    <i class="fa fa-trash" style="color: red"></i>
                                </a>
                            </template>
                        </v-data-table>
                    </v-card>                    
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Paso</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updatePaso() : createPaso()">
                        <div class="modal-body">
                            <div class="form-group">
                                <v-text-field 
                                    label="Nombre"  
                                    v-model="form.nombre_paso" 
                                    type="text" 
                                    name="nombre_paso"                                    
                                    prepend-icon="fa-solid fa-square-pen"                               
                                    :class="{ 'is-invalid': form.errors.has('nombre_paso') }">
                                </v-text-field>
                                <has-error :form="form" field="nombre_paso"></has-error>
                            </div>                                                                                                                        

                            <div class="form-group">
                                <v-textarea 
                                    label="Descripción" 
                                    v-model="form.descripcion_paso" 
                                    name="descripcion_paso" 
                                    id="descripcion_paso"                                    
                                    value="Ingrese una palabra clave"
                                    prepend-icon="fa-solid fa-file-lines"
                                    :class="{ 'is-invalid': form.errors.has('descripcion_paso') }">
                                </v-textarea>
                                <has-error :form="form" field="descripcion_paso"></has-error>
                            </div>                              

                            <div class="form-group">
                                <v-text-field 
                                    label="Enlace"  
                                    v-model="form.enlace_paso" 
                                    type="text" 
                                    name="enlace_paso"                                    
                                    prepend-icon="fa-solid fa-square-pen"                               
                                    :class="{ 'is-invalid': form.errors.has('enlace_paso') }">
                                </v-text-field>
                                <has-error :form="form" field="enlace_paso"></has-error>
                            </div>                             

                            <div class="form-group">                                
                                <v-file-input  
                                    v-model="foto"                                    
                                    accept="image/*"
                                    show-size
                                    counter
                                    label="Foto" 
                                    @change="fotoPaso" 
                                    name="foto" 
                                    prepend-icon="mdi-camera"
                                    :class="{ 'is-invalid': form.errors.has('foto') }">
                                </v-file-input>    
                                <has-error :form="form" field="foto"></has-error>                                
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
    </v-app>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,                                
                foto: [],
                form: new Form({ 
                    id : '',  
                    nombre_paso : '',                    
                    descripcion_paso : '',  
                    orden_paso : '',                                          
                    enlace_paso : '',  
                    id_guia : '',
                    foto : '',                                     
                }),
                search: '',
                headers: [
                    {
                        text: 'Nombre',
                        align: 'start',
                        sortable: false,
                        value: 'nombre_paso',
                    },                    
                    { text: 'Descripción', value: 'descripcion_paso' },           
                    { text: 'Enlace', value: 'enlace_paso' },                                                     
                    { text: 'Foto', value: 'foto' },                                                  
                    { text: 'Acciones', value: 'accion' },
                ],
                pasos : [],
                guias : [],
            }
        },
        mounted() {
            //console.log(this.form)
        },
        methods: { 
            updatePaso(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/pasos/'+this.form.id)
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
            editModal(paso){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(paso);
                this.foto = new File([""], this.form.foto, {type: "text/plain", lastModified: new Date().toString()});
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                this.foto = [];
                $('#addNew').modal('show');
            },
            deletePaso(id){
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
                        this.form.delete('api/pasos/'+id).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'El Paso ha sido Eliminado.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadPaso(){   
                if(this.$gate.isAdmin()){                             
                    await axios.get("api/pasos/"+this.$route.query.guia)
                        .then(response =>{
                            this.pasos = response.data;
                            this.form.id_guia = this.$route.query.guia;
                        })
                        .catch(error=>{
                            this.pasos = []
                        });
                }
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
            fotoPaso(e){      
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
            createPaso(){
                this.$Progress.start();
                this.form.id_guia = this.$route.query.guia;
                this.form.post('api/pasos')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Paso Creado Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            
        },
        created() {            
            this.loadPaso();                        
            Fire.$on('AfterCreate',() => {
               this.loadPaso();
            }); 
        }
    }
</script>

