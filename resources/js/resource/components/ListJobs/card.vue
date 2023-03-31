<template>
    <div class="card">
        <img :src="imageUrl" alt="">
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ description }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        imageUrl: String,
        title: String,
        description: String
    }
}
</script>

<style>
.card {
    width: 18rem;
    margin: 1rem;
}
.card-img-top {
    height: 10rem;
    object-fit: cover;
}
</style>
