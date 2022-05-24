<template>  
    <div class="container">
        <div class="titulo-seccion">
            Comentarios por Aprobar
        </div>                             
        <v-timeline
            dense
            clipped
        >    
            <v-timeline-item
                v-for="comentario in comentarios"
                :key="comentario.id"
                large                
            >
            <template v-slot:icon>
                <v-avatar>
                <img :src="'img/profile/'+comentario.foto">
                </v-avatar>
            </template>
            <template>
                <span>{{comentario.name}}</span>
            </template>
            <v-card class="elevation-2">
                <v-card-title class="text-h5">
                Respuesta a : {{comentario.nombre_foro}}    
                </v-card-title>
                <v-card-text>{{comentario.comentario}}</v-card-text>
                <v-row
                    align="center"
                    justify="space-around"
                    class="contenedor-boton-comentar"
                    @click="aprobar(comentario)"
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
            </v-timeline-item>
        </v-timeline>        
    </div>
</template>

<script>    
    export default {          
        data() {
            return {                
                editmode: false,
                foro : [],
                comentarios : [],                
                form: new Form({ 
                    id : '',
                    id_foro : this.$route.query.foro,
                    comentario : '',                                        
                    id_usuario : '',                   
                    fecha_comentario : '',   
                    estado : '',
                })
            }
        },        
        methods: { 
            aprobar(comentario){
                this.form.reset();
                this.form.fill(comentario);
                this.form.estado = 'activo';
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/comentarios/'+this.form.id)
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
            async loadComentario(){                                               
                await axios.get("api/comentarios/hoy")
                    .then(response =>{
                        this.comentarios = response.data;
                    })
                    .catch(error=>{
                        this.comentarios = []
                    });                
            },                                              
        },
        created() {
            this.loadComentario();                   
            Fire.$on('AfterCreate',() => {
               this.loadComentario();
            }); 
        }
    }
</script>