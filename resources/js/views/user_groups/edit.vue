<template>
    <div>
        <page-title
            :title="'Edit User Group: '+ getUserGroup.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editBuilder" @submit.prevent="editUserGroup" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                            v-model="getUserGroup.name"
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                            </div>
                            <submit-button status="Update"></submit-button>
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
                savingState: false,
                userGroup: {},
                title_links : [
                    {router_name : 'user.groups.create', router_params: '', router_hover : 'Add User Group', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'user.groups.show', router_params: this.$route.params.id, router_hover : 'Show User Group', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditUserGroup', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getUserGroup", "getErrors", "getMessage"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditUserGroup", this.$route.params.id);
        },
        methods: {
            editUserGroup() {
                let self = this;
                self.$store.dispatch("dispatchEditUserGroup",self.getUserGroup)
                ;
            }
        }
    };
</script>
