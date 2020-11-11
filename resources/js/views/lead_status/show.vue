<template>
    <div>
        <page-title
            :title="'Lead Status: '+ getLeadStatus.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Name: {{getLeadStatus.name}}</p>
                        <p class="m-0" v-if="getLeadStatus.mobile">Mobile: {{getLeadStatus.mobile}}</p>
                        <p class="m-0">Email: {{getLeadStatus.email}}</p>
                        <p class="m-0">Created: {{getLeadStatus.created_at}} <span v-if="getLeadStatus.created_by">By {{getLeadStatus.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getLeadStatus.updated_at}} <span v-if="getLeadStatus.updated_by">By {{getLeadStatus.updated_by.name}}</span></p>
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
                    {router_name : 'lead_statuses.create', router_params: '', router_hover : 'Add LeadStatus', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'lead_statuses.edit', router_params: this.$route.params.id, router_hover : 'Edit LeadStatus', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getLeadStatus', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowLeadStatus', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowLeadStatus", this.$route.params.id);
        }

    }
</script>
