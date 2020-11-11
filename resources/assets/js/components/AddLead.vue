<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <span v-if="!isEditable"> Add Lead </span>
                    <span v-else> Edit Lead </span>
                    <div class="card-body m-0">
                        <form id="createLead" @submit.prevent="createLead()">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input
                                                type="text"
                                                v-model="lead.name"
                                                class="form-control"
                                                id="name"
                                                placeholder="Name..."
                                                required
                                        />
                                        <span v-if="formErrors.name !== ''" class="text-danger">{{formErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                        <input
                                                type="text"
                                                v-model="lead.phone_number"
                                                class="form-control"
                                                id="phone_number"
                                                placeholder="Phone Number..."
                                                required
                                        />
                                        <span v-if="formErrors.phone_number !== ''" class="text-danger">{{formErrors.phone_number}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input
                                                type="email"
                                                v-model="lead.email"
                                                class="form-control"
                                                id="email"
                                                placeholder="Email..."
                                        />
                                        <span v-if="formErrors.email !== ''" class="text-danger">{{formErrors.email}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md col-sm-12" v-if="!isEditable">
                                    <div class="form-group">
                                        <label >Lead Source <span class="text-danger">*</span></label>
                                        <select required class="form-control" v-model="lead.lead_source_id">
                                            <option v-for="lead_source in lead_sources" :key=lead_source.id :value="lead_source.id">{{lead_source.name}}</option>
                                        </select>
                                        <span v-if="formErrors.lead_source_id !== ''" class="text-danger">{{formErrors.lead_source_id}}</span>
                                    </div>
                                </div>
                                <div class="col-md col-sm-12" v-if="!isEditable">
                                    <div class="form-group">
                                        <label>Lead Status <span class="text-danger">*</span></label>
                                        <select required class="form-control" v-model="lead.lead_status_id">
                                            <option v-for="lead_status in lead_statuses" :key=lead_status.id :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div :class="{'col-md col-sm-12' : !isEditable, 'col' : isEditable}">
                                    <div class="form-group position-relative">
                                        <label>Selected Tags </label>
                                        <input placeholder="Min 1 letter..." @keyup="getLiveSearch()" v-model.trim="searchTag" class="form-control" type="text">
                                        <div v-if="showTagsDropdown" class="dropdown-menu show" style="min-width: 100%">
                                            <a @click="appendValue(tag, 'tag')" v-for="tag in tags"
                                            :key='tag.id'
                                            class="dropdown-item">{{tag.name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col bb-1">
                                    <div class="card" style="border:0px;">
                                        <div class="card-panel">
                                            <div class="card-title">Add Tags:</div>
                                            <button v-for="tag in lead.tags" :key='tag.id' type="button" class="btn btn-success m-1">
                                                {{tag.name}} <span @click="removeValue(tag, 'tag')" class="badge badge-dark">x</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label >Notes</label>
                                        <textarea class="form-control" v-model="lead.description" rows="5"></textarea>
                                        <span v-if="formErrors.description !== ''" class="text-danger">{{formErrors.description}}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" v-if="!isEditable && !loading"> Add </button>
                            <button type="submit" class="btn btn-warning" v-else-if="isEditable && !loading"> Update </button>
                            <loader-button bg="btn-dark text-white" title="Processing..." v-else-if="loading"> </loader-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
                            <button type="button" class="btn btn-info" v-on:click="closePopUp()">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['lead'],
        data() {
            return {
                formErrors : {},
                message : '',
                loading : false,
                tags : [],
                lead_statuses : [],
                lead_sources : [],
                searchTag : '',
            };
        },
        computed: {
            isEditable(){
                console.log(this.lead.id);
                return this.lead.id;
            },

            showTagsDropdown(){
                return this.searchTag.length >= 1;
            },

        },
        created() {
            this.formErrors = {};
            this.getData();
        },
        methods: {
            closePopUp(){
                this.$emit('closePopUp');
            },
            getData()
            {
                let _this = this;
                axios.post('/admin/get-all-active', {'table' : 'lead_statuses'}).then(function(response)
                {
                    _this.lead_statuses = response.data.data;
                })

                axios.post('/admin/get-all-active', {'table' : 'lead_sources'}).then(function(response)
                {
                    _this.lead_sources = response.data.data;
                })
            },
            isDuplicate(data, dataArray) {
                if(dataArray.length) {
                    for (var i = 0; i < dataArray.length; i++) {
                        if (data.id == dataArray[i].id) {
                            return true;
                        }
                    }
                }
                return false;
            },
            removeValue(data){
                this.lead.tags.splice(this.lead.tags.indexOf(data), 1);
            },
            appendValue(data)
            {
                if(!this.isDuplicate(data, this.lead.tags)){
                    this.lead.tags.push(data);
                }
                this.searchTag = '';
            },
            getLiveSearch()
            {
                let _this = this;
                if(_this.showTagsDropdown) {
                    axios.post('/admin/get-all-active-filtered', {'table' : 'tags', 'column' : 'name', 'search':_this.searchTag}).then(function(response)
                    {
                        _this.tags = response.data.data;
                    })
                }
            },
            createLead() {
                let _this = this;
                _this.loading = true;
                axios.post('/admin/leads', _this.lead).then(function(response)
                {
                    _this.loading = false;
                    _this.closePopUp();
                })
            },
            reset() {
                this.lead = {};
                this.searchTag = '';
                this.formErrors = {};
                this.message = '';
            }
        }
    };
</script>
