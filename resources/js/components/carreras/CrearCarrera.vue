<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12"> 
                <div class="card-tools">                            
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                        Añadir Carrera
                        <i class="fas fa-user-plus fa-fw"></i>
                    </button>
                </div>        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Carreras</h3>      
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
                            :items="carreras"
                            :search="search"
                        >   
                            <template v-slot:item.foto="{ item }">
                                <div class="p-2">
                                    <v-img :src="'img/carreras/'+item.foto" :alt="item.foto" width="50px" height="50px"></v-img>
                                </div>
                            </template>
                            <template v-slot:item.accion="{ item }">
                                <a href="#">
                                    <i class="fa fa-edit" @click="editModal(item)"></i>
                                </a>
                                /
                                <a href="#" @click="deleteCarrera(item.id)">
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Carrera</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateCarrera() : createCarrera()">
                        <div class="modal-body">
                            <div class="form-group">                                
                                <v-text-field 
                                    label="Nombre" 
                                    v-model="form.nombre_carrera" 
                                    type="text" 
                                    name="nombre_carrera"    
                                    prepend-icon="fa-solid fa-square-pen"                               
                                    :class="{ 'is-invalid': form.errors.has('nombre_carrera') }">
                                </v-text-field>
                                <has-error :form="form" field="nombre_carrera"></has-error>
                            </div>                                                                                                                        

                            <div class="form-group">                                
                                <v-textarea 
                                    label="Descripción"
                                    v-model="form.descripcion_carrera" 
                                    name="descripcion_carrera" 
                                    id="descripcion_carrera"
                                    value="Ingrese una palabra clave"
                                    prepend-icon="fa-solid fa-file-lines"
                                    :class="{ 'is-invalid': form.errors.has('descripcion_carrera') }">
                                </v-textarea>
                                <has-error :form="form" field="descripcion_carrera"></has-error>
                            </div>    
                            
                            <div class="form-group">                                
                                <v-select 
                                    item-text="nombre_facultad"
                                    item-value="id"
                                    v-model.number="form.id_facultad"
                                    id="select_facultad" 
                                    :items="facultades"
                                    label="Facultad"
                                    value=""
                                    prepend-icon="fa-solid fa-home">
                                </v-select>
                            </div>

                            <div class="form-group">                                
                                <v-file-input       
                                    v-model="foto"  
                                    accept="image/*"                              
                                    show-size
                                    counter
                                    clearable
                                    label="Foto" 
                                    @change="fotoCarrera" 
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
                facultades : [],
                foto: [],                           
                form: new Form({
                    id : '',
                    nombre_carrera : '',                    
                    descripcion_carrera : '', 
                    id_facultad : '',  
                    foto : '',           
                }),
                search: '',
                headers: [
                    {
                        text: 'Nombre',
                        align: 'start',
                        sortable: false,
                        value: 'nombre_carrera',
                    },                    
                    { text: 'Descripción', value: 'descripcion_carrera' },
                    { text: 'Facultad', value: 'nombre_facultad' },
                    { text: 'Foto', value: 'foto' },                              
                    { text: 'Acciones', value: 'accion' },
                ],
                carreras : [],
            }
        },
        mounted() {            
            //console.log(this.facultades.length)            
        },        
        methods: {             
            updateCarrera(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/carreras/'+this.form.id)
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
            editModal(carrera){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(carrera);
                console.log(carrera)
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteCarrera(id){
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
                        this.form.delete('api/carreras/'+id).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'La Carrera ha sido Eliminada.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadCarrera(){                                               
                await axios.get("api/carreras")
                    .then(response =>{
                        this.carreras = response.data;
                        this.foto = new File([""], this.form.foto, {type: "text/plain", lastModified: new Date().toString()});
                    })
                    .catch(error=>{
                        this.carreras = []
                    });                                                                                           
            },            
            async loadFacultades(){
                await axios.get("api/facultades")
                    .then(response =>{
                        this.facultades = response.data;                                                
                    })
                    .catch(error=>{
                        this.facultades = []
                    }); 
            },
            createCarrera(){
                this.$Progress.start();
                this.form.post('api/carreras')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Carrera Creada Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            }, 
            fotoCarrera(e){      
                //console.log(e);                      
                let file = e;
                if(file != null){
                    let reader = new FileReader();  
                    let size = file.size;              
                    console.log(file);
                    console.log(reader);
                    let limit = 1024 * 1024 * 2;
                    if(size > limit){
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'El archivo es muy pesado!',
                        })
                        return false;
                    }
                    reader.onloadend = (file) => {
                        //console.log(reader.result);
                        this.form.foto = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    console.log("Se debe agregar una foto");
                }
                
            },                       
        },         
        created() { 
            this.loadFacultades();
            this.loadCarrera();                                      
            Fire.$on('AfterCreate',() => {
               this.loadCarrera();               
            }); 
        }
    }
</script>

