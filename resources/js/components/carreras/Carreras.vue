<template>
  <v-container class="pa-4 text-left">  
    <div class="titulo-seccion">
      Lista de carreras
    </div>   
    <v-row             
      align="center" 
      justify="center" 
      v-if="loading"
      class="loading"
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
      v-else
    >       
      <template v-for="(carrera, i) in carreras">        
        <v-col          
          :key="i"
          cols="12"
          md="4"          
        >
          <v-hover v-slot="{ hover }">
            <router-link :to="`/categorias?carrera=${carrera.id}`">
              <v-card
                :elevation="hover ? 12 : 2"
                :class="{ 'on-hover': hover }"
              >
                <v-img
                  :src="'img/carreras/'+carrera.foto"
                  height="225px"
                >
                  <v-card-title class="text-h6 white--text">
                    <v-row
                      class="fill-height flex-column"
                      
                    >                    
                      <div>
                        <p id="titulo-card" class="ma-0 text-body-1 font-weight-bold font-italic text-left">
                          {{ carrera.nombre_carrera }}
                        </p>
                        <p id="text-card" class="text-card text-caption font-weight-medium font-italic text-left">
                          {{ carrera.descripcion_carrera }}
                        </p>
                      </div>                    
                    </v-row>
                  </v-card-title>
                </v-img>
              </v-card>
            </router-link>
          </v-hover>
        </v-col>
      </template>
    </v-row>
  </v-container>
</template>
<script>
export default {
   data: () => ({
      carreras: [],
      loading: true,
      form: new Form({       
        nombre_carrera: '',                            
        descripcion_carrera: '',                    
        foto: '',       
      }),                  
      transparent: 'rgba(255, 255, 255, 0)',
      //nombre_facultad: ''
    }),
    methods: {
        async loadCarrera(){                                           
          await axios.get('api/carreras/'+this.$route.query.facultad)
            .then(response =>{                
                this.carreras = response.data;
                this.loading = false;
            })
            .catch(error=>{
                this.carreras = []
            });            
        },     
    },
    created() {       
      //console.log(this.$route.query.facultad);
      this.loadCarrera();       
      Fire.$on('AfterCreate',() => {
            this.loadCarrera();
        });
    }
}
</script>

<style scoped>
.v-card {
  transition: opacity .4s ease-in-out;
}

.v-card:not(.on-hover) {
  opacity: 0.6;
 }

.show-btns {
  color: rgba(255, 255, 255, 1) !important;
}
</style>