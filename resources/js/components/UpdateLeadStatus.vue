<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLeadHistory" @submit.prevent="createLeadHistory()" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Add Follow Up Date & Time (Optional)</label>
                                        <input type="datetime-local" class="form-control" v-model="getLeadHistory.follow_up_at">
                                        <span v-if="getErrors.follow_up_at !== ''" class="text-danger">{{getErrors.follow_up_at}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='row' v-if="!snooze">
                                <div class="col-md col-sm-12">
                                    <div class="form-group">
                                        <label>Lead Status (Parent)</label>
                                        <select class="form-control" v-model="selectedParent">
                                            <option v-for="lead_status in leadStatusParent" :key="lead_status.id" :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                        <span v-if="getErrors.lead_status_id !== '' && selectedParent == ''" class="text-danger">{{getErrors.lead_status_id}}</span>
                                    </div>
                                </div>
                                <div class="col-md col-sm-12" v-if="selectedParent">
                                    <div class="form-group">
                                        <label>Lead Status</label>
                                        <select class="form-control" v-model="getLeadHistory.lead_status_id">
                                            <option v-for="lead_status in leadStatusSubParent" :key="lead_status.id" :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                        <span v-if="getErrors.lead_status_id !== ''" class="text-danger">{{getErrors.lead_status_id}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="!snooze">
                                <div class="col">
                                    <div class="form-group">
                                        <label >Remarks</label>
                                        <textarea class="form-control" v-model="getLeadHistory.remarks" rows="5"></textarea>
                                        <span v-if="getErrors.remarks !== ''" class="text-danger">{{getErrors.remarks}}</span>
                                    </div>
                                </div>
                            </div>
                            <submit-button status="Add"> </submit-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        props : ['lead', 'snooze', 'modal', 'search'],
        data() {
            return {
                selectedParent : ''
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "getLeadHistory", "getActiveLeadStatuses", "getLeads"]),

            leadStatusParent(){
                return this.getActiveLeadStatuses.filter(lead_status => lead_status.parent_id == null);
            },

            leadStatusSubParent(){
                return this.getActiveLeadStatuses.filter(lead_status => lead_status.parent_id == this.selectedParent);
            },
        },
        created() {
            this.selectedParent = '';
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.commit("setLeadHistory", {});
            this.$store.dispatch("fetchActiveLeadStatuses");
        },
        methods: {
            createLeadHistory() {
                this.getLeadHistory['lead_id'] = this.lead.id;
                this.getLeadHistory['snooze'] = this.snooze;
                this.getLeadHistory['modal'] = this.modal;
                this.$store.dispatch("dispatchCreateHistory",this.getLeadHistory);

                if(this.modal) {
                    setTimeout(()=>{
                        this.$store.dispatch("fetchLeads", {
                            next_page: this.getLeads.current_page,
                            search: this.search
                        });
                    }, 300);
                    if(this.snooze) {
                        this.$bvModal.hide('updateLeadStatus');
                    } else {
                        this.$bvModal.hide('updateLeadStatusWithRemarks');
                    }
                }
                // this.$router.go({path:'leads.index'});
            },
            reset() {
                //resetting errors and error messages
                this.selectedParent = '';
                this.$store.dispatch('setResetData');
                this.$store.commit("setLeadHistory", {});
            }
        }
    };
</script>
