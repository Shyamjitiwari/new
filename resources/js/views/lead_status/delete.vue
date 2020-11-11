<template>
    <div>
        <page-title
            title="Delete LeadStatus"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsLeadStatuses.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteLeadStatus(getLeadStatus)">{{getCaptionsLeadStatuses.delete_button}}</button>
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
                lead_status: {}
            };
        },
        computed: {
            ...mapGetters(["getLeadStatus", "getErrors", "getCaptionsLeadStatuses"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditLeadStatus", this.$route.params.id);
        },
        methods: {
            deleteLeadStatus(u) {
                this.$store.dispatch("deleteLeadStatus", u);
            }
        }
    };
</script>
