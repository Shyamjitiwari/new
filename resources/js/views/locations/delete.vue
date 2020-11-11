<template>
    <div>
        <page-title
            title="Delete Location"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsLocations.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteLocation(getLocation)">{{getCaptionsLocations.delete_button}}</button>
                            <buttonloading class="btn btn-danger" v-else status="Deleting..."> </buttonloading>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                project: {}
            };
        },
        computed: {
            ...mapGetters(["getLocation", "getErrors", "getCaptionsLocations"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditLocation", this.$route.params.id);
        },
        methods: {
            deleteLocation(u) {
                this.$store.dispatch("deleteLocation", u);
            }
        }
    };
</script>
