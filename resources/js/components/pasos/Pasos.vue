<template>
    <v-container>
        <div class="sinPasos" v-if="pasos.length == 0">No hay pasos para esta guía</div>
        <v-stepper non-linear vertical v-else>
            <div 
                class="step" v-for="(paso,i) in pasos"
                :key="paso.id"
            >
                <v-stepper-step
                    editable                                    
                    :step="`${i+1}`"
                >
                    {{paso.nombre_paso}}
                    <small>{{paso.descripcion_paso}}</small>
                </v-stepper-step>
                <v-stepper-content :step="`${i+1}`">
                    <v-card
                        color="grey lighten-1"
                        class="mb-12"
                        height="300px"
                    >
                        <v-img
                            :src="'img/pasos/'+paso.foto"
                            height="300px"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.2)"
                        >
                        </v-img>
                    </v-card>                                   
                </v-stepper-content>                               
            </div>
        </v-stepper>        
    </v-container>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                pasos : [],                
                form: new Form({ 
                    id : '',  
                    nombre_paso : '',                    
                    descripcion_paso : '',  
                    orden_paso : '',                                          
                    enlace_paso : '',  
                    id_guia : '',
                    foto : '',                                     
                }),
            }
        },        
        methods: {                                                                    
            async loadPaso(){                                               
                await axios.get("api/pasos/"+this.$route.query.guia)
                    .then(response =>{
                        this.pasos = response.data;
                        this.form.id_guia = this.$route.query.guia;
                    })
                    .catch(error=>{
                        this.pasos = []
                    });                
            },                                 
        },
        created() {
            this.loadPaso();            
            Fire.$on('AfterCreate',() => {
               this.loadPaso();
            }); 
        }
    }
</script>