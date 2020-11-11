<template>
    <button
        type="submit"
        class="btn btn-primary"
        :disabled="this.$store.state.apiLoading"
    >
        <span v-if="!this.$store.state.apiLoading">{{label}}</span>
        <span v-else class="spinner-border spinner-border-sm"></span>
    </button>
</template>

<script>
    export default {
        props: ['label']
    }
</script>
