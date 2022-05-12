<template>
  <v-carousel 
    :show-arrows="false" 
    cycle
    style="margin-top: 3em;"
  >            
    <v-carousel-item
        v-for="(imagen,i) in imagenes"
        :key="i"
        :src="'img/carrusel/'+imagen.foto"                                       
    ></v-carousel-item>   
  </v-carousel>   
</template>

<script>
  export default {
    data () {
      return {
        imagenes : [],
        form: new Form({
          id : '',                     
          foto : '',                              
        }),                        
      }
    },
    methods:{
      async loadImagenes(){                                                  
        await axios.get("api/carrusel")
          .then(response =>{            
              this.imagenes = response.data;
          })
          .catch(error=>{
              this.imagenes = []
          });                
      },         
    },
    created() {        
      this.loadImagenes();
      Fire.$on('AfterCreate',() => {
          this.loadImagenes();
      }); 
    } 
  }
</script>