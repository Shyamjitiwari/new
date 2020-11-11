<template>
    <div style="position: relative; min-height: 100vh;">
        <div class="row mb-1">
            <div class="col">
               <div class="card">
                   <div class="card-body">
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
                                               placeholder="Phone..."
                                               id="phone"
                                               name="phone"
                                               v-model="search.phone"
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
                                               placeholder="Lead Status..."
                                               id="lead_status"
                                               name="lead_status"
                                               v-model="search.lead_status"
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
                                       <button v-if="!loading" title="Filter" class="btn btn-sm btn-outline-primary" type="submit">Search</button>
                                       <loader-button v-else bg="btn-sm btn-outline-primary text-primary" title="Loading..."> </loader-button>
                                       <button type="button" @click="reset()" title="Reset Search" class="btn btn-sm btn-outline-danger">Reset</button>&nbsp;
                                       <button type="button" @click="showPopup({tags:[]})" title="Add Lead" class="btn btn-sm btn-outline-success">Add</button>&nbsp;

                                       <button type="button" title="More filters" class="btn btn-sm btn-outline-success">
                                           <i class="fa fa-caret-up"></i>
                                       </button>&nbsp;
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Student</th>
                                    <th>Tags</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Form Submitted</th>
                                    <th>Free Session On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="lead in leads.data">
                                    <td class="text-capitalize"
                                        @dblclick="dblClickSearch(lead.name, 'name')"
                                    >{{lead.name}}</td>
                                    <td @dblclick="dblClickSearch(lead.phone_number, 'phone')">{{lead.phone_number}}</td>
                                    <td @dblclick="dblClickSearch(lead.email, 'email')">{{lead.email}}</td>
                                    <td>
                                        <span v-if="lead.student_id">{{lead.student_id}}</span>
                                        <span v-else>-</span>
                                    </td>
                                    <td>
                                        <span v-if="lead.tags.length">
                                            <span class="badge badge-primary m-1" v-for="tag in lead.tags">{{tag.name}}</span>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                    <td>
                                        <span
                                                @dblclick="dblClickSearch(lead.lead_status.name, 'lead_status')"
                                                class="p-1 text-uppercase"
                                                :style="{ color: lead.lead_status.text, background: lead.lead_status.bg }">
                                            {{lead.lead_status.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="p-1 bg-success text-white" v-for
                                              @dblclick="dblClickSearch(lead.lead_source.name, 'lead_source')"
                                        >{{lead.lead_source.name}}</span>
                                    </td>
                                    <td>{{lead.form_submitted_at}}</td>
                                    <td>{{lead.free_session_date}}</td>
                                    <td>
                                        <i title="Edit" style="cursor: pointer" class="mdi mdi-grease-pencil text-warning" @click="showPopup(lead)"></i>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination show=4 :data="leads" @updatePagination="updatePagination"> </pagination>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showPopUp" style="position: absolute; top:0px; box-shadow: 0 1px 8px 5px lightgrey; border-radius: 5px; width:100%">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="close" @click="closePopUp">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <add-lead @closePopUp="closePopUp" :lead="lead"> </add-lead>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                showPopUp : false,
                loading: false,
                leads : [],
                lead : {
                    tags : []
                },
                pagination: {},
                getSearchFilter : true,
                search : {
                    name: '',
                    email: '',
                    phone: '',
                    lead_status: '',
                    lead_source: '',
                }
            }
        },
        computed:{
        },
        created() {
            this.getLeads();
        },
        methods:{
            showPopup(lead){
                this.lead = lead;
                console.log(this.lead);
                this.showPopUp = !this.showPopUp;
            },
            closePopUp(){
                this.showPopUp = false;
                this.getLeads();
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.getLeads();
            },
            getLeads()
            {
                let _this = this;
                _this.loading = true;
                axios.get('/admin/leads' +
                    '?page=' +_this.pagination.current_page +
                    "&name=" + _this.search.name +
                    "&email=" + _this.search.email +
                    "&phone=" + _this.search.phone +
                    "&lead_source=" + _this.search.lead_source +
                    "&lead_status=" + _this.search.lead_status
                ).then(function(response)
                {
                    _this.leads = response.data.data;
                    _this.loading = false;
                })
            },
            withSearch(s) {
                this.search = s;
                this.pagination.current_page = 1
                this.getLeads();
            },
            reset() {
                this.search =  {
                    name: "",
                    phone: "",
                    email: "",
                    lead_source: "",
                    lead_status: "",
                };
                this.getLeads();
            },
            dblClickSearch(value, field)
            {
                if(field === 'name')
                {
                    this.search.name = value;
                }
                else if(field === 'email')
                {
                    this.search.email = value;
                }
                else if(field === 'phone')
                {
                    this.search.phone = value;
                }
                else if(field === 'description')
                {
                    this.search.description = value;
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
        }
    }
</script>