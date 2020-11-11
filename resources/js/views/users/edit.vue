<template>
    <div>
        <page-title
            :title="'Edit User: '+ getUser.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editUser" @submit.prevent="editUser" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 mb-3" v-if="getUser.image_name">
                                    <show-image
                                        :folder=getFolder
                                        :image_name=getUser.image_name
                                        size = 100
                                    >
                                    </show-image>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="file" @change="getImage" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                            v-model="getUser.name"
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input
                                            type="email"
                                            v-model="getUser.email"
                                            class="form-control"
                                            placeholder="Email Address..."
                                        />
                                        <span v-if="getErrors.email !== ''" class="text-danger" v-text="getErrors.email"> </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input
                                            type="number"
                                            v-model="getUser.mobile"
                                            class="form-control"
                                            placeholder="Mobile Number..."
                                        />
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Select Role</label>
                                        <select v-model="getUser.role_id" class="form-control">
                                            <option disabled selected>Select Role</option>
                                            <option v-for="role in getRoles" :key="role.id" :value="role.id">{{role.name}}</option>
                                        </select>
                                        <span v-if="getErrors.role_id !== ''" class="text-danger" v-text="getErrors.role_id"> </span>
                                    </div>
                                </div>
                               <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Select User Group</label>
                                        <select v-model="getUser.user_group_id" class="form-control">
                                            <option disabled selected>Select User Group</option>
                                            <option v-for="group in getUserGroupsActive" :key="group.id" :value="group.id">{{group.name}}</option>
                                        </select>
                                        <span v-if="getErrors.user_group_id !== ''" class="text-danger" v-text="getErrors.user_group_id"> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Team</label>
                                        <select v-model="getUser.team" class="form-control" multiple>
                                            <option selected value="null">Select Team</option>
                                            <option v-for="team in getUsersForTeamSelection" :key="team.id" :value="team">{{team.name}}</option>
                                        </select>
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
                user: {},
                title_links : [
                    {router_name : 'users.create', router_params: '', router_hover : 'Add User', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'users.show', router_params: this.$route.params.id, router_hover : 'Show User', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditUser', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getUser", "getErrors", "getMessage", "getImageUrl", "getFolder", "getRoles", "getUserGroupsActive", "getUsersForTeamSelection"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditUser", this.$route.params.id);
            this.$store.dispatch('fetchAllActiveRoles');
            this.$store.dispatch('fetchAllActiveUserGroups');
            this.$store.dispatch('fetchUsersForTeamSelection');
        },
        methods: {
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.user.image_name = e.target.result;
                }
            },
            editUser() {
                let self = this;
                self.$store.dispatch("dispatchEditUser",self.getUser);
            }
        }
    };
</script>
