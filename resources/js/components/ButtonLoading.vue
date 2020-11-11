<template>
    <button type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        {{status}}
        <span class="sr-only">Loading...</span>
    </button>
</template>
<script>
    export default {
        props:['status', "bg-color"]
    };
</script>
