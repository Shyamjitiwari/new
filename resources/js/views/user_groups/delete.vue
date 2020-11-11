<template>
    <div>
        <page-title
            title="Delete User Group"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsUserGroups.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteUserGroup(getUserGroup)">{{getCaptionsUserGroups.delete_button}}</button>
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
                userGroup: {}
            };
        },
        computed: {
            ...mapGetters(["getUserGroup", "getErrors", "getCaptionsUserGroups"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditUserGroup", this.$route.params.id);
        },
        methods: {
            deleteUserGroup(u) {
                this.$store.dispatch("deleteUserGroup", u);
            }
        }
    };
</script>
