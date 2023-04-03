<template>
    <div class="col-md-12">
        <div class="card card-primary" style=" width: auto!important; margin: 0!important;">
            <div class="card-header bg-info">
                <h3 class="my-0">Lista de postulaciones</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" v-show="!isAdmin">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Empresa</th>
                            <th>Mensaje</th>
                            <th>CV</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(row, index) in postulations" :key="index">
                            <td>{{ index }}</td>
                            <td class="text-center">{{ row.trabajoPostulado }}</td>
                            <td class="text-center">{{ row.mensaje }}</td>
                            <td class="text-center">{{ row.cv }}</td>
                            <td class="text-center">{{ row.estado }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                <a class="page-link" href="#" @click.prevent="getApplicants(currentPage--)">Anterior</a>
                            </li>
                            <li class="page-item" v-for="pageNumber in numberOfPages" :key="pageNumber"
                                :class="{ active: pageNumber === currentPage }">
                                <a class="page-link" href="#" @click.prevent="getApplicants(currentPage = pageNumber)">{{
                                        pageNumber
                                    }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: currentPage === numberOfPages }">
                                <a class="page-link" href="#"
                                   @click.prevent="getApplicants(currentPage++)">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
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
            postulations: [],
            currentPage: 1,
            pageSize: 4,
            isAdmin: false
        }
    },
    computed: {
        numberOfPages() {
            return Math.ceil(this.postulations.length / this.pageSize);
        },
        paginatedItems() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            return this.postulations.slice(startIndex, endIndex);
        }
    },
    mounted() {
        this.getApplicants();
        this.isAdmin = localStorage.getItem('isAdmin') === '1';
    },
    methods: {
        async getApplicants() {
            const token = JSON.parse(localStorage.getItem('access_token'));

            console.log(token)

            try {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                await axios.get('api/v1/applications' + `?page=${this.currentPage}`)
                    .then(response => response.data)
                    .then(response => {

                        this.postulations = response.data;
                        this.lastPage = response.data.meta.last_page;
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
        },
    }
}
</script>
