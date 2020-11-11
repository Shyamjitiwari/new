<template>
    <div>
        <page-title
            :title="'User: '+ getUser.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <show-image
                            v-if="getUser.image_name"
                            :folder=getFolder
                            :image_name=getUser.image_name
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
                        <p class="m-0">Name: {{getUser.name}}</p>
                        <p class="m-0" v-if="getUser.mobile">Mobile: {{getUser.mobile}}</p>
                        <p class="m-0">Email: {{getUser.email}}</p>
                        <p class="m-0">Created: {{getUser.created_at}} <span v-if="getUser.created_by">By {{getUser.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getUser.updated_at}} <span v-if="getUser.updated_by">By {{getUser.updated_by.name}}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        data(){
            return {
                title_links : [
                    {router_name : 'users.create', router_params: '', router_hover : 'Add User', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'users.edit', router_params: this.$route.params.id, router_hover : 'Edit User', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getUser', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowUser', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowUser", this.$route.params.id);
        }

    }
</script>
