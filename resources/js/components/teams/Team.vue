<template>
    <td>
        <h4>
            {{team.name}}
        </h4>
    </td>
</template>

<script>
    export default {
        props: ['team'],

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
