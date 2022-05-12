<template>
    <v-container class="pa-4 text-left">   
        <div class="titulo-seccion">
            Lista de Facultades
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
        >               
            <template v-for="(facultad, i) in facultades">
                <v-col
                    :key="i"
                    cols="12"
                    md="4"
                >
                <v-hover v-slot="{ hover }">
                    <router-link :to="`/carreras?facultad=${facultad.id}`">
                        <v-card
                            :elevation="hover ? 12 : 2"
                            :class="{ 'on-hover': hover }"
                        >
                            <v-img
                                :src="'img/facultades/'+facultad.foto"
                                height="225px"
                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.2)"
                            >
                                <v-card-title class="text-h6 white--text">
                                <v-row
                                    class="fill-height flex-column"
                                    
                                >                    
                                    <div>
                                    <p id="titulo-card" class="ma-0 text-body-1 font-weight-bold font-italic text-left">
                                        {{ facultad.nombre_facultad }}
                                    </p>
                                    <p id="text-card" class="text-caption font-weight-medium font-italic text-left">
                                        {{ facultad.descripcion_facultad }}
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
      facultades: [],
      loading: true,
      form: new Form({       
        nombre_facultad: '',                            
        descripcion_facultad: '',                    
        foto: '',       
      }),                  
      transparent: 'rgba(255, 255, 255, 0)',
      attrs: {
        class: 'mb-6',
        boilerplate: true,
        elevation: 2,
      },
    }),
    methods: {
        async loadFacultad(){                                           
            await axios.get("api/facultades")
                .then(response =>{
                    this.loading = false;
                    this.facultades = response.data;
                })
                .catch(error=>{
                    this.facultades = []
                });            
        },     
    },
    created() {
        this.loadFacultad();
        Fire.$on('AfterCreate',() => {
            this.loadFacultad();
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