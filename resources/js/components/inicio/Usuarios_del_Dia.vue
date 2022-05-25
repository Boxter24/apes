<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdmin()">
            <div class="col-md-12"> 
                <div class="card-tools">                            
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">
                        Añadir Usuario
                        <i class="fas fa-user-plus fa-fw"></i>
                    </button>
                </div>        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Usuarios del Día</h3>      
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
                            :items="users"
                            :search="search"
                        >   
                            <template v-slot:item.foto="{ item }">
                                <div class="p-2">
                                    <v-img :src="'img/profile/'+item.foto" :alt="item.foto" width="50px" height="50px"></v-img>
                                </div>
                            </template>
                            <template v-slot:item.accion="{ item }">
                                <a href="#">
                                    <i class="fa fa-edit" @click="editModal(item)"></i>
                                </a>
                                /
                                <a href="#" @click="deleteUser(item.id)">
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Crear Usuario</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                    placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.ci" type="number" name="ci"
                                    placeholder="CI"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('ci') }">
                                <has-error :form="form" field="ci"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.telefono" type="number" name="telefono"
                                    placeholder="Telefono"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                                <has-error :form="form" field="ci"></has-error>
                            </div>                                                                           

                            <div class="form-group">
                                <textarea v-model="form.direccion" name="direccion" id="direccion"
                                placeholder="Direccion"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('direccion') }"></textarea>
                                <has-error :form="form" field="direccion"></has-error>
                            </div>       

                            <div class="form-group">
                                <select name="type" v-model="form.tipo" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>                                    
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>                     
                                                                                                                                                            
                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email"
                                    placeholder="Email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" id="password"
                                placeholder="Password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
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
                form: new Form({
                    id : '',
                    name : '',                    
                    ci : '',
                    telefono : '',
                    direccion : '',                    
                    foto : '',
                    tipo : '',
                    email : '',
                    password : '',
                }),
                search: '',
                headers: [
                    {
                        text: 'Nombre',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },                    
                    { text: 'Apellido', value: 'apellido' },
                    { text: 'CI', value: 'ci' },
                    { text: 'Telefono', value: 'telefono' },
                    { text: 'Dirección', value: 'direccion' },
                    { text: 'Foto', value: 'foto' },       
                    { text: 'Tipo', value: 'tipo' },   
                    { text: 'Correo', value: 'email' },          
                    { text: 'Acciones', value: 'accion' },
                ],
                users: [],
            }
        },        
        methods: { 
            updateUser(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/user/'+this.form.id)
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
            deleteUser(id){
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
                        this.form.delete('api/user/'+id).then(()=>{
                            Swal.fire(
                            'Eliminado!',
                            'El Usuario ha sido Eliminado.',
                            'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            Swal.fire("Error!", "Ha ocurrido algun Problema.", "warning");
                        });    
                    }
                })
            },                                                              
            loadUsers(){                
                if(this.$gate.isAdmin()){
                    axios.get("api/user/hoy").then(response => (this.users = response.data));                
                }
            },            
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Usuario Creado Satisfactoriamente'
                })
                this.$Progress.finish();
                })
                .catch(()=>{
                })
            }   
        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate',() => {
               this.loadUsers();
            });          
        }
    }
</script>

