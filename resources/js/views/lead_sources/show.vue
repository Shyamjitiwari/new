<template>
    <div>
        <page-title
            :title="'LeadSource: '+ getLeadSource.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Name: {{getLeadSource.name}}</p>
                        <p class="m-0" v-if="getLeadSource.mobile">Mobile: {{getLeadSource.mobile}}</p>
                        <p class="m-0">Email: {{getLeadSource.email}}</p>
                        <p class="m-0">Created: {{getLeadSource.created_at}} <span v-if="getLeadSource.created_by">By {{getLeadSource.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getLeadSource.updated_at}} <span v-if="getLeadSource.updated_by">By {{getLeadSource.updated_by.name}}</span></p>
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
                    {router_name : 'lead_sources.create', router_params: '', router_hover : 'Add LeadSource', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'lead_sources.edit', router_params: this.$route.params.id, router_hover : 'Edit LeadSource', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getLeadSource', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowLeadSource', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowLeadSource", this.$route.params.id);
        }

    }
</script>
