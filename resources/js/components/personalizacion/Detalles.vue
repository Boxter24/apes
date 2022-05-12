<template>    
  <v-row justify="center">
    <v-col
      cols="12"
      sm="10"
      md="10"
      lg="10"
      class="contenido" 
      style="margin-bottom: 3em"
    > 
      <div class="titulo-seccion">
          Detalles
      </div> 
      <form @submit.prevent="actualizarDetalles()">
        <v-card>
          <v-row>
            <v-col
              cols="12"
              md="6"
            >
              <div class="form-group">                                
                <v-text-field 
                    label="Nombre" 
                    v-model="form.nombre_institucion" 
                    type="text" 
                    require
                    name="nombre_institucion"    
                    prepend-icon="fa-solid fa-square-pen"                               
                    :class="{ 'is-invalid': form.errors.has('nombre_institucion') }">
                </v-text-field>
                <has-error :form="form" field="nombre_institucion"></has-error>
              </div>
            </v-col>                                                                                                                        

            <v-col
              cols="12"
              md="6"
            >
              <div class="form-group">                                
                <v-text-field 
                    label="Telefono" 
                    v-model="form.telefono_institucion" 
                    type="number" 
                    require
                    name="nombre_institucion"    
                    prepend-icon="fa-solid fa-square-pen"                               
                    :class="{ 'is-invalid': form.errors.has('telefono_institucion') }">
                </v-text-field>
                <has-error :form="form" field="telefono_institucion"></has-error>
              </div>
            </v-col>   
          </v-row>

          <div class="form-group">                                
              <v-textarea 
                  label="Descripción"
                  v-model="form.descripcion_institucion" 
                  name="descripcion_carrera" 
                  id="descripcion_carrera"
                  value="Ingrese una palabra clave"
                  prepend-icon="fa-solid fa-file-lines"
                  :class="{ 'is-invalid': form.errors.has('descripcion_institucion') }">
              </v-textarea>
              <has-error :form="form" field="descripcion_institucion"></has-error>
          </div>

          <div class="form-group">                                
              <v-textarea 
                  label="Direccion"
                  v-model="form.direccion_institucion" 
                  name="descripcion_carrera" 
                  id="direccion_institucion"
                  value="Ingrese una palabra clave"
                  prepend-icon="fa-solid fa-file-lines"
                  :class="{ 'is-invalid': form.errors.has('direccion_institucion') }">
              </v-textarea>
              <has-error :form="form" field="direccion_institucion"></has-error>
          </div>                          

          <div class="form-group">                                
            <v-text-field 
                label="Correo" 
                v-model="form.correo_institucion" 
                type="email"
                require
                name="nombre_institucion"    
                prepend-icon="fa-solid fa-square-pen"                               
                :class="{ 'is-invalid': form.errors.has('correo_institucion') }">
            </v-text-field>
            <has-error :form="form" field="correo_institucion"></has-error>
          </div>                    

          <div class="form-group">                                
              <v-file-input            
                  v-model="foto"             
                  accept="image/*"                              
                  show-size
                  counter
                  clearable
                  label="Logo" 
                  @change="Logo" 
                  name="photo" 
                  prepend-icon="mdi-camera">
              </v-file-input>                                    
          </div>          
                                                                                                                                                                                                                                                                                                                    
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success">Actualizar</button>            
          </div>
        </v-card>
      </form>
    </v-col>
  </v-row>
</template>

<script>
  export default {
    data: () => ({      
        foto: [],
        detalles: [],
        errorMessages: '',
        name: null,
        address: null,      
        formHasErrors: false,
        form: new Form({
          id: '',
          nombre_institucion: '',
          descripcion_institucion: '',
          direccion_institucion: '',
          telefono_institucion: '',
          correo_institucion: '',
          servicios_institucion: '',
          logo_institucion: '',          
        })
    }),        

    methods: {      
      actualizarDetalles(){
        this.$Progress.start();
        // console.log('Editing data');
        this.form.put('api/detalles/'+this.form.id)
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
      Logo(e){              
        let file = e;
        if(file != null){
            let reader = new FileReader();  
            let size = file.size;                          
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
                this.form.logo_institucion = reader.result;
            }
            reader.readAsDataURL(file);
        }else{
            console.log("Se debe agregar una foto");
        }        
      },  
      async loadDetalles (){                                               
        await axios.get("api/detalles")
            .then(response =>{
                //console.log(response.data[0]);
                //this.detalles = response.data;  
                this.form.fill(response.data);
                this.foto = new File([""], this.form.logo_institucion, {type: "text/plain", lastModified: new Date().toString()});
            })
            .catch(error=>{
                this.detalles = [];  
            });                                                                                           
      },        
    },
    created() { 
      this.loadDetalles();                                         
      Fire.$on('AfterCreate',() => {
          this.loadDetalles();               
      }); 
    }
  }
</script>