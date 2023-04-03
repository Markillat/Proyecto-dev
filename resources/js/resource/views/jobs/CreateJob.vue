<template>
    <div class="col-md-12">
        <div class="card card-primary" style=" width: auto!important; margin: 0!important;">
            <div class="card-header bg-info">
                <h3 class="my-0">Registro de trabajo</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label for="title">Título:</label>
                        <input type="text" class="form-control" id="title" v-model="form.titulo">
                        <div v-if="errors.titulo" class="text-danger">{{ errors.titulo[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <textarea class="form-control" id="description" v-model="form.detalles"></textarea>
                        <div v-if="errors.detalles" class="text-danger">{{ errors.detalles[0] }}</div>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salario:</label>
                        <input type="number" class="form-control" id="salary" v-model="form.salario">
                        <div v-if="errors.salario" class="text-danger">{{ errors.salario[0] }}</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Crear trabajo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
    data() {
        return {
            form: {
                titulo: '',
                detalles: '',
                salario: ''
            },
            errors: {}
        }
    },
    methods: {
        async submitForm() {
            const token = JSON.parse(localStorage.getItem('access_token'));
            console.log(token)

            try {
                await axios.post('api/v1/workstations', this.form, {headers: {Authorization: `Bearer ${token}`}})
                    .then(response => response.data)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Correcto',
                            text: response.data,
                        })
                    })
                    .catch(error => {
                        console.log(error.response.data.error);
                        this.errors = error.response.data.error;
                        let text;

                        if (Object.keys(this.errors).length > 0) {
                            if (error.response.data.code === 403) {
                                text = error.response.data.error
                            } else {
                                text = "Completo los campos"
                            }
                        } else {
                            text = error.response.data.error
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: text
                        })
                    });
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>

<style>

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

input[type="text"], input[type="number"], textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
}
</style>
