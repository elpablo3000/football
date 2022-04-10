<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>Generated Fixtures</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mb-4" v-for="(fixture, index) in fixtures" :key="index">
                <fixture
                    :fixture="fixture"
                    class="fixture">
                </fixture>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <router-link :to="{ name: 'Tournament', params: { week: 0 } }" class="btn btn-lg btn-dark">Start Simulation</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import Fixture from './Fixture.vue';

export default {
    // props: ['teams'],
    components: {
        Fixture,
    },

    data: function () {
        return {
            fixtures: [],
        };
    },

    methods: {
        getFixtures() {
            axios.get('api/fixtures')
                .then(response => {
                    this.fixtures = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },

    mounted() {
        console.log('Component mounted.');
    },

    created() {
        this.getFixtures();
    },
};
</script>
