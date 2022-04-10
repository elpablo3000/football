<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>Tournament Teams</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th>
                            <h3>Team Name</h3>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(team, index) in teams" :key="index">
                        <team
                            :team="team"
                            class="team">
                        </team>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <router-link :to="{ name: 'Fixtures' }" class="btn btn-lg btn-dark">Generate Fixtures</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import Team from './Team.vue';

export default {
    components: {
        Team,
    },

    data: function () {
        return {
            teams: [],
        };
    },

    methods: {
        getTeams() {
            axios.get('api/teams')
                .then(response => {
                    this.teams = response.data;
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
        this.getTeams();
    },
};
</script>
