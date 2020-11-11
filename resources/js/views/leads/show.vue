<template>
    <div>
        <page-title
            :title="'Lead: '+ getLead.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-5">
                <!-- <div class="card">
                    <div class="card-panel">
                        <a @click="updateLeadStatus(getLead)" title="Update Lead Status">
                            <i class="material-icons text-info">refresh</i>
                        </a>
                    </div>
                </div> -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <p class="m-0">Name: {{getLead.name}}</p>
                                <p class="m-0" v-if="getLead.mobile">Mobile: {{getLead.mobile}}</p>
                                <p class="m-0" v-if="getLead.email">Email: {{getLead.email}}</p>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <p class="m-0">Created: {{getLead.created_at}} <span v-if="getLead.created_by">By {{getLead.created_by.name}}</span></p>
                                <p class="m-0">Last Updated: {{getLead.updated_at}} <span v-if="getLead.updated_by">By {{getLead.updated_by.name}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <p class="m-0">Source: {{getLead.lead_source.name}}</p>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <p class="m-0">Status:
                                    <span class="label-status text-uppercase" :style="{ color: getLead.lead_status.text, background: getLead.lead_status.bg }">
                                        {{getLead.lead_status.name}}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Assigned To:
                            <span class="label-status bg-info text-white" v-for="user in getLead.assigned_users" :key="user.id">{{user.name}}</span>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Current Interests:<br>
                            <span v-for="history in getLead.lead_history" :key="history.id">
                                <span v-if="!history.completed">
                                    <span class="label-status bg-success text-white text-capitalize" v-for="project in history.projects">
                                        {{project.name}}<br>
                                    </span>
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        Project: {{getLead.project}}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Remarks: {{getLead.remarks}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <router-link class="nav-link" :to="{name:'leads.children'}" data-toggle="pill">Grouped</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :to="{name:'leads.show.comments'}" data-toggle="pill">Comments</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :to="{name:'leads.show.histories'}" data-toggle="pill">Status History</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :to="{name:'leads.create.histories'}" data-toggle="pill">Update Status</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :to="{name:'leads.update.projects'}" data-toggle="pill">Update Projects</router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <router-view> </router-view>
            </div>

        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    // import UpdateLeadStatus from "../../components/UpdateLeadStatus";
    export default {
        components : {
            //UpdateLeadStatus
        },
        data(){
            return {
                title_links : [
                    {router_name : 'leads.create', router_params: '', router_hover : 'Add Lead', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'leads.edit', router_params: this.$route.params.id, router_hover : 'Edit Lead', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ]
            }
        },
        computed : {
            ...mapGetters(['getLead', "getAuth", "getErrors"]),

            reload(){
                return {type : 'fetchShowLead', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowLead", this.$route.params.id);
            this.$router.push({name:'leads.show.histories'})
        },
        methods : {
            updateLeadStatus(lead){
                this.$bvModal.show('updateLeadStatus');
            }
        }

    }
</script>
