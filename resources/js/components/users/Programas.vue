<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Programas</h3>      

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                                Añadir Programa
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
                                    <th>Nombre del Programa</th>                                    
                                    <th>categoria</th>
                                    <th>Subcategoria</th>
                                    <th>Framework o Lenguaje</th>                                  
                                    <th>enlace</th>                                                                        
                                    <th>Acciones</th>
                                    <!--<th>Bio</th>                                    
                                    <th>Editar</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="programa in programas.data" :key="programa.id">
                                    <td>{{programa.id}}</td>
                                    <td>{{programa.nombre_programa}}</td>
                                    <td>{{programa.categoria}}</td>
                                    <td>{{programa.subcategoria}}</td>
                                    <td>{{programa.framework_lenguaje}}</td>                                    
                                    <td>{{programa.enlace}}</td>
                                    <!--<td>{{user.bio}}</td>-->                                

                                    <td class="justify-items-center">
                                        <a href="#">
                                            <i class="fa fa-edit" @click="editModal(programa)"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deletePrograma(programa.id)">
                                            <i class="fa fa-trash red"></i>
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Programa</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updatePrograma() : createPrograma()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.nombre_programa" type="text" name="nombre_programa"
                                    placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre_programa') }">
                                <has-error :form="form" field="nombre_programa"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="categoria" v-model="form.categoria" id="categoria" class="form-control" :class="{ 'is-invalid': form.errors.has('categoria') }">
                                    <option value="">Seleccione una categoria</option>
                                    <option value="movil">App Movil</option>
                                    <option value="escritorio">App de Escritorio</option>                                    
                                </select>
                                <has-error :form="form" field="categoria"></has-error>
                            </div>  

                            <div class="form-group">
                                <select name="subcategoria" v-model="form.subcategoria" id="subcategoria" class="form-control" :class="{ 'is-invalid': form.errors.has('subcategoria') }">
                                    <option value="">Seleccione una Subcategoria</option>
                                    <option value="juego">Juego</option>
                                    <option value="ecommerce">Ecommerce</option>                                    
                                </select>
                                <has-error :form="form" field="subcategoria"></has-error>
                            </div>                                                                      

                            <div class="form-group">
                                <textarea v-model="form.framework_lenguaje" name="framework_lenguaje" id="framework_lenguaje"
                                placeholder="framework o lenguaje"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('framework_lenguaje') }"></textarea>
                                <has-error :form="form" field="framework_lenguaje"></has-error>
                            </div>          

                                                        
                                                                                                                                                                                       
                            <div class="form-group">
                                <input v-model="form.enlace" type="text" name="enlace" id="enlace"
                                placeholder="Enlace"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('enlace') }">
                                <has-error :form="form" field="enlace"></has-error>
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
                programas : {},
                form: new Form({
                    id : '',
                    nombre_programa : '',                    
                    categoria : '',
                    subcategoria : '',
                    framework_lenguaje : '',                    
                    foto_programa : '',
                    enlace : '',
                })
            }
        },
        mounted() {
            console.log(this.form.nombre_programa)
        },
        methods: { 
            updatePrograma(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/programa/'+this.form.id)
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
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deletePrograma(id){
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
                        this.form.delete('api/programa/'+id).then(()=>{
                            Swal.fire(
                            'Eliminado!',
                            'El Programa ha sido Eliminado.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            loadPrograma(){                                
                axios.get("api/programa").then(({ data }) => (this.programas = data));
                
            },            
            createPrograma(){
                this.$Progress.start();
                this.form.post('api/programa')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Programa Creado Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            
        },
        created() {
            this.loadPrograma();
                      
        }
    }
</script>

