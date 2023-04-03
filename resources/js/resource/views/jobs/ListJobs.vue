<template>
    <div class="col-md-12">
        <list :items="items" :page-size="4" @itemEvent="clickItemEvent"/>
    </div>
</template>

<script>
import List from "../../components/ListJobs/list.vue";
import Swal from 'sweetalert2'

export default {
    components: {
        List
    },
    data() {
        return {
            items: []
        }
    },
    mounted() {
        this.getItems()
    },
    methods: {
        clickItemEvent(data) {
            this.$emit('evento', data)
        },
        async getItems() {
            const token = JSON.parse(localStorage.getItem('access_token'));

            console.info(token)

            try {
                await axios.get('api/v1/workstations', {headers: {Authorization: `Bearer ${token}`}})
                    .then(response => response.data)
                    .then(response => {
                        this.items = response.data
                    })
                    .catch(error => {
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
