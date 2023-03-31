<template>
    <div class="col-md-12">
        <div class="job-detail">
            <h2>{{ job.titulo }}</h2>
            <p>{{ job.detalles }}</p>
            <p>Salary: {{ job.salario }}</p>
            <button @click="applyForJob">Aplicar a este trabajo</button>
        </div>

        <!-- Modal -->
        <div class="modal" v-if="showModal">
            <div class="modal-content">
                <div class="justify-content-between d-flex">
                    <h5>Postulación del empleo</h5>
                    <span class="close" @click="showModal = false">&times;</span>
                </div>

                <form autocomplete="off" @submit.prevent="submit">
                    <label for="cv">Subir CV:</label>
                    <br>
                    <input id="cv" type="file" @change="handleFileUpload">
                    <br>
                    <br>
                    <label for="description">Mensaje:</label>
                    <textarea id="description" v-model="form.message"></textarea>
                    <button type="primary" native-type="submit" class="btn btn-primary" style="margin: 6px;">Enviar
                    </button>
                    <button @click="showModal = false" class="btn btn-danger">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import Swal from "sweetalert2";

export default {
    props: ['record'],
    data() {
        return {
            job: {},
            showModal: false,
            form: {
                load_cv: null,
                message: null
            }
        }
    },
    watch: {
        record: function (value) {
            if (value) {
                this.job = this.record;
            }
        }
    },
    mounted() {
        this.fetchJob()
    },
    methods: {
        fetchJob() {
            this.job = {
                identificador: 1,
                titulo: 'Trabajo de prueba',
                detalles: 'Descripción del trabajo de prueba',
                publicacion: '2022-04-01',
                salario: 1000
            }
        },
        applyForJob() {
            this.showModal = true;
        },
        async submit() {
            const token = JSON.parse(localStorage.getItem('access_token'));
            console.log(token)

            try {
                if (this.form.message) {
                    Swal.fire({
                        icon: 'succress',
                        title: 'Correcto',
                        text: 'Te postulaste correctamente',
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incompletos',
                        text: 'Completa los datos requeridos',
                    })
                }

            } catch (e) {
                console.log(e)
            }
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append('pdf', file);
        }
    }
};
</script>


<style scoped>
.job-detail {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
}

.job-detail h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.job-detail p {
    font-size: 18px;
    margin-bottom: 10px;
}

.job-detail button {
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 10px;
}

/* Estilos del modal */
.modal {
    display: block;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}

/* Estilos del contenido del modal */
.modal-content {
    background-color: white;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

/* Estilos del botón de cerrar */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
