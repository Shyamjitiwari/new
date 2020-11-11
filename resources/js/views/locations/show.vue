<template>
    <div>
        <page-title
            :title="'Location: '+ getLocation.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Name: {{getLocation.name}}</p>
                        <p class="m-0">Pincode: {{getLocation.pincode}}</p>
                        <hr v-if="getLocation.address">
                        <p class="m-0" v-if="getLocation.address">Address: {{getLocation.address}}</p>
                        <hr v-if="getLocation.address">
                        <p class="m-0">Created: {{getLocation.created_at}} <span v-if="getLocation.created_by">By {{getLocation.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getLocation.updated_at}} <span v-if="getLocation.updated_by">By {{getLocation.updated_by.name}}</span></p>
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
                    {router_name : 'locations.create', router_params: '', router_hover : 'Add Location', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'locations.edit', router_params: this.$route.params.id, router_hover : 'Edit Location', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getLocation', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowLocation', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowLocation", this.$route.params.id);
        }

    }
</script>
