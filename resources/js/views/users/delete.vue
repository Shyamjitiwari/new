<template>
    <div>
        <page-title
            title="Delete User"
        > </page-title>
        <div class="row">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body m-0">
                        <div class="text-center">
                            <p>{{getCaptionsUsers.delete_message}}</p>
                            <button v-if="!this.$store.state.apiLoading" class="btn btn-danger" @click="deleteUser(getUser)">{{getCaptionsUsers.delete_button}}</button>
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
                user: {}
            };
        },
        computed: {
            ...mapGetters(["getUser", "getErrors", "getCaptionsUsers"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditUser", this.$route.params.id);
        },
        methods: {
            deleteUser(u) {
                this.$store.dispatch("deleteUser", u);
            }
        }
    };
</script>
