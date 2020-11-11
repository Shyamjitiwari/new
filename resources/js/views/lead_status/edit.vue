<template>
    <div>
        <page-title
            :title="'Edit Lead Status: '+ getLeadStatus.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editLeadStatus" @submit.prevent="editLeadStatus" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                            v-model="getLeadStatus.name"
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label>Parent Lead Status (Optional)</label>
                                        <select class="form-control" v-model="getLeadStatus.parent_id">
                                            <option :selected="lead_status.parent_id = ''" :disabled="true" value="">Select Lead Status</option>
                                            <option v-for="lead_status in getParentLeadStatuses" :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Background Color</label>
                                        <input
                                            type="text"
                                            v-model="getLeadStatus.bg"
                                            class="form-control"
                                            placeholder="Background Color..."
                                            required
                                        />
                                        <span v-if="getErrors.bg !== ''" class="text-danger">{{getErrors.bg}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Text Colour</label>
                                        <input
                                            type="text"
                                            v-model="getLeadStatus.text"
                                            class="form-control"
                                            placeholder="Text Color..."
                                            required
                                        />
                                        <span v-if="getErrors.text !== ''" class="text-danger">{{getErrors.text}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col text-center">
                                    <span class="label-status text-uppercase" :style="{ color: getLeadStatus.text, background: getLeadStatus.bg }">
                                        {{getLeadStatus.name}}
                                    </span>
                                </div>
                            </div>
                            <submit-button status="Update"></submit-button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                savingState: false,
                lead_status: {
                    parent_id : ''
                },
                title_links : [
                    {router_name : 'lead.statuses.create', router_params: '', router_hover : 'Add LeadStatus', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'lead.statuses.show', router_params: this.$route.params.id, router_hover : 'Show LeadStatus', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditLeadStatus', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getLeadStatus", "getErrors", "getMessage", "getParentLeadStatuses"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditLeadStatus", this.$route.params.id);
            this.$store.dispatch("fetchParentLeadStatuses");
        },
        methods: {
            editLeadStatus() {
                this.$store.dispatch("dispatchEditLeadStatus",this.getLeadStatus);
            }
        }
    };
</script>
