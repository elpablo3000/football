<template>
    <div class="card">
        <div class="card-header text-white bg-dark">
            <h4>
                Week {{ fixture.week_number }}
            </h4>
        </div>

        <div class="card-body">
            <div v-for="play in fixture.plays">
                <fixture-play
                    :play="play"
                    class="fixture-play">
                </fixture-play>
            </div>
        </div>
    </div>
</template>

<script>
    import FixturePlay from './FixturePlay.vue';

    export default {
        components: {
            FixturePlay,
        },

        props: ['fixture'],

        mounted() {
            console.log('Component mounted.');
        },
    };
</script>
