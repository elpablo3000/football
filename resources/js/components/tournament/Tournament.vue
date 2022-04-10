<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>Simulation</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th><h3>Team Name</h3></th>
                        <th><h3>P</h3></th>
                        <th><h3>W</h3></th>
                        <th><h3>D</h3></th>
                        <th><h3>L</h3></th>
                        <th><h3>GD</h3></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="team"><h4>
                            Birdies
                        </h4></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-3">
                <div class="row">
<!--                    <div class="col-4 mb-4" v-for="(fixture, index) in fixtures" :key="index">-->
<!--                        <fixture-->
<!--                            :fixture="fixture"-->
<!--                            class="fixture">-->
<!--                        </fixture>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="col-3">
                Predictions
            </div>
            <!--            <div class="col-4 mb-4" v-for="(fixture, index) in fixtures" :key="index">-->
            <!--                <fixture-->
            <!--                    :fixture="fixture"-->
            <!--                    class="fixture">-->
            <!--                </fixture>-->
            <!--            </div>-->
        </div>
        <div class="row">
            <!--            <div class="col-12">-->
            <!--                <router-link :to="{ name: 'Fixtures' }" class="btn btn-lg btn-dark">Display Item</router-link>-->
            <!--            </div>-->
        </div>
    </div>
</template>

<script>
// import Fixture from './Fixture.vue';

export default {
    // props: ['teams'],
    // components: {
    //     Fixture,
    // },

    // data: function () {
    //     return {
    //         fixtures: [],
    //     };
    // },

    methods: {
        // getFixtures() {
        //     axios.get('api/fixtures')
        //         .then(response => {
        //             this.fixtures = response.data;
        //         })
        //         .catch(error => {
        //             console.log(error);
        //         });
        // },
    },

    mounted() {
        console.log('Component mounted.');
    },

    created() {
        // this.getFixtures();
    },
};
</script>
