<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">categorias</h3>      

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                                Añadir categoria
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
                                    <th>Acciones</th>                                    
                                    <!--<th>Bio</th>                                    
                                    <th>Editar</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in categorias" :key="categoria.id_categoria">
                                    <td>{{categoria.id_categoria}}</td>
                                    <td>{{categoria.nombre_categoria}}</td>
                                    <td>{{categoria.descripcion_categoria}}</td>                                    
                                    <!--<td>{{user.bio}}</td>-->                                

                                    <td class="justify-items-center">
                                        <a href="#">
                                            <i class="fa fa-edit" @click="editModal(categoria)"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deletecategoria(categoria.id_categoria)">
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear categoria</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updatecategoria() : createcategoria()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.nombre_categoria" type="text" name="nombre_categoria"
                                    placeholder="Nombre"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre_categoria') }">
                                <has-error :form="form" field="nombre_categoria"></has-error>
                            </div>                                                                                                                        

                            <div class="form-group">
                                <textarea v-model="form.descripcion_categoria" name="descripcion_categoria" id="descripcion_categoria"
                                placeholder="Descripcion"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('descripcion_categoria') }"></textarea>
                                <has-error :form="form" field="descripcion_categoria"></has-error>
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
                categorias : [],
                form: new Form({
                    id_categoria : '',
                    nombre_categoria : '',                    
                    descripcion_categoria : '',                    
                })
            }
        },
        mounted() {
            console.log(this.form)
        },
        methods: { 
            updatecategoria(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/categorias/'+this.form.id_categoria)
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
            editModal(categoria){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(categoria);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deletecategoria(id_categoria){
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
                        this.form.delete('api/categorias/'+id_categoria).then(()=>{
                            Swal.fire(
                            'Eliminada!',
                            'La categoria ha sido Eliminada.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            async loadcategoria(){   
                if(this.$gate.isAdmin()){                             
                    await axios.get("api/categorias")
                        .then(response =>{
                            this.categorias = response.data;
                        })
                        .catch(error=>{
                            this.categorias = []
                        });
                }
            },            
            createcategoria(){
                this.$Progress.start();
                this.form.post('api/categorias')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'categoria Creada Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            
        },
        created() {
            this.loadcategoria();
            Fire.$on('AfterCreate',() => {
               this.loadcategoria();
            }); 
        }
    }
</script>

