<template>
    <div>
        <page-title
            title="Edit Role"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLeadStatus" @submit.prevent="updateRole()" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="editRole.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Selected Permissions</label>
                                    <multiselect
                                        v-model="editRole.permissions"
                                        placeholder="Select permissions"
                                        label="name"
                                        track-by="id"
                                        :options="getActivePermission"
                                        :multiple="true"
                                    ></multiselect>
                                </div>
                            </div>
                            <submit-button status="Update"> </submit-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "editRole", "getActivePermission"])
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditRole", this.$route.params.id);
            this.$store.dispatch("fetchAllActivePermissions");
        },
        methods: {
            updateRole() {
                this.$store.dispatch("dispatchCreateRole",this.editRole);
                this.reset();
            },
            reset() {
                //resetting errors adn error messages
                this.$store.dispatch("fetchEditRole", this.$route.params.id);
                this.$store.dispatch("fetchAllActivePermissions");
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
