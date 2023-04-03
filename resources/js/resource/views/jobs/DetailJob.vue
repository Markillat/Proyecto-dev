<template>
    <div class="col-md-12">
        <div class="job-detail" v-show="record">
            <h2>{{ job.titulo }}</h2>
            <p>{{ job.detalles }}</p>
            <p>Salario: {{ job.salario }}</p>
            <p v-if="isAdmin">Cantidad postulantes: {{ job.cantidadPostulantes }}</p>
            <p v-if="isAdmin">Postulantes:</p>
            <ul v-if="isAdmin">
                <li v-for="(postulante, index) in job.postulantes" :key="index">{{ postulante.nombre }}</li>
            </ul>
            <button v-if="!isAdmin" @click="applyForJob">Aplicar a este trabajo</button>
        </div>

        <!-- Modal -->
        <div class="modal" v-if="showModal">
            <div class="modal-content">
                <div class="justify-content-between d-flex">
                    <h5>Postulación del empleo</h5>
                    <span class="close" @click="close">&times;</span>
                </div>

                <form autocomplete="off" @submit.prevent="submit">
                    <label for="cv">Subir CV:</label>
                    <br>
                    <input id="cv" type="file" ref="file" @change="handleFileUpload">
                    <div v-if="errors.cv" class="text-danger">{{ errors.cv[0] }}</div>
                    <br>
                    <br>
                    <label for="description">Mensaje:</label>
                    <textarea id="description" v-model="form.message"></textarea>
                    <div v-if="errors.mensaje" class="text-danger">{{ errors.mensaje[0] }}</div>
                    <button type="primary" native-type="submit" class="btn btn-primary" style="margin: 6px;">Enviar
                    </button>
                    <button @click="close" class="btn btn-danger">Cerrar</button>
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
            },
            errors: {},
            isAdmin: false
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
        this.isAdmin = localStorage.getItem('isAdmin') === '1';
    },
    methods: {
        applyForJob() {
            this.showModal = true;
        },
        async submit() {
            const token = JSON.parse(localStorage.getItem('access_token'));

            const formData = new FormData();
            formData.append('cv', this.$refs.file.files[0]);
            formData.append('trabajo', this.job.identificador);
            formData.append('mensaje', this.form.message);

            try {
                await axios.post('api/v1/applications', formData, {headers: {Authorization: `Bearer ${token}`, 'Content-Type': 'multipart/form-data'}})
                    .then(response => response.data)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Correcto',
                            text: response.data.message,
                        })
                    })
                    .catch(error => {
                        console.log(error.response.data.error);
                        this.errors = error.response.data.error;
                    });
            } catch (e) {
                console.log(e)
            }
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append('pdf', file);
        },
        initForm() {
            this.form = {
                load_cv: null,
                message: null
            }
            this.errors = {}
        },
        close() {
            this.showModal = false;
            this.initForm();
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

.job-detail {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.job-detail h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.job-detail p {
    font-size: 16px;
    margin-bottom: 10px;
}

.job-detail button {
    background-color: #0066cc;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
}

.job-detail button:hover {
    background-color: #0052a3;
}
</style>
