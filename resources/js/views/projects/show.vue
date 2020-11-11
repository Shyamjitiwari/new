<template>
    <div>
        <page-title
            :title="'Project: '+ getProject.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Name: {{getProject.name}}</p>
                        <p class="m-0" v-if="getProject.mobile">Mobile: {{getProject.mobile}}</p>
                        <p class="m-0" v-if="getProject.location">Mobile: {{getProject.location.name}}</p>
                        <p class="m-0" v-if="getProject.builder">Mobile: {{getProject.builder.name}}</p>
                        <hr v-if="getProject.address">
                        <p class="m-0" v-if="getProject.address">Address: {{getProject.address}}</p>
                        <hr v-if="getProject.address">
                        <p class="m-0">City: {{getProject.city}}</p>
                        <p class="m-0">State: {{getProject.state}}</p>
                        <p class="m-0" v-if="getProject.possession">Possession: {{getProject.possession}}</p>
                        <p class="m-0" v-if="getProject.distance_in_kms">Distance (in kms): {{getProject.distance_in_kms}}</p>
                        <p class="m-0" v-if="getProject.from">From: {{getProject.from}}</p>
                        <p class="m-0" v-if="getProject.nearby_location">From: {{getProject.nearby_location.name}}</p>
                        <p class="m-0">Created: {{getProject.created_at}} <span v-if="getProject.created_by">By {{getProject.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getProject.updated_at}} <span v-if="getProject.updated_by">By {{getProject.updated_by.name}}</span></p>
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
                    {router_name : 'projects.create', router_params: '', router_hover : 'Add Project', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'projects.edit', router_params: this.$route.params.id, router_hover : 'Edit Project', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getProject', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowProject', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowProject", this.$route.params.id);
        }

    }
</script>
