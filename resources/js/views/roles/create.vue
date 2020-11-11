<template>
    <div>
        <page-title
            title="Add Role"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLeadStatus" @submit.prevent="createRole()" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="role.name"
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
                                        v-model="permissions"
                                        placeholder="Select permissions"
                                        label="name"
                                        track-by="id"
                                        :options="getActivePermission"
                                        :multiple="true"
                                    ></multiselect>
                                </div>
                            </div>
                            <submit-button status="Add"> </submit-button>
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
                role: {},
                permissions : []
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "getActivePermission"])
        },
        created() {
            this.role = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchCreateRole");
            this.$store.dispatch("fetchAllActivePermissions");
        },
        methods: {
            createRole() {
                this.role['permissions'] = this.permissions;
                this.$store.dispatch("dispatchCreateRole",this.role);
                this.reset();
            },
            reset() {
                this.role = {};
                //resetting errors adn error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
