<template>
    <div>
        <page-title
            title="Add User"
        >
        </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createUser" @submit.prevent="createUser(user)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="file" @change="getImage" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="user.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input
                                            type="email"
                                            v-model="user.email"
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
                                            v-model="user.mobile"
                                            class="form-control"
                                            placeholder="Mobile Number..."
                                        />
                                        <span v-if="getErrors.mobile !== ''" class="text-danger" v-text="getErrors.mobile"> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Select Role</label>
                                        <select v-model="user.role_id" class="form-control">
                                            <option disabled selected>Select Role</option>
                                            <option v-for="role in getRoles" :key="role.id" :value="role.id">{{role.name}}</option>
                                        </select>
                                        <span v-if="getErrors.role_id !== ''" class="text-danger" v-text="getErrors.role_id"> </span>
                                    </div>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Select User Group</label>
                                        <select v-model="user.user_group_id" class="form-control">
                                            <option disabled selected>Select User Group</option>
                                            <option v-for="group in getUserGroupsActive" :key="group.id" :value="group.id">{{group.name}}</option>
                                        </select>
                                        <span v-if="getErrors.user_group_id !== ''" class="text-danger" v-text="getErrors.user_group_id"> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input
                                            type="password"
                                            v-model="user.password"
                                            class="form-control"
                                            placeholder="Enter New Password"
                                        />
                                        <span
                                            v-if="getErrors.password !== ''"
                                            class="text-danger"
                                            v-text="getErrors.password"
                                        > </span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input
                                            type="password"
                                            v-model="user.confirm_password"
                                            class="form-control"
                                            id="confirm_password"
                                            placeholder="Confirm Password"
                                        />
                                        <span
                                            v-if="getErrors.confirm_password !== ''"
                                            class="text-danger"
                                            v-text="getErrors.confirm_password"
                                        > </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Team</label>
                                        <select v-model="user.team" class="form-control" multiple>
                                            <option selected>Select Team</option>
                                            <option v-for="team in getUsersForTeamSelection" :key="team.id" :value="team.id">{{team.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <submit-button status="Add"> </submit-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
                        </form>
                    </div>
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
                user: {},
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getUserGroupsActive", "getMessage", "getRoles", "getUsersForTeamSelection"])
        },
        created() {
            this.user = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
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
            createUser(user) {
                this.$store.dispatch("dispatchCreateUser",user);
                this.reset();
            },
            reset() {
                this.user = {};
                //resetting errors adn error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
