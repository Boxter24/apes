<template>
    <v-container>
        <div class="foros contenido">
            <div class="titulo-seccion">
                Foros por Aprobar
            </div>      
            <v-card
                elevation="5"
                v-for="foro in foros"
                :key="foro.id"
                class="card-foro"
            >   
                <div class="titulos d-flex justify-space-between">
                    <v-card-title>{{foro.nombre_foro}}</v-card-title>
                    <div class="datos">
                        <p class="titulosDatos">Fecha de Publicación: {{foro.fecha_publicacion}}</p>
                        <p class="titulosDatos">Publicado por {{foro.name}}.</p>
                    </div>
                </div>                
                <v-card-text>{{foro.comentario_foro}}</v-card-text>                
                    <v-row
                        align="center"
                        justify="space-around"
                        class="contenedor-boton-comentar"
                        @click="aprobar(foro)"
                    >
                        <v-btn
                            tile
                            color="success"
                            class="comentar-foro"
                        >
                        <v-icon left>
                            mdi-check
                        </v-icon>
                            Aprobar
                        </v-btn>
                    </v-row>
            </v-card>
        </div>        
    </v-container>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                foros : [],                
                form: new Form({ 
                    id : '',  
                    nombre_foro : '',                    
                    comentario_foro : '',
                    id_usuario : '1',
                    estado : ''                                                                                               
                })
            }
        },        
        methods: { 
            aprobar(foro){
                this.form.reset();
                this.form.fill(foro);
                this.form.estado = 'activo';
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/foros/'+this.form.id)
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
            async loadForo(){                                               
                await axios.get("api/foros/hoy")
                    .then(response =>{
                        this.foros = response.data;
                    })
                    .catch(error=>{
                        this.foros = []
                    });                
            },                                              
        },
        created() {
            this.loadForo();            
            Fire.$on('AfterCreate',() => {
               this.loadForo();
            }); 
        }
    }
</script>