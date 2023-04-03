<template>
    <div class="col-md-12" v-if="isParentReady">
        <div v-if="tab === 'first'">
            <Jobs />
        </div>
        <div v-else-if="tab === 'second'">
            <Postulant />
        </div>
        <div v-else>
            <createJob />
        </div>
    </div>
</template>

<script>

import Jobs from "./jobs/index.vue";
import Postulant from "./postulant/index.vue";
import createJob from "./jobs/CreateJob.vue";

export default {
    name: "app",
    props: ['accessToken', 'tab', 'isAdmin'],
    data() {
        return {
            token_response: null,
            activeTab: '1',
            isParentReady: false,
        }
    },
    components: {
        Jobs,
        Postulant,
        createJob
    },
    async mounted() {
        if (this.accessToken) {
            this.removeToken();
            await this.saveToken(this.accessToken);
            this.saveRole();
            this.isParentReady = true;
        }
    },
    methods: {
        async saveToken(token) {
            localStorage.setItem('access_token', token);
        },
        saveRole() {
            localStorage.removeItem('isAdmin');
            localStorage.setItem('isAdmin', this.isAdmin);
        },
        removeToken() {
            localStorage.removeItem('access_token');
        }
    }
}
</script>

<style scoped>

</style>
