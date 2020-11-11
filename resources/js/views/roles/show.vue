<template>
    <div>
        <page-title
            :title="'Role: '+ getRole.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                       <p class="m-0">Name: {{getRole.name}}</p>
                        <p class="m-0" v-if="getRole.mobile">Mobile: {{getRole.mobile}}</p>
                        <p class="m-0">Email: {{getRole.email}}</p>
                        <p class="m-0">Created: {{getRole.created_at}} <span v-if="getRole.created_by">By {{getRole.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getRole.updated_at}} <span v-if="getRole.updated_by">By {{getRole.updated_by.name}}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h4>Assigned to Users:</h4>
                        <button type="submit" class="btn btn-primary m-1" v-for="p in getRole.users" :key="p.id">{{p.name}}</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4>Selected permissions:</h4>
                        <button type="submit" class="btn btn-success m-1" v-for="p in getRole.permissions" :key="p.id">{{p.name}}</button>
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
                    {router_name : 'roles.create', router_params: '', router_hover : 'Add Role', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'roles.edit', router_params: this.$route.params.id, router_hover : 'Edit Role', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getRole', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowRole', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowRole", this.$route.params.id);
        }

    }
</script>
