<template>
    <div class="col-md-12">
        <div class="card card-primary" style=" width: auto!important; margin: 0!important;">
            <div class="card-header bg-info d-flex justify-content-between">
                <h3 class="my-0">Lista de trabajos</h3>
            </div>
            <div class="card-body">
                <div class="row d-flex">
                    <div class="col-md-8">
                        <ListJobs @evento="clickEvent"></ListJobs>
                    </div>
                    <div class="col-md-4">
                        <DetailJob :record.sync="record"></DetailJob>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ListJobs from "./ListJobs.vue";
import DetailJob from "./DetailJob.vue";

export default {
    data() {
        return {
            token_response: null,
            activeTab: '1',
            record: null,
            showModal: false
        }
    },
    components: {
        ListJobs, DetailJob
    },
    methods: {
        clickEvent(event) {
            console.log(event)
            this.record = event;
        }
    }
}
</script>

<style scoped>

</style>
