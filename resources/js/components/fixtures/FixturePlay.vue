<template>
    <div class="row">
        <div class="col-5"><h5>{{play.team_first.name}}</h5></div>
        <div class="col-2"><h5>-</h5></div>
        <div class="col-5"><h5>{{play.team_second.name}}</h5></div>
    </div>
</template>

<script>
    export default {
        props: ['play'],

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
