<template>
    <div>
        <page-title
            :title="'Edit API: '+ getApi.url"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editApiSource" @submit.prevent="editApi" enctype="multipart/form-data">
                           <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="URL">URL</label>
                                        <input
                                            type="text"
                                            v-model="getApi.url"
                                            class="form-control"
                                            id="url"
                                            placeholder="URL..."
                                        />
                                        <span v-if="getErrors.url !== ''" class="text-danger">{{getErrors.url}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Key</label>
                                        <input
                                            type="text"
                                            v-model="getApi.key"
                                            class="form-control"
                                            id="key"
                                            placeholder="Key..."
                                        />
                                        <span v-if="getErrors.key !== ''" class="text-danger">{{getErrors.key}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_name">User Name</label>
                                        <input
                                            type="text"
                                            v-model="getApi.user_name"
                                            class="form-control"
                                            id="user_name"
                                            placeholder="User Name..."
                                        />
                                        <span v-if="getErrors.user_name !== ''" class="text-danger">{{getErrors.user_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input
                                            type="text"
                                            v-model="getApi.password"
                                            class="form-control"
                                            id="password"
                                            placeholder="Password..."
                                        />
                                        <span v-if="getErrors.password !== ''" class="text-danger">{{getErrors.password}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select v-model="getApi.type" class="form-control">
                                            <option disabled selected>Select API Source</option>
                                            <option value="magic_bricks">Magic Bricks</option>
                                            <option value="acers">Acres</option>
                                            <option value="housing">Housing</option>
                                        </select>
                                        <span v-if="getErrors.type !== ''" class="text-danger">{{getErrors.type}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="account_id">Account Id</label>
                                          <input
                                            type="text"
                                            v-model="getApi.account_id"
                                            class="form-control"
                                            id="account_id"
                                            placeholder="Account Id..."
                                        />
                                        <span v-if="getErrors.account_id !== ''" class="text-danger">{{getErrors.account_id}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_group">User Group</label>
                                         <select v-model="getApi.user_group_id" class="form-control">
                                            <option disabled selected>Select User Group</option>
                                            <option v-for="group in getUserGroupsActive" :key="group.id" :value="group.id">{{group.name}}</option>
                                        </select>
                                        <span v-if="getErrors.user_group_id !== ''" class="text-danger">{{getErrors.user_group_id}}</span>
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
                api_source: {},
                title_links : [
                    {router_name : 'apis.create', router_params: '', router_hover : 'Add API ', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'apis.show', router_params: this.$route.params.id, router_hover : 'Show API', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditApi', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getApi", "getUserGroupsActive", "getErrors", "getMessage"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchAllActiveUserGroups');
            this.$store.dispatch("fetchEditApi", this.$route.params.id);
        },
        methods: {
            editApi() {
                let self = this;
                self.$store.dispatch("dispatchEditApi",self.getApi)
                ;
            }
        }
    };
</script>
