<template>
  <v-container class="pa-4 text-left">
    <v-row
      class="fill-height"
      
    >
      <template v-for="(categoria, i) in categorias">
        <v-col
          :key="i"
          cols="12"
          md="4"
        >
          <v-hover v-slot="{ hover }">
            <v-card
              :elevation="hover ? 12 : 2"
              :class="{ 'on-hover': hover }"
            >
              <v-img
                :src="'img/user-cover.jpg'"
                height="225px"
              >
                <v-card-title class="text-h6 white--text">
                  <v-row
                    class="fill-height flex-column"
                    
                  >                    
                    <div>
                      <p class="ma-0 text-body-1 font-weight-bold font-italic text-left">
                        {{ categoria.nombre_categoria }}
                      </p>
                      <p class="text-caption font-weight-medium font-italic text-left">
                        {{ categoria.descripcion_categoria }}
                      </p>
                    </div>                    
                  </v-row>
                </v-card-title>
              </v-img>
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
      categorias: [],
      form: new Form({       
        nombre_categoria: '',                            
        descripcion_categoria: '',                    
        foto: '',       
      }),                  
      transparent: 'rgba(255, 255, 255, 0)',
    }),
    methods: {
        async loadCategoria(){                                           
            await axios.get("api/categorias")
                .then(response =>{
                    this.categorias = response.data;
                })
                .catch(error=>{
                    this.categorias = []
                });            
        },     
    },
    created() {
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