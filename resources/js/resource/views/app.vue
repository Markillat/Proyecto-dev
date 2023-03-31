<template>
    <div class="col-md-12" v-if="isParentReady">
        <div v-if="tab === 'first'">
            <Jobs/>
        </div>
        <div v-else-if="tab === 'second'">
            <Postulant/>
        </div>
        <div v-else>
            <createJob/>
        </div>
    </div>
</template>

<script>

import Jobs from "./jobs/index.vue";
import Postulant from "./postulant/index.vue";
import createJob from "./jobs/CreateJob.vue";

export default {
    name: "app",
    props: ['dataArray', 'tab'],
    data() {
        return {
            token_response: null,
            activeTab: '1',
            form: {
                email: 'jquilca@gmail.com',
                password: 'password123'
            },
            isParentReady: false,
        }
    },
    components: {
        Jobs,
        Postulant,
        createJob
    },
    async mounted() {
        setTimeout(() => {
            this.isParentReady = true;
            this.token_response = JSON.parse(this.dataArray);
            this.saveToken(this.token_response.access_token);
        }, 2000);

        await this.getTokeClient();
    },
    methods: {
        async saveToken(token) {
            localStorage.setItem('access_token', JSON.stringify(token));
            localStorage.setItem('client_data', JSON.stringify(this.token_response));
        },
        getTokenStorage() {
            this.token_response = JSON.parse(localStorage.getItem('client_data'));
        },
        async getTokeClient() {

            this.getTokenStorage();

            const clientId = this.token_response.client_id ?? null;
            const clientSecret = this.token_response.client_secret ?? null;

            console.log('this.token_response', this.token_response)

            await axios.post('api/v1/oauth/token', {
                grant_type: 'password',
                client_id: clientId,
                client_secret: clientSecret,
                username: this.form.email,
                password: this.form.password,
                scope: 'read-jobs read-postulations',
            })
                .then(response => {
                    console.log('response', response);
                    const token = response.data.access_token;
                    this.saveToken(token);
                });
        },
        removeToken() {
            localStorage.removeItem('access_token');
        }
    }
}
</script>

<style scoped>

</style>
