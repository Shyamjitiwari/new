<template>
    <div>
        <page-title
            title="Delete LeadSource"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsLeadSources.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteLeadSource(getLeadSource)">{{getCaptionsLeadSources.delete_button}}</button>
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
                lead_source: {}
            };
        },
        computed: {
            ...mapGetters(["getLeadSource", "getErrors", "getCaptionsLeadSources"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditLeadSource", this.$route.params.id);
        },
        methods: {
            deleteLeadSource(u) {
                this.$store.dispatch("deleteLeadSource", u);
            }
        }
    };
</script>
