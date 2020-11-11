import router from "../../router/router";

const state = {
    leads: {},
    leadsForToday: {},
    leads_count : 0,
    lead: {},
    leadCreateData: {},
    leadProjects: [],
    showLeadsImportForm: false,
    leadChildren : [],
};

const getters = {
    getLeadsCount(state) {
        return state.leads_count;
    },
    getLeads(state) {
        return state.leads;
    },
    getLead(state) {
        return state.lead;
    },
    getLeadCreateData(state) {
        return state.leadCreateData;
    },
    getLeadChildren(state) {
        return state.leadChildren;
    },
    getLeadsForToday(state) {
        return state.leadsForToday;
    }
};

const mutations = {
    setLeads(state, payload) {
        state.leads = payload;
        state.leads_count = payload.total;
    },
    setLead(state, payload) {
        state.lead = payload;
    },
    setLeadCreateData(state, payload) {
        state.leadCreateData = payload;
    },
    setLeadsImportStatus(state, payload) {
        state.showLeadsImportForm = !state.showLeadsImportForm;
    },
    setLeadChildren(state, payload) {
        state.leadChildren = payload;
    },
    setLeadsForToday(state, payload) {
        state.leadsForToday = payload;
    }
};

const actions = {
    importLeads(context) {
        $('#importLeadsModal').modal('show')
    },
    dispatchLeadsImport(context, payload){
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "leads-imports",
            data : payload,
            success_callback: function success_callback(response) {
                window.location.href = '#/leads';
            }
        })
    },
    fetchLeadsForToday(context){
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads-for-today",
            success_callback: function success_callback(response) {
                context.commit("setLeadsForToday", response.data.data);
            }
        })
    },
    fetchLeads(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads?page=" +
                payload.next_page +
                "&name=" +
                payload.search.name +
                "&email=" +
                payload.search.email +
                "&mobile=" +
                payload.search.mobile +
                "&follow_up_at=" +
                payload.search.follow_up_at +
                "&remarks=" +
                payload.search.remarks +
                "&lead_source=" +
                payload.search.lead_source +
                "&lead_status=" +
                payload.search.lead_status +
                "&lead_owner=" +
                payload.search.lead_owner +
                "&created_at=" +
                payload.search.created_at,
            success_callback: function success_callback(response) {
                context.commit("setLeads", response.data.data);
            }
        });
        this.dispatch('fetchLeadsForToday');
    },
    fetchShowLead(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads/" + payload,
            success_callback: function success_callback(response) {
                context.commit("setLead", response.data.data);
            }
        })
    },
    fetchEditLead(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads/" + payload + '/edit',
            success_callback: function success_callback(response) {
                context.commit("setLead", response.data.data);
            }
        })
    },

    fetchCreateLead(context, payload) {
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "leads/create",
            success_callback: function success_callback(response) {
                context.commit("setLead", response.data.data);
            }
        })
    },

    dispatchCreateLead(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "leads",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    dispatchEditLead(context, payload) {
        this.dispatch("dispatch_request", {
            method: "PUT",
            url: "leads/" + payload.id,
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    deleteLead(context, payload) {
        this.dispatch("dispatch_request", {
            method: "DELETE",
            url: "leads/" + payload.id,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    changeLeadOwner(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "leads-change-owner",
            data : payload,
            success_callback: function success_callback() {
                context.commit("setLead", response.data.data);
            }
        })
    },
    changeLeadOwnerBulk(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "leads-change-owner-bulk",
            data : payload,
            success_callback: function success_callback() {},
        });
        let _this = this;
        setTimeout(function(){
            _this.dispatch('fetchLeads', {
                next_page: _this.getters.getLeads.current_page,
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
            });
        }, 300);

    },
    assignLeadsBulk(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "leads-assignment-bulk",
            data : payload,
            success_callback: function success_callback(response) {}
        });
        let _this = this;
        setTimeout(function(){
            _this.dispatch('fetchLeads', {
                next_page: _this.getters.getLeads.current_page,
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
            });
        }, 300);
    },
    fetchLeadChildren(context, payload) {
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "lead-children",
            data : payload,
            success_callback: function success_callback(response) {
                context.commit("setLeadChildren", response.data.data.children);
            }
        });
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
