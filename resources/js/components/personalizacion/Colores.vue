<template>    
    <div >
        <div class="titulo-seccion">
          Color Principal : <span v-if="tipoColor == 0">Un color</span><span v-else>Degradado</span>
        </div> 
        <v-container
            class="px-0"
            fluid
        >
            <v-radio-group fluid v-model="tipoColor">
                <v-radio                
                    label="Un solo Color"
                    value="0"
                ></v-radio>
                <v-radio                
                    label="Degradado"
                    value="1"
                ></v-radio>
            </v-radio-group>
        </v-container>
        <!-- Un Color -->
        <v-row 
            class="contenido" 
            justify="space-around"
            align="center"
            v-if="tipoColor == 0"            
        >                        
            <v-color-picker
                swatches-max-height="200"
                v-model="primario"
                elevation="15"                
            ></v-color-picker>  

            <v-col cols="6">   
                <div class="titulo-seccion">
                    Vista Previa del Color
                </div>              
                <v-col
                    v-if="primario != null"     
                    rounded-pill            
                    cols="12"
                    class="vista-color" 
                    :style="`background-color: ${primario.hex}; height: 5em; border-radius: 10px;`">
                </v-col>
            </v-col>                      
                                                              
            
        </v-row>
        <!--Degradado -->
        <v-row 
            class="contenido" 
            justify="space-around"
            align="center"
            v-else
        >                        
            <v-color-picker
                swatches-max-height="200"
                v-model="primario"
                elevation="15"
            ></v-color-picker>
            <v-color-picker
                swatches-max-height="200"
                v-model="secundario"
                elevation="15"
            ></v-color-picker> 

            <v-col 
                cols="6"
                style="margin-top:5em;"
            >   
                <div class="titulo-seccion">
                    Vista Previa del Color
                </div>
                <v-col
                    v-if="primario != null && secundario !=null"                
                    cols="12"
                    class="vista-color"                 
                    :style="`background: linear-gradient(${primario.hex}, ${secundario.hex}); height: 5em; border-radius: 10px;`">
                </v-col>  
            </v-col>   
        </v-row>  
        <v-row
            style="margin-top: 8em;"
            justify="space-around"
            align="center"
        >
            <v-btn
                depressed
                color="primary"
                @click="guardarColor()"
            >
                Guardar Color
            </v-btn> 
        </v-row>                   
    </div>  
</template>

<script>
  export default {
    data () {
        return {       
            tipoColor: "0",            
            primario: null,
            secundario: null,                 
            form: new Form({
                id: '',  
                color: '',  
                uso: '',
            })
        }
    },
    computed:{
        color(){
            if(this.primario !=null && this.secundario != null){
                this.form.color = "background: linear-gradient("+this.primario.hex+","+this.secundario.hex+")";                
            }
            else{
                this.form.color = "background-color:"+this.primario.hex+"";                
            }
            //console.log(this.form.color);
        },
        tipoColorSelect(){
            if(this.tipoColor){
                this.primario = null;
                this.secundario = null;
            }
        }
    }, 
    methods:{
        guardarColor(){            
            this.$Progress.start();
            // console.log('Editing data');
            this.form.put('api/colores/'+this.form.id)
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
        async loadColores (){                                               
            await axios.get("api/colores")
                .then(response =>{
                    //console.log(response.data[0]);
                    //this.detalles = response.data;  
                    this.form.fill(response.data);
                })
                .catch(error=>{
                    console.log("Error al cargar Colores");
                });                                                                                           
        },   
    },
    created() { 
      this.loadColores();                                         
      Fire.$on('AfterCreate',() => {
          this.loadColores();               
      }); 
    }
  }
</script>