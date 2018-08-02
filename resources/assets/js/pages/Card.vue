<template>
    <div>
        <card-header></card-header>
        <cards></cards>
        <card-footer></card-footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        created() {
        },
        methods: {

        },
        components: {
            CardHeader: require("../components/CardHeader"),
            Cards: require("../components/CardComponent"),
            CardFooter: require("../components/CardFooter"),
        }
    }
</script>