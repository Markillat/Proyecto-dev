<template>
    <form>
        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" v-model="job.title" />
        </div>
        <div>
            <label for="description">Descripción:</label>
            <textarea id="description" v-model="job.description"></textarea>
        </div>
        <div>
            <label for="salary">Sueldo:</label>
            <input type="number" id="salary" v-model="job.salary" />
        </div>
        <button type="submit" @click.prevent="submitJob">Enviar</button>
    </form>
</template>

<script>
export default {
    name: "JobForm",
    data() {
        return {
            job: {
                title: '',
                description: '',
                salary: 0,
            },
        };
    },
    methods: {
        submitJob() {
            console.log('Trabajo registrado:', this.job);
            // Aquí puedes enviar la información del trabajo a través de una API o almacenarla en una base de datos
        },
    },
}
</script>

<style scoped>

</style>
