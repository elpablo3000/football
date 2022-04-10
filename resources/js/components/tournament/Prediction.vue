<template>
    <div class="row">
        <div class="col-8"><h5>{{summary.team.name}}</h5></div>
        <div class="col-4"><h5>{{summary.predictions}}</h5></div>
    </div>
</template>

<script>
export default {
    props: ['summary'],

    mounted() {
        console.log('Component mounted.')
    }
}
</script>
