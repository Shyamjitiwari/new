<template>
    <div>
        <page-title
            title="Delete Project Unit"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsProjectUnits.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteProjectUnit(getProjectUnit)">{{getCaptionsProjectUnits.delete_button}}</button>
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
                projectUnit: {}
            };
        },
        computed: {
            ...mapGetters(["getProjectUnit", "getErrors", "getCaptionsProjectUnits"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditProjectUnit", this.$route.params.id);
        },
        methods: {
            deleteProjectUnit(u) {
                this.$store.dispatch("deleteProjectUnit", u);
            }
        }
    };
</script>
