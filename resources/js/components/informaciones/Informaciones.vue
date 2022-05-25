<template>  
    <v-container class="contenido">
        <v-row fill-height class="d-block d-sm-flex d-md-flex d-lg-flex d-xl-flex">
            <!-- Operador Ternario para Columnas -->
            <v-col
                v-for="(informacion,i) in informaciones"
                :key="i"
                cols="12"   
                :md="i == 0 ? 12:6"                
                :sm="i == 0 ? 12:12"         
            >
                <v-card 
                    style="background: linear-gradient(329deg,#fff,#e1dbdb);"
                    v-if="informacion.foto != null && i<=5" 
                    class="my-1 mx-auto overflow-auto"
                >
                    <v-img
                        v-if="i == 0"                
                        :src="'img/informaciones/'+informacion.foto"
                        class="white--text align-end"
                        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                        height="400px"
                    >
                        <v-card-title v-text="informacion.nombre_informacion"></v-card-title>
                    </v-img>
                    <v-img
                        v-else               
                        :src="'img/informaciones/'+informacion.foto"
                        class="white--text align-end"
                        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                        height="200px"
                    >
                        <v-card-title v-text="informacion.nombre_informacion"></v-card-title>
                    </v-img>

                    <v-card-actions class="text-justify">
                        {{informacion.descripcion_informacion}}
                    </v-card-actions>
                    <span v-if="informacion.enlace_informacion"><a target="_blank" :href="informacion.enlace_informacion">Ver más...</a></span>
                </v-card>
                <v-card
                    v-if="informacion.foto == null && i<=5"
                    class="my-1 mx-auto overflow-auto"                   
                    height="200"                                                                                      
                    style="background: linear-gradient(329deg,#fff,#e1dbdb);"
                >
                    <v-card-text>                    
                        <p class="text--primary text-md-center" style="font-weight: bold; font-size: 150%">
                            {{informacion.nombre_informacion}}
                        </p>                    
                        <div class="text--primary text-md-left mb-4" style="font-size: 100%;">
                            <p class="text-justify">{{informacion.descripcion_informacion}}</p>
                        </div>
                    </v-card-text>
                    <div class="boton">
                        <v-card-actions>
                            <v-btn
                                text
                                color="deep-purple accent-4"
                            >
                                <span v-if="informacion.enlace_informacion"><a target="_blank" :href="informacion.enlace_informacion">Ver más...</a></span>
                            </v-btn>
                        </v-card-actions>
                    </div>
                </v-card>

            </v-col>
        </v-row>
    </v-container>  
</template>

<script>

    export default {
        data: () => ({            
            informaciones : [],             
        }),
        methods: {
            async loadInformacion(){                                               
                await axios.get("api/informaciones")
                    .then(response =>{
                        this.informaciones = response.data;                        
                    })
                    .catch(error=>{
                        this.informaciones = []
                    });                
            }, 
        },        
        
        created() {
            this.loadInformacion();
            Fire.$on('AfterCreate',() => {
               this.loadInformacion();
            }); 
        }
    }
</script>