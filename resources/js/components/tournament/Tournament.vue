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
                    <team-summary v-for="(summary, index) in summaries" :key="index"
                                  :summary="summary"
                                  class="team">
                    </team-summary>
                    </tbody>
                </table>
            </div>
            <div class="col-3">
                <div class="mb-4" v-for="(fixture, index) in fixtures" :key="index">
                    <fixture
                        :fixture="fixture"
                        class="fixture">
                    </fixture>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header text-white bg-dark">
                        <h4>
                            Championship Predictions
                        </h4>
                    </div>

                    <div class="card-body">
                        <prediction v-for="(summary, index) in summaries" :key="index"
                                    :summary="summary"
                                    class="team">
                        </prediction>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="btn btn-lg btn-dark" @click="switchToNextWeek()" id="playNext" ref="playNext">Play Next Week</div>
            </div>
            <div class="col-6">
                <div class="btn btn-lg btn-danger" @click="resetAllGames()">Reset Data</div>
            </div>
        </div>
    </div>
</template>

<script>
import TeamSummary from './TeamSummary.vue';
import Fixture from '../fixtures/Fixture.vue';
import Prediction from './Prediction';

export default {
    components: {
        Prediction,
        TeamSummary,
        Fixture,
    },

    data: function () {
        return {
            summaries: [],
            fixtures: [],
            week: 0,
            nextWeek: 0,
            isLast : false,
        };
    },

    methods: {
        getWeekResults() {
            axios.get('/api/tournament/' + this.$route.params.week)
                .then(response => {
                    this.summaries = response.data.summaries;
                    this.fixtures = response.data.fixtures;
                    this.week = this.$route.params.week;
                    this.nextWeek = parseInt(this.$route.params.week) + 1;
                    this.isLast = response.data.is_last
                    this.$forceUpdate();

                    if (this.isLast) {
                        this.$refs.playNext.classList.add('disabled');
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        switchToNextWeek() {
            if (!this.isLast) {
                this.$router.replace('/tournament/' + this.nextWeek);
                this.getWeekResults();
            }
        },
        resetAllGames() {
            axios.post('/api/reset/')
                .then(response => {
                    this.$router.push({name: 'Teams'});
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
        this.getWeekResults();
    },
};
</script>
