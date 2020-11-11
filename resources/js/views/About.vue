<template>
    <div>
        <page-title title="About"> </page-title>
    </div>
</template>

<script>
    export default {
        created() {
            this.$store.state.showSearchIcon = false;
        }
    }
</script>
