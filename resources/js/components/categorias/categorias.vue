<template>    
    <v-container class="pa-4 text-left">
        <div class="titulo-seccion">
            Lista de Categorias
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
            align="center"
            justify="center"
            v-else 
        >
            <template v-for="(categoria, i) in categorias">
                <v-col
                :key="i"
                cols="12"
                md="4"
                >
                <!-- cc = Carrera - Categoria -->
                <!-- Para buscar seccion por carrera y categoria -->
                <v-hover v-slot="{ hover }">
                    <router-link :to="`/secciones?cc=${id_carrera}-`+categoria.id">
                        <v-card
                        :elevation="hover ? 12 : 2"
                        :class="{ 'on-hover': hover }"
                        >
                            <v-img
                                :src="'img/categorias/'+categoria.foto"
                                height="225px"
                            >
                                <v-card-title class="text-h6 white--text">
                                <v-row
                                    class="fill-height flex-column"
                                    justify="space-between"
                                >                    
                                    <div>
                                    <p id="titulo-card" class="ma-0 text-body-1 font-weight-bold font-italic text-left">
                                        {{ categoria.nombre_categoria }}
                                    </p>
                                    <p id="text-card" class="text-caption font-weight-medium font-italic text-left">
                                        {{ categoria.descripcion_categoria }}
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
      categorias: [],
      loading: true,
      id_carrera: '',
      form: new Form({       
        nombre_categoria: '',                            
        descripcion_categoria: '',                    
        foto: '',       
      }),                  
      transparent: 'rgba(255, 255, 255, 0)',
    }),
    methods: {
        async loadCategoria(){                                           
            await axios.get('api/categorias')
                .then(response =>{                    
                    this.categorias = response.data;
                    this.loading = false;
                })
                .catch(error=>{
                    this.categorias = []
                });            
        },     
    },
    created() {
        this.id_carrera = this.$route.query.carrera;
        //console.log(this.id_carrera);
        this.loadCategoria();
        Fire.$on('AfterCreate',() => {
            this.loadCategoria();
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