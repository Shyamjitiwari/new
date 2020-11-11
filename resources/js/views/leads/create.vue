<template>
    <div>
        <page-title v-if="!isEditable" title="Add Lead"> </page-title>
        <page-title v-else title="Edit Lead"> </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLead" @submit.prevent="createLead()" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="getLead.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input
                                            type="text"
                                            v-model="getLead.mobile"
                                            class="form-control"
                                            id="mobile"
                                            placeholder="Mobile..."
                                        />
                                        <span v-if="getErrors.mobile !== ''" class="text-danger">{{getErrors.mobile}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input
                                            type="email"
                                            v-model="getLead.email"
                                            class="form-control"
                                            id="email"
                                            placeholder="Email..."
                                        />
                                        <span v-if="getErrors.email !== ''" class="text-danger">{{getErrors.email}}</span>
                                    </div>
                                </div>
<!--                                <div class="col-md-3 col-sm-12">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="project">Project</label>-->
<!--                                        <input-->
<!--                                            type="text"-->
<!--                                            v-model="getLead.project"-->
<!--                                            class="form-control"-->
<!--                                            id="project"-->
<!--                                            placeholder="Project..."-->
<!--                                        />-->
<!--                                        <span v-if="getErrors.project !== ''" class="text-danger">{{getErrors.project}}</span>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
<!--                            <div class="row">-->
<!--                                <div class="col-md-6 col-sm-12">-->
<!--                                    <div class="form-group">-->
<!--                                        <label >Project Type</label>-->
<!--                                        <input-->
<!--                                            type="text"-->
<!--                                            v-model="getLead.project_type"-->
<!--                                            class="form-control"-->
<!--                                            id="project_type"-->
<!--                                            placeholder="Project Type..."-->
<!--                                        />-->
<!--                                        <span v-if="getErrors.project_type !== ''" class="text-danger">{{getErrors.project_type}}</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6 col-sm-12">-->
<!--                                    <div class="form-group">-->
<!--                                        <label >Budget</label>-->
<!--                                        <input-->
<!--                                            type="text"-->
<!--                                            v-model="getLead.budget"-->
<!--                                            class="form-control"-->
<!--                                            id="budget"-->
<!--                                            placeholder="Budget..."-->
<!--                                        />-->
<!--                                        <span v-if="getErrors.budget !== ''" class="text-danger">{{getErrors.budget}}</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="row">
                                <div class="col-md col-sm-12" v-if="!isEditable">
                                    <div class="form-group">
                                        <label >Lead Source</label>
                                        <select class="form-control" v-model="getLead.lead_source_id">
                                            <option v-for="lead_source in getLead.lead_sources" :key=lead_source.id :value="lead_source.id">{{lead_source.name}}</option>
                                        </select>
                                        <span v-if="getErrors.lead_source_id !== ''" class="text-danger">{{getErrors.lead_source_id}}</span>
                                    </div>
                                </div>
                                <div class="col-md col-sm-12" v-if="!isEditable">
                                    <div class="form-group">
                                        <label>Lead Status (Parent)</label>
                                        <select class="form-control" v-model="selectedParent">
                                            <option v-for="lead_status in leadStatusParent" :key=lead_status.id :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md col-sm-12" v-if="!isEditable && selectedParent">
                                    <div class="form-group">
                                        <label>Lead Status</label>
                                        <select class="form-control" v-model="getLead.lead_status_id">
                                            <option v-for="lead_status in leadStatusSubParent" :key=lead_status.id :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                        <span v-if="getErrors.lead_status_id !== ''" class="text-danger">{{getErrors.lead_status_id}}</span>
                                    </div>
                                </div>
<!--                                <div :class="{'col-md col-sm-12' : !isEditable, 'col' : isEditable}">-->
<!--                                    <div class="form-group position-relative">-->
<!--                                            <label>Assign To User (Optional)</label>-->
<!--                                        <input placeholder="Min 1 letter..." @keyup="getLiveSearch()" v-model.trim="searchUser" class="form-control" type="text">-->
<!--                                        <div v-if="showUsersDropdown" class="dropdown-menu show" style="min-width: 100%">-->
<!--                                            <a @click="appendValue(user, 'user')" v-for="user in getActiveFilteredUsers"-->
<!--                                            :key='user.id'-->
<!--                                            class="dropdown-item">{{user.name}}</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
<!--                            <div class="row">-->
<!--                                <div v-if="getLead.assigned_users.length > 0" class="col bb-1">-->
<!--                                    <div class="card" style="border:0px;">-->
<!--                                        <div class="card-panel">-->
<!--                                            <div class="card-title">Assigned To Users:</div>-->
<!--                                            <button v-for="user in getLead.assigned_users" :key='user.id' type="button" class="btn btn-success m-1">-->
<!--                                                {{user.name}} <span @click="removeValue(user, 'user')" class="badge badge-dark">x</span>-->
<!--                                            </button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label >Remarks</label>
                                        <textarea class="form-control" v-model="getLead.remarks" rows="5"></textarea>
                                        <span v-if="getErrors.remarks !== ''" class="text-danger">{{getErrors.remarks}}</span>
                                    </div>
                                </div>
                            </div>
                            <submit-button v-if="!isEditable" status="Add"> </submit-button>
                            <submit-button v-else status="Update"> </submit-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from "vuex";
    export default {
        data() {
            return {
                lead: {},
                users : [],
                searchUser : '',
                // projects : [],
                selectedParent : ''
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "getLead", "getActiveFilteredUsers"]),

            isEditable(){
                return !!(this.$route.params.id)
            },

            leadStatusParent(){
                return this.getLead.lead_statuses.filter(lead_status => lead_status.parent_id == null);
            },

            leadStatusSubParent(){
                return this.getLead.lead_statuses.filter(lead_status => lead_status.parent_id == this.selectedParent);
            },

            showUsersDropdown(){
                return this.searchUser.length >= 1;
            },
        },
        // watch : {
        //     getLead(){
        //         for(let i = 0;i < this.getLead.projects.length; i++){
        //             this.projects.push(this.getLead.projects[i]);
        //         }
        //     }
        // },
        created() {
            this.lead = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            if(!this.isEditable) {
                this.selectedParent = '';
                this.$store.commit("setLead");
                this.$store.dispatch("fetchCreateLead");
            } else {
                this.$store.dispatch("fetchEditLead", this.$route.params.id);
            }
        },
        methods: {
            isDuplicate(data, dataArray) {
                for(var i = 0; i < dataArray.length; i++){
                    if(data.id == dataArray[i].id) {
                        return true;
                    }
                }
                return false;
            },
            removeValue(data){
                this.getLead.assigned_users.splice(this.getLead.assigned_users.indexOf(data), 1);
            },
            appendValue(data)
            {
                if(!this.isDuplicate(data, this.getLead.assigned_users)){
                    this.getLead.assigned_users.push(data);
                };
                this.searchUser = '';
            },
            getLiveSearch(){
                if(this.showUsersDropdown) {
                    this.$store.dispatch("fetchAllActiveFilteredUsers",
                        {
                            'table': 'users',
                            'column': 'name',
                            'search': this.searchUser
                        }
                    );
                }
            },
            createLead() {
                this.$store.dispatch("dispatchCreateLead",this.getLead);
            },
            reset() {
                this.lead = {};
                this.users = [];
                this.searchUser = '';
                //resetting errors and error messages
                this.$store.dispatch('setResetData');
                if(!this.isEditable){
                this.selectedParent = '';
                    this.$store.commit("setLead");
                this.$store.dispatch("fetchCreateLead");
                } else {
                    this.$store.dispatch("fetchEditLead", this.$route.params.id);
                }
            }
        }
    };
</script>
