<template>
    <div>
        <page-title
            title="Profile"
            :title_links = title_links
        > </page-title>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <show-image
                            v-if="getAuth.image_name"
                            :folder=getFolder
                            :image_name=getAuth.image_name
                            size = "none"
                        >
                        </show-image>
                        <img v-else class="rounded mx-auto d-block" :src="getImageUrl + '/users/profile.png'" />
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <form @submit.prevent="updatePassword(getAuth)">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                Old Password:
                                <input
                                    class="form-control"
                                    type="password"
                                    v-model="getAuth.old_password"
                                />
                                <span
                                    v-if="getErrors.old_password !== ''"
                                    class="text-danger"
                                    v-text="getErrors.old_password"
                                > </span>
                            </p>
                            <p>
                                New Password:
                                <input class="form-control" type="password" v-model="getAuth.password" />
                                <span
                                    v-if="getErrors.password !== ''"
                                    class="text-danger"
                                    v-text="getErrors.password"
                                > </span>
                            </p>
                            <p>
                                Confirm Password:
                                <input
                                    class="form-control"
                                    type="password"
                                    v-model="getAuth.confirm_password"
                                />
                                <span
                                    v-if="getErrors.confirm_password !== ''"
                                    class="text-danger"
                                    v-text="getErrors.confirm_password"
                                > </span>
                            </p>
                            <p>
                                <submit-button status="Update Password"> </submit-button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                title_links : [
                {router_name : 'profile.show', router_hover : 'Show Profile', type : 'icon', icon:'visibility', 'class' : 'text-success'},
                {router_name : 'profile.edit', router_hover : 'Edit Profile', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                {router_name : 'profile.changepassword', router_hover : 'Change Password', type : 'icon', icon:'sync', 'class' : 'text-info'},
            ]
            };
        },
        computed: {
            ...mapGetters(["getAuth", "getErrors", "getFolder", "getImageUrl"])
        },
        created(){
            this.$store.state.showSearchIcon = false;
        },
        methods: {
            updatePassword(profile) {
                this.$store.dispatch("dispatchUpdateProfilePassword", profile);
            }
        }
    };
</script>

