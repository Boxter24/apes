<template>    
    <v-container fluid class="pa-6 text-left" style="padding-bottom: 5em!important">
        <div class="titulo-seccion">
            Lista de Secciones
        </div>
        <v-row     
            class="loading"        
            align="center" 
            justify="center" 
            v-if="loading"
        >
            <v-col
                cols="12"
                md="4"      
                align="center"
                justify="center"            
                class="fill-height"
            >                
                <v-progress-circular
                    :size="60"
                    color="primary"
                    indeterminate
                ></v-progress-circular><br>
                <Strong>Cargando...</Strong>
            </v-col>              
        </v-row>    
        <v-row
            class="contenido fill-height"
            align="center"
            justify="center"
            v-else 
        >
            <template v-for="(seccion, i) in secciones">
                <v-col
                    :key="i"
                    cols="12"                                        
                >
                <v-hover class="hover" v-slot="{ hover }">                    
                    <v-card
                        :elevation="hover ? 12 : 2"
                        :class="{ 'on-hover': hover }" 
                        class="d-flex pa-2"
                        outlined
                        tile                                                                  
                    >           
                        <v-img
                            class="escalar white--text align-end"
                            width="30%"
                            height="200px"
                            :src="'img/secciones/'+seccion.foto"
                        >                            
                        </v-img>
                        
                        <div class="info">
                            <v-card-title>{{seccion.nombre_seccion}}</v-card-title>
                            <v-divider></v-divider>
                            
                            <!--<v-card-subtitle class="pb-0">
                                Number 10
                            </v-card-subtitle>-->

                            <v-card-text class="text--primary">
                                <!--<div>Whitehaven Beach</div>-->

                                <div>{{seccion.descripcion_seccion}}</div>
                                <span v-if="seccion.enlace_seccion"><a target="_blank" :href="seccion.enlace_seccion">Ver más...</a></span>
                            </v-card-text> 
                        </div>                                                  
                    </v-card>                    
                </v-hover>
                </v-col>
            </template>
        </v-row>
    </v-container>
</template>
<script>
export default {
   data: () => ({
      secciones: [],
      loading: true,
      carrera: '',
      categoria: '',
      form: new Form({       
        nombre_seccion: '',                            
        descripcion_seccion: '',  
        id_carrera: '',
        id_categoria: '', 
        enlace_seccion: '',                  
        foto: '',       
      }),                  
      transparent: 'rgba(255, 255, 255, 0)',
    }),
    methods: {
        async loadSeccion(){                                           
            await axios.get(`api/secciones/`+this.$route.query.cc)
                .then(response =>{                    
                    this.secciones = response.data;
                    this.loading = false;
                })
                .catch(error=>{
                    this.secciones = []
                });            
        },     
    },
    created() {
        //Dividir el parametro de query en carrera y categoria
        //console.log(this.$route.query.cc);
        //this.carrera = this.$route.query.cc.slice(0,1);
        //console.log(this.carrera);
        //this.categoria = this.$route.query.cc.slice(1,2);
        //console.log(this.categoria);
        this.loadSeccion();
        Fire.$on('AfterCreate',() => {
            this.loadSeccion();
        }); 
    }
}
</script>

<style scoped lang="css">    
    .v-card {             
        box-shadow: 0 4px 15px 0 rgba(45, 54, 65, 0.75);
    }

    .v-card:not(.on-hover) {     
        transition: all .2s ease-in-out;           
        box-shadow: none;
    }

    .show-btns {
        color: rgba(255, 255, 255, 1) !important;  
    }
    
    .v-application .info {
        background-color: #ffffff !important;        
    }    

</style>