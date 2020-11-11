<template>
    <div style="text-align: center">
        <span style="text-transform: uppercase; font-weight: bold; font-size: large" v-if="getAppSettings.company_name">{{getAppSettings.company_name}}</span>
        <span style="font-style: italic">
            <span v-if="getAppSettings.landline"><br> Landline: {{getAppSettings.landline}}</span>
            <span v-if="getAppSettings.mobile">, Mobile: {{getAppSettings.mobile}}</span>
            <span v-if="getAppSettings.email">, Email: {{getAppSettings.email}}</span>
            <span v-if="getAppSettings.address">, <br>Address: {{getAppSettings.address}}</span>
            <span v-if="getAppSettings.city">, City: {{getAppSettings.city}}</span>
            <span v-if="getAppSettings.country">, Country: {{getAppSettings.country}}</span>
        </span>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    export default {
        created() {
            this.$store.dispatch("fetchAppSettings");
        },
        computed: {
            ...mapGetters(["getAppSettings"])
        },
    }
</script>
