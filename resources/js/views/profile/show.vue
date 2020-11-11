<template>
    <div>
        <page-title
            title="Profile"
            :title_links = title_links
        >
        </page-title>
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
                <div class="card">
                    <div class="card-body">
                        <p>Name: {{getAuth.name}}</p>
                        <p v-if="getAuth.mobile">Mobile: {{getAuth.mobile}}</p>
                        <p>Email: {{getAuth.email}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import PageTitle from "../../components/PageTitle";
    export default {
        components : {
          PageTitle
        },
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
        create() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchAuth");
        }
    };
</script>

