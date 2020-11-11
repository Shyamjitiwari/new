<template>
    <div>
        <page-title
            title="Delete API"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsApis.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteApi(getApi)">{{getCaptionsApis.delete_button}}</button>
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
                api: {}
            };
        },
        computed: {
            ...mapGetters(["getApi", "getErrors", "getCaptionsApis"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditApi", this.$route.params.id);
        },
        methods: {
            deleteApi(u) {
                this.$store.dispatch("deleteApi", u);
            }
        }
    };
</script>
