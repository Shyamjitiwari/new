<template>
    <div>
        <page-title
            title="Delete Project"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsProjects.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteProject(getProject)">{{getCaptionsProjects.delete_button}}</button>
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
            ...mapGetters(["getProject", "getErrors", "getCaptionsProjects"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditProject", this.$route.params.id);
        },
        methods: {
            deleteProject(u) {
                this.$store.dispatch("deleteProject", u);
            }
        }
    };
</script>
