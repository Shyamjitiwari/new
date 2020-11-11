<template>
    <div>
        <page-title
            :title="'User Group: '+ getUserGroup.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Name: {{getUserGroup.name}}</p>
                        <p class="m-0">Created: {{getUserGroup.created_at}} <span v-if="getUserGroup.created_by">By {{getUserGroup.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getUserGroup.updated_at}} <span v-if="getUserGroup.updated_by">By {{getUserGroup.updated_by.name}}</span></p>
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
                    {router_name : 'user.groups.create', router_params: '', router_hover : 'Add User Group', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'user.groups.edit', router_params: this.$route.params.id, router_hover : 'Edit User Group', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getUserGroup', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowUserGroup', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowUserGroup", this.$route.params.id);
        }

    }
</script>
