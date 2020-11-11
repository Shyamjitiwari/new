<template>
    <button
        type="submit"
        class="btn btn-primary"
        :disabled="this.$store.state.apiLoading"
    >
        <span v-if="!this.$store.state.apiLoading" >{{status}}</span>
        <span v-else class="spinner-border spinner-border-sm"></span>
    </button>
</template>

<script>
    export default {
        props: ['status']
    }
</script>
