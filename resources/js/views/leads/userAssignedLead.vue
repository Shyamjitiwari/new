<template>
    <div>
        <page-title
            :title="'Assigned Leads (Count : ' + this.getUserAssignedLeadsCount + ')'"
            :title_links='title_links'
            :click_links='click_links'
            :reload="reload"
        >
        </page-title>
        <div class="col btn-toolbar card text-left">
            <div class=" p-1" v-if="getSearchFilter">
                <form id="search_form" @submit.prevent="withSearch(search)">
                    <div class="row">
                        <div class="input-field">
                            <input
                                placeholder="Lead Name..."
                                id="name"
                                name="name"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <input
                                placeholder="Email..."
                                id="email"
                                name="email"
                                v-model="search.email"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <input
                                placeholder="Mobile..."
                                id="mobile"
                                name="mobile"
                                v-model="search.mobile"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field" title="Follow Up Date">
                            <input
                                placeholder="Follow Up Date..."
                                id="follow_up_at"
                                name="follow_up_at"
                                v-model="search.follow_up_at"
                                type="date"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <input
                                placeholder="Search Remarks..."
                                id="remarks"
                                name="remarks"
                                v-model="search.remarks"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <input
                                placeholder="Lead Source..."
                                id="lead_source"
                                name="lead_source"
                                v-model="search.lead_source"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <input
                                placeholder="Lead Status..."
                                id="lead_status"
                                name="lead_status"
                                v-model="search.lead_status"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field" v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 ||hasPermission['role'] === 3">
                            <input
                                placeholder="Lead Owner..."
                                id="lead_owner"
                                name="lead_owner"
                                v-model="search.lead_owner"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field" title="Created Date">
                            <input
                                id="created_at"
                                name="created_at"
                                v-model="search.created_at"
                                type="date"
                                class="form-control validate form-control-sm"
                            />
                        </div>
<!--                        <div class="input-field">-->
<!--                            <date-picker format="DD-MM-YYYY" @change="updateDateRange(time)" v-model="time" range></date-picker>-->
<!--                        </div>-->

                        <div class="input-field">
                            <button
                                title="Filter"
                                class="btn btn-sm btn-outline-primary"
                                type="submit"
                            >Search</button>
                            <button
                                type="button"
                                @click="reset()"
                                title="Reset Search"
                                class="btn btn-sm btn-outline-danger"
                            >Reset</button>&nbsp;
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <bulk-action-leads v-if="showBulkAction" :leads="selectedLeads" @unSelectLeads="unSelectLeads"> </bulk-action-leads>
        <div class="row">
            <div class="col">
                <!-- Listing all leads -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                             <span data-toggle="collapse" href="#dailyReports">
                                <h5 class="cursor-pointer">Today's Followup</h5>
                            </span>
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Project</th>
                                    <th>Follow Up</th>
                                    <th>Source</th>
                                    <th colspan="2" class="text-center">Status</th>
                                    <th v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 ||hasPermission['role'] === 3">Owner</th>
                                    <th v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 ||hasPermission['role'] === 3">Assigned User</th>
                                    <th>Created</th>
                                    <th>Asssigned</th>
                                </tr>
                                </thead>
                                <tbody class="collapse multi-collapse" id="dailyReports">                               
                                    <tr class="font-weight-bolder bg-warning" v-for="lead in getUserAssignedLeadsForToday" :key="lead.id" v-if="getUserAssignedLeadsForToday.length">
                                    <td></td>
                                    <td>
                                        <b-dropdown variant="link" toggle-class="text-decoration-none" no-caret >

                                            <b-dropdown-item v-if="!lead.parent_id" @click="updateLeadStatus(lead)">Snooze</b-dropdown-item>
                                            <b-dropdown-item v-else @click="updateLeadStatus(lead.parent)">Snooze</b-dropdown-item>

                                            <b-dropdown-item v-if="!lead.parent_id" @click="updateLeadStatusWithRemarks(lead)">Update Status</b-dropdown-item>
                                            <b-dropdown-item v-else @click="updateLeadStatusWithRemarks(lead.parent)">Update Status</b-dropdown-item>

                                            <b-dropdown-item v-if="!lead.parent_id" @click="updateLeadProjects(lead)">Update Project</b-dropdown-item>
                                            <b-dropdown-item v-else @click="updateLeadProjects(lead.parent)">Update Project</b-dropdown-item>

                                            <b-dropdown-item v-if="!lead.parent_id" :to="{ name: 'leads.edit', params: { id: lead.id }}">Edit</b-dropdown-item>
                                            <b-dropdown-item v-else :to="{ name: 'leads.edit', params: { id: lead.parent.id }}">Edit</b-dropdown-item>

                                            <b-dropdown-item v-if="lead.parent_id" :to="{ name: 'leads.show', params: { id: lead.parent_id }}">View</b-dropdown-item>
                                            <b-dropdown-item v-else :to="{ name: 'leads.show', params: { id: lead.id }}">View</b-dropdown-item>

                                            <b-dropdown-item v-if="hasPermission['delete-leads'] && !lead.parent_id" :to="{ name: 'leads.delete', params: { id: lead.id }}">Delete</b-dropdown-item>
                                            <b-dropdown-item v-else-if="hasPermission['delete-leads']" :to="{ name: 'leads.delete', params: { id: lead.parent.id }}">Delete</b-dropdown-item>

                                        </b-dropdown>
                                    </td>
                                    <td>
                                        <span title="Leads for today"><i class="material-icons text-success fs-1_5">access_alarm</i></span>
                                    </td>
                                    <td :title="lead.email">
                                        <span @dblclick="dblClickSearch(lead.name, 'name')" v-if="!lead.parent_id">{{lead.name}}</span>
                                        <span @dblclick="dblClickSearch(lead.parent.name, 'name')" v-else>{{lead.parent.name}}</span>
                                    </td>
                                    <td>
                                        <span @dblclick="dblClickSearch(lead.mobile, 'mobile')" v-if="!lead.parent_id">{{lead.mobile}}</span>
                                        <span @dblclick="dblClickSearch(lead.parent.mobile, 'mobile')" v-else>{{lead.parent.mobile}}</span>
                                    </td>
                                    <td :title="'Budget: '+lead.budget+' Type: '+lead.project_type">
                                        <span v-if="lead.project" :title="lead.project">{{lead.project | truncate}}...</span>
                                    </td>
                                    <td>
                                        <span v-if="!lead.parent_id">{{lead.follow_up_at}}</span>
                                        <span v-else>{{lead.parent.follow_up_at}}</span>
                                    </td>
                                    <td>
                                        <span @dblclick="dblClickSearch(lead.lead_source.name, 'lead_source')" v-if="!lead.parent_id">
                                            {{lead.lead_source.name}}
                                        </span>
                                        <span @dblclick="dblClickSearch(lead.parent.lead_source.name, 'lead_source')" v-else>
                                            {{lead.parent.lead_source.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span @click="showLeadHistory(lead)" title="View Lead History">
                                            <i class="material-icons text-success">visibility</i>
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            v-if="!lead.parent_id" class="label-status text-uppercase"
                                            @dblclick="dblClickSearch(lead.lead_status.name, 'lead_status')"
                                            :style="{ color: lead.lead_status.text, background: lead.lead_status.bg }">
                                            {{lead.lead_status.name}}
                                         </span>
                                        <span
                                            v-else
                                            @dblclick="dblClickSearch(lead.parent.lead_status.name, 'lead_status')"
                                            class="label-status text-uppercase"
                                            :style="{ color: lead.parent.lead_status.text, background: lead.parent.lead_status.bg }">
                                            {{lead.parent.lead_status.name}}
                                         </span>
                                    </td>
                                    <td v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 || hasPermission['role'] === 3">
                                        <span v-if="!lead.parent_id && lead.created_by" class="text-capitalize" @dblclick="dblClickSearch(lead.created_by.name, 'lead_owner')">
                                            {{lead.created_by.name}}
                                            <span v-if="hasPermission['transfer-owner-leads']"><i class="material-icons text-warning" @click="changeLeadOwner(lead)">edit</i></span>
                                        </span>
                                        <span v-else-if="lead.parent_id && lead.parent.created_by" class="text-capitalize" @dblclick="dblClickSearch(lead.parent.created_by.name, 'lead_owner')">
                                            {{lead.parent.created_by.name}}
                                            <span v-if="hasPermission['transfer-owner-leads']"><i class="material-icons text-warning" @click="changeLeadOwner(lead.parent)">edit</i></span>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                      <td v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 || hasPermission['role'] === 3">
                                        <span class="text-capitalize" v-for="(assigned_user,index) in lead.assigned_users" :key="index">
                                            {{assigned_user.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{lead.created_at}}</span>
                                    </td>
                                    <td>{{lead.assigned_at}}</td>
                                </tr>
                                </tbody>
                                <tbody>
                                <tr
                                    v-for="(lead) in getUserAssignedLeads.data" :key="lead.id"
                                    :class="{'bg-lightgrey' : lead.parent_id}"
                                >
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input v-model="selectedLeads" type="checkbox" class="custom-control-input" :value="lead.id" :id="lead.id">
                                            <label class="custom-control-label" :for="lead.id"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <b-dropdown variant="link" toggle-class="text-decoration-none" no-caret >

                                            <b-dropdown-item v-if="!lead.parent_id" @click="updateLeadStatus(lead)">Snooze</b-dropdown-item>
                                            <b-dropdown-item v-else @click="updateLeadStatus(lead.parent)">Snooze</b-dropdown-item>

                                            <b-dropdown-item v-if="!lead.parent_id" @click="updateLeadStatusWithRemarks(lead)">Update Status</b-dropdown-item>
                                            <b-dropdown-item v-else @click="updateLeadStatusWithRemarks(lead.parent)">Update Status</b-dropdown-item>

                                            <b-dropdown-item v-if="!lead.parent_id" @click="updateLeadProjects(lead)">Update Project</b-dropdown-item>
                                            <b-dropdown-item v-else @click="updateLeadProjects(lead.parent)">Update Project</b-dropdown-item>

                                            <b-dropdown-item v-if="!lead.parent_id" :to="{ name: 'leads.edit', params: { id: lead.id }}">Edit</b-dropdown-item>
                                            <b-dropdown-item v-else :to="{ name: 'leads.edit', params: { id: lead.parent.id }}">Edit</b-dropdown-item>

                                            <b-dropdown-item v-if="lead.parent_id" :to="{ name: 'leads.show', params: { id: lead.parent_id }}">View</b-dropdown-item>
                                            <b-dropdown-item v-else :to="{ name: 'leads.show', params: { id: lead.id }}">View</b-dropdown-item>

                                            <b-dropdown-item v-if="hasPermission['delete-leads'] && !lead.parent_id" :to="{ name: 'leads.delete', params: { id: lead.id }}">Delete</b-dropdown-item>
                                            <b-dropdown-item v-else-if="hasPermission['delete-leads']" :to="{ name: 'leads.delete', params: { id: lead.parent.id }}">Delete</b-dropdown-item>

                                        </b-dropdown>
                                    </td>
                                    <td>
                                        <span
                                            @click="showGroupedLeads(lead.parent)"
                                            v-if="lead.parent_id"
                                            title="Repeating Count"
                                            style="cursor:pointer"
                                            class="badge badge-warning p-1">
                                            {{lead.parent.children_count + 1}}
                                        </span>
                                        <span v-else title="New Lead"><i class="material-icons text-success fs-1_5">fiber_new</i></span>
                                    </td>
                                    <td :title="lead.email">
                                        <span @dblclick="dblClickSearch(lead.name, 'name')" v-if="!lead.parent_id">{{lead.name}}</span>
                                        <span @dblclick="dblClickSearch(lead.parent.name, 'name')" v-else>{{lead.parent.name}}</span>
                                    </td>
                                    <td>
                                        <span @dblclick="dblClickSearch(lead.mobile, 'mobile')" v-if="!lead.parent_id">{{lead.mobile}}</span>
                                        <span @dblclick="dblClickSearch(lead.parent.mobile, 'mobile')" v-else>{{lead.parent.mobile}}</span>
                                    </td>
                                    <td :title="'Budget: '+lead.budget+' Type: '+lead.project_type">
                                        <span v-if="lead.project" :title="lead.project">{{lead.project | truncate}}...</span>
                                    </td>
                                    <td>
                                        <span v-if="!lead.parent_id">{{lead.follow_up_at}}</span>
                                        <span v-else>{{lead.parent.follow_up_at}}</span>
                                    </td>
                                    <td>
                                        <span @dblclick="dblClickSearch(lead.lead_source.name, 'lead_source')" v-if="!lead.parent_id">
                                            {{lead.lead_source.name}}
                                        </span>
                                        <span @dblclick="dblClickSearch(lead.parent.lead_source.name, 'lead_source')" v-else>
                                            {{lead.parent.lead_source.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span @click="showLeadHistory(lead)" title="View Lead History">
                                            <i class="material-icons text-success">visibility</i>
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            v-if="!lead.parent_id" class="label-status text-uppercase"
                                            @dblclick="dblClickSearch(lead.lead_status.name, 'lead_status')"
                                            :style="{ color: lead.lead_status.text, background: lead.lead_status.bg }">
                                            {{lead.lead_status.name}}
                                         </span>
                                        <span
                                            v-else
                                            @dblclick="dblClickSearch(lead.parent.lead_status.name, 'lead_status')"
                                            class="label-status text-uppercase"
                                            :style="{ color: lead.parent.lead_status.text, background: lead.parent.lead_status.bg }">
                                            {{lead.parent.lead_status.name}}
                                         </span>
                                    </td>
                                    <td v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 || hasPermission['role'] === 3">
                                        <span v-if="!lead.parent_id && lead.created_by" class="text-capitalize" @dblclick="dblClickSearch(lead.created_by.name, 'lead_owner')">
                                            {{lead.created_by.name}}
                                            <span v-if="hasPermission['transfer-owner-leads']"><i class="material-icons text-warning" @click="changeLeadOwner(lead)">edit</i></span>
                                        </span>
                                        <span v-else-if="lead.parent_id && lead.parent.created_by" class="text-capitalize" @dblclick="dblClickSearch(lead.parent.created_by.name, 'lead_owner')">
                                            {{lead.parent.created_by.name}}
                                            <span v-if="hasPermission['transfer-owner-leads']"><i class="material-icons text-warning" @click="changeLeadOwner(lead.parent)">edit</i></span>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                    <td v-if="hasPermission['role'] === 1 || hasPermission['role'] === 2 || hasPermission['role'] === 3">
                                        <span class="text-capitalize label-status bg-primary text-white" v-for="(assigned_user,index) in lead.assigned_users" :key="index">
                                            {{assigned_user.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{lead.created_at}}</span>
                                    </td>
                                    <td>
                                        <span>{{lead.assigned_at}} </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
                <pagination show=4 :data="getUserAssignedLeads" @updatePagination="updatePagination"> </pagination>
            </div>
        </div>
        <b-modal id="updateLeadStatus" :title="'Update Lead : '+ lead.name">
            <update-lead-status snooze=true modal=true :search="search" :lead="lead" @hideModal="hideModal"> </update-lead-status>
            <!-- disabling modal footer-->
            <template v-slot:modal-footer><b></b></template>
        </b-modal>
        <b-modal id="changeLeadOwner" :title="'Change Owner : '+ lead.name">
            <change-lead-owner modal=true :search="search" :lead_id="lead.id" @hideModal="hideModalChangeLeadOwner"> </change-lead-owner>
            <template v-slot:modal-footer><b></b></template>
        </b-modal>
        <b-modal id="updateLeadStatusWithRemarks" :title="'Lead Status : '+ lead.name">
            <update-lead-status-with-remarks modal=true :search="search" :lead="lead" @hideModalAll="hideModalAll"> </update-lead-status-with-remarks>
            <template v-slot:modal-footer><b></b></template>
        </b-modal>
        <b-modal id="updateLeadProjects" :title="'Lead Projects : '+ lead.name">
            <update-lead-projects modal=true :search="search" :lead="lead" @hideModalAll="hideModalAll"> </update-lead-projects>
            <template v-slot:modal-footer><b></b></template>
        </b-modal>
        <b-modal id="leadChildren" title="List of Grouped Leads">
            <lead-children :lead="lead"> </lead-children>
            <template v-slot:modal-footer><b></b></template>
        </b-modal>
        <b-modal id="leadHistory" title="Status History">
            <show-lead-status-history :lead="lead"> </show-lead-status-history>
            <template v-slot:modal-footer><b></b></template>
        </b-modal>

    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import UpdateLeadStatus from "../../components/UpdateLeadStatus";
    import changeLeadOwner from "../../components/changeLeadOwner";
    import BulkActionLeads from "../../components/BulkActionLeads";
    import UpdateLeadStatusWithRemarks from "../../components/UpdateLeadStatus";
    import UpdateLeadProjects from "../../components/UpdateProjects";
    import LeadChildren from "../../components/LeadChildren";
    import ShowLeadStatusHistory from "../../components/ShowLeadStatusHistory";

    export default {
        components : {
            ShowLeadStatusHistory, UpdateLeadStatus,DatePicker,changeLeadOwner,BulkActionLeads,
            UpdateLeadStatusWithRemarks,UpdateLeadProjects,LeadChildren
        },
        data() {
            return {
                title_links : [
                    {router_name : 'leads.create', router_hover : 'Add Lead', type : 'icon', icon:'add', class : 'text-success'},
                ],
                click_links : [
                    {click_event: 'importLeads', click_hover : 'Import Leads', type : 'icon', icon:'file_upload', class : 'text-success'},
                ],
                lead: {},
                pagination: {},
                search : {
                    name: "",
                    mobile: "",
                    email: "",
                    follow_up_at : "",
                    remarks: "",
                    lead_source: "",
                    lead_status: "",
                    lead_owner : "",
                    created_at: ""
                },
                time : null,
                selectedLeads : [],
                showSnoozeLeads : false,
                // selectAllLeads : false,
            };
        },

        computed: {
            ...mapGetters(["getUserAssignedLeads", "getErrors", "getSearchFilter", 'getAuth', 'getUserAssignedLeadsCount', 'hasPermission', 'getUserAssignedLeadsForToday']),

            reload(){
                return {type : 'fetchUserAssignedLeads', payload : {next_page: this.getUserAssignedLeads.current_page, search: this.search}};
            },
            showBulkAction(){
                if(this.selectedLeads.length > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            //use this line on pages where update lead status component is being used
            this.$store.dispatch("fetchActiveLeadStatuses");
            this.$store.dispatch("fetchUserAssignedLeads", {
                next_page: this.getUserAssignedLeads.current_page,
                search: this.search
            });
        },

        methods: {
            showGroupedLeads(lead){
                this.lead = lead;
                this.$bvModal.show('leadChildren');
            },
            showLeadHistory(lead){
                this.lead = lead;
                this.$bvModal.show('leadHistory');
            },
            updateLeadStatusWithRemarks(lead){
                this.lead = lead;
                this.$bvModal.show('updateLeadStatusWithRemarks');
            },
            updateLeadProjects(lead){
                this.lead = lead;
                this.$bvModal.show('updateLeadProjects');
            },
            hideModalAll(modal_id){
                this.$bvModal.hide(modal_id);
            },
            hideModal(){
                this.$bvModal.hide('updateLeadStatus');
            },
            unSelectLeads(){
                this.selectedLeads = [];
            },
            changeLeadOwner(lead){
                this.lead = lead;
                this.$bvModal.show('changeLeadOwner');
            },
            hideModalChangeLeadOwner(){
                this.$bvModal.hide('changeLeadOwner');
            },
            updateDateRange(time)
            {
              // this.search.date_range = time;
            },
            dblClickSearch(value, field)
            {
                this.$store.commit('setSearchFilterShowAlways');
                //show search bar
                if(field === 'name')
                {
                    this.search.name = value;
                }
                else if(field === 'email')
                {
                    this.search.email = value;
                }
                else if(field === 'mobile')
                {
                    this.search.mobile = value;
                }
                else if(field === 'follow_up_at')
                {
                    this.search.follow_up_at =  value;
                }
                else if(field === 'remarks')
                {
                    this.search.remarks = value;
                }
                else if(field === 'lead_owner')
                {
                    this.search.lead_owner = value;
                }
                else if(field === 'lead_source')
                {
                    this.search.lead_source = value;
                }
                else if(field === 'lead_status')
                {
                    this.search.lead_status = value;
                }
                this.withSearch(this.search)
            },
            updateLeadStatus(lead){
              this.lead = lead;
                this.$bvModal.show('updateLeadStatus');
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchUserAssignedLeads", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchUserAssignedLeads", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.showSnoozeLeads = false;
                this.$router.push({ name: 'userAssignedLeads'});
                this.search =  {
                    name: "",
                    mobile: "",
                    email: "",
                    follow_up_at : "",
                    remarks: "",
                    lead_source: "",
                    lead_status: "",
                    lead_owner : "",
                    created_at: ""
                };
                this.$store.dispatch("fetchUserAssignedLeads", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
