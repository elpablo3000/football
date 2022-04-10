<template>
    <tr>
        <td>
            <h4>
                {{summary.team.name}}
            </h4>
        </td>
        <td>
            <h4>
                {{summary.played}}
            </h4>
        </td>
        <td>
            <h4>
                {{summary.won}}
            </h4>
        </td>
        <td>
            <h4>
                {{summary.drawn}}
            </h4>
        </td>
        <td>
            <h4>
                {{summary.loosed}}
            </h4>
        </td>
        <td>
            <h4>
                {{summary.goal_difference}}
            </h4>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['summary'],

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
