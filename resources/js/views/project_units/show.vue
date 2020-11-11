<template>
    <div>
        <page-title
            :title="'Project Unit: '+ getProjectUnit.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Type: {{getProjectUnit.type}}</p>
                        <p class="m-0" >Price: {{getProjectUnit.price}}</p>
                        <p class="m-0">Size: {{getProjectUnit.size}}</p>
                        <p class="m-0">project: {{getProjectUnit.project}}</p>
                        <p class="m-0" v-if="getProjectUnit.sales_type">Sales Type: {{getProjectUnit.sales_type}}</p>
                        <p class="m-0" v-if="getProjectUnit.bedroom">Bedroom: {{getProjectUnit.bedroom}}</p>
                        <p class="m-0" v-if="getProjectUnit.bathroom">Bathroom: {{getProjectUnit.bathroom}}</p>
                        <p class="m-0" v-if="getProjectUnit.balcony">Balcony: {{getProjectUnit.balcony}}</p>
                        <p class="m-0" v-if="getProjectUnit.additional_room">Additional Room: {{getProjectUnit.additional_room}}</p>

                        <p class="m-0">Created: {{getProjectUnit.created_at}} <span v-if="getProjectUnit.created_by">By {{getProject.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getProjectUnit.updated_at}} <span v-if="getProjectUnit.updated_by">By {{getProject.updated_by.name}}</span></p>
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
                    {router_name : 'projectUnits.create', router_params: '', router_hover : 'Add Project Unit', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'projectUnits.edit', router_params: this.$route.params.id, router_hover : 'Edit Project Unit' , type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getProjectUnit', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowProjectUnit', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowProjectUnit", this.$route.params.id);
        }

    }
</script>
