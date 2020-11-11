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
                            from="profile"
                            size-="none"
                        >
                        </show-image>
                        <img v-else class="rounded mx-auto d-block" :src="getImageUrl + '/users/profile.png'" />
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <form @submit.prevent="editProfile()">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                <input type="file" @change="getImage" class="form-control">
                            </p>
                            <p>
                                Name:
                                <input class="form-control" type="text" v-model="getAuth.name" />
                                <span v-if="getErrors.name !== ''" class="text-danger" v-text="getErrors.name"></span>
                            </p>
                            <p>
                                Mobile:
                                <input class="form-control" type="text" v-model="getAuth.mobile" />
                                <span v-if="getErrors.mobile !== ''" class="text-danger" v-text="getErrors.mobile"></span>
                            </p>
                            <p>
                                Email:
                                <input class="form-control" type="email" v-model="getAuth.email" />
                                <span v-if="getErrors.message !== ''" class="text-danger" v-text="getErrors.message"></span>
                            </p>
                            <p>
                                <submit-button status="Update Profile"></submit-button>
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
                profile: {},
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
        created() {
            this.$store.state.showSearchIcon = false;
        },
        methods: {
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.profile.image_name = e.target.result;
                }
            },
            editProfile() {
                this.getAuth.image_name = this.profile.image_name
                this.$store.dispatch("dispatchEditProfile", this.getAuth);
            }
        }
    };
</script>

