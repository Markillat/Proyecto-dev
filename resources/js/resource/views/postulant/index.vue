<template>
    <div class="col-md-12">
        <div class="card card-primary" style=" width: auto!important; margin: 0!important;">
            <div class="card-header bg-info">
                <h3 class="my-0">Lista de postulaciones</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th>CV</th>
                            <th>Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in postulaciones" @click="edit(item, type)">
                                <td>{{ index }}</td>
                                <td class="text-center">{{ row.nombreCompleto }}</td>
                                <td class="text-center">{{ row.celular }}</td>
                                <td class="text-center">{{ row.cv }}</td>
                                <td class="text-center">
                                    <button @click="eliminarPostulacion(row.identificador)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
    data() {
        return {
            resource: '',
            postulaciones: [
                {
                    identificador: 1,
                    nombreCompleto: 'Desarrollador Fullstack',
                    celular: 'Se busca desarrollador Fullstack con experiencia en Vue y Laravel',
                    cv: '25/03/2023'
                },
                {
                    identificador: 2,
                    nombreCompleto: 'Diseñador gráfico',
                    celular: 'Se busca diseñador gráfico para trabajar en una agencia de publicidad',
                    cv: '28/03/2023'
                },
                {
                    identificador: 3,
                    nombreCompleto: 'Marketing Digital',
                    celular: 'Se busca especialista en Marketing Digital con experiencia en Google AdWords',
                    cv: '30/03/2023'
                }
            ]
        }
    },
    mounted() {
        this.getItems();
    },
    methods: {
        eliminarPostulacion(id) {
            // Eliminar postulación
            const index = this.postulaciones.findIndex(p => p.id === id)
            this.postulaciones.splice(index, 1)
        },
        edit() {},
        async getItems() {
            const token = JSON.parse(localStorage.getItem('access_token'));

            console.log(token)

            try {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                await axios.get('api/v1/applications')
                    .then(response => response.data)
                    .then(response => {
                        console.log(response)
                        this.postulaciones = response.data
                    })
                    .catch(error => {
                        console.log(error.response.data.error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response.data.error,
                        })
                    });
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>
