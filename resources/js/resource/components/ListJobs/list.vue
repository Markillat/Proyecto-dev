<template>
    <div class="col-md-12">
        <div class="card-columns">
            <card v-for="item in paginatedItems" :key="item.identificador" :title="item.titulo" :description="item.detalles" @click="showCard(item)"/>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <a class="page-link" href="#" @click.prevent="currentPage--">Anterior</a>
                </li>
                <li class="page-item" v-for="pageNumber in numberOfPages" :key="pageNumber" :class="{ active: pageNumber === currentPage }">
                    <a class="page-link" href="#" @click.prevent="currentPage = pageNumber">{{ pageNumber }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === numberOfPages }">
                    <a class="page-link" href="#" @click.prevent="currentPage++">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import Card from './card.vue';

export default {
    components: {
        Card
    },
    props: {
        items: {
            type: Array,
            required: true
        },
        pageSize: {
            type: Number,
            default: 3
        }
    },
    data() {
        return {
            currentPage: 1
        }
    },
    computed: {
        numberOfPages() {
            return Math.ceil(this.items.length / this.pageSize);
        },
        paginatedItems() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            return this.items.slice(startIndex, endIndex);
        }
    },
    methods: {
        showCard(item) {
           this.$emit('itemEvent', item)
        }
    }
}
</script>
