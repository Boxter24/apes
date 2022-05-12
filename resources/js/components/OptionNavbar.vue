<template>
  <v-row justify="space-around">    
    <v-menu
      transition="slide-x-transition"
      bottom
      right
    >
      <template v-slot:activator="{ on, attrs }">                  
          <span 
            class="option-input"
            v-bind="attrs"
            v-on="on"
          >
            Facultades
          </span>          
      </template>
      <v-list>
        <v-list-item
          v-for="(facultad, i) in facultades"
          :key="i"
        >
          <v-list-item-title><router-link :to="`/carreras?facultad=${facultad.id}`">{{ facultad.nombre_facultad }}</router-link></v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>    
  </v-row>
</template>
<script>
  export default {
    data: () => ({
      facultades: [],        
      form: new Form({       
        nombre_facultad: '',                            
        descripcion_facultad: '',                    
        foto: '',       
      }),                          
    }),
    methods: {
      async loadFacultad(){                                           
        await axios.get("api/facultades")
          .then(response =>{                    
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