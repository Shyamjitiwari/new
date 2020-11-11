<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="createLeadHistory" @submit.prevent="addProjectHistory()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Selected Projects (Optional)</label>
                                    <multiselect
                                        v-model="projects"
                                        placeholder="Select projects"
                                        label="name"
                                        track-by="id"
                                        :options="getProjects"
                                        :multiple="true"
                                    ></multiselect>
                                </div>
                            </div>
                            <div class="row" v-if="!snooze">
                                <div class="col">
                                    <div class="form-group">
                                        <label >Remarks</label>
                                        <textarea class="form-control" v-model="remarks" rows="5"></textarea>
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
    import { mapGetters } from 'vuex';
    export default {
        props : ['lead', 'modal', 'search'],
        data(){
            return {
                projects : [],
                remarks: ''
            }
        },
        computed:{
            ...mapGetters(["getErrors", "getMessage", "getProjects"]),
        },
        created(){
            this.$store.dispatch('fetchAllActiveProjects');
        },
        methods:{
            addProjectHistory(){
                this.$store.dispatch('dispatchCreateHistoryProjects', {
                    'lead_id' : this.lead.id,
                    'remarks' : this.remarks,
                    'projects' : this.projects,
                    'modal' : this.modal,
                });
                if(!this.modal) {
                    setTimeout(() => {
                        this.$store.dispatch('fetchShowLead', this.lead.id)
                    }, 300);
                } else {
                    this.$emit('hideModalAll', 'updateLeadProjects')
                }

            },
            reset(){
                this.projects = [];
                this.remarks= '';
            }
        }

    }
</script>
