<template>
    <div>
        <page-title
            :title="'Edit Project: '+ getProject.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editProject" @submit.prevent="editProject" enctype="multipart/form-data">
                             <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="getProject.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="nearby_location_id">Select Location</label>
                                        <select class="form-control" v-model="getProject.location_id">
                                            <option  value="">Select Location</option>
                                            <option v-for="location in getLocations" :value="location.id" :key="location.id">{{location.name}}</option>
                                        </select>
                                        <span v-if="getErrors.location_id !== ''" class="text-danger">{{getErrors.location_id}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="nearby_location_id">Select Builder</label>
                                        <select class="form-control" v-model="getProject.builder_id">
                                            <option value="">Select Builder</option>
                                            <option v-for="builder in getBuildersActive" :value="builder.id" :key="builder.id">{{builder.name}}</option>
                                        </select>
                                        <span v-if="getErrors.builder_id !== ''" class="text-danger">{{getErrors.builder_id}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="nearby_location_id">NearBy Location</label>
                                        <select class="form-control" v-model="getProject.nearby_location_id">
                                            <option value="">Select Nearby Location</option>
                                            <option v-for="location in getLocations" :value="location.id" :key="location.id">{{location.name}}</option>
                                        </select>
                                        <span v-if="getErrors.nearby_location_id !== ''" class="text-danger">{{getErrors.nearby_location_id}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="completion_status">Completion Status</label>
                                        <input
                                            type="text"
                                            v-model="getProject.completion_status"
                                            class="form-control"
                                            id="completion_status"
                                            placeholder="Completion Status..."
                                        />
                                        <span v-if="getErrors.completion_status !== ''" class="text-danger">{{getErrors.completion_status}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input
                                            type="text"
                                            v-model="getProject.city"
                                            class="form-control"
                                            id="city"
                                            placeholder="City..."
                                        />
                                        <span v-if="getErrors.city !== ''" class="text-danger">{{getErrors.city}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input
                                            type="text"
                                            v-model="getProject.state"
                                            class="form-control"
                                            id="state"
                                            placeholder="State..."
                                        />
                                        <span v-if="getErrors.state !== ''" class="text-danger">{{getErrors.state}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="pincode">Pin Code</label>
                                        <input
                                            type="text"
                                            v-model="getProject.pincode"
                                            class="form-control"
                                            id="pincode"
                                            placeholder="Pin Code..."
                                        />
                                        <span v-if="getErrors.pincode !== ''" class="text-danger">{{getErrors.pincode}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="possession">Possession</label>
                                        <input
                                            type="date"
                                            v-model="getProject.possession"
                                            class="form-control"
                                            id="possession"
                                            placeholder="Possesion..."
                                        />
                                        <span v-if="getErrors.possession !== ''" class="text-danger">{{getErrors.possession}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="distance_in_kms">Distance (in kms)</label>
                                        <input
                                            type="text"
                                            v-model="getProject.distance_in_kms"
                                            class="form-control"
                                            id="distane_in_kms"
                                            placeholder="Distannce (kms)..."
                                        />
                                        <span v-if="getErrors.distance_in_kms !== ''" class="text-danger">{{getErrors.distance_in_kms}}</span>
                                    </div>
                                </div>
                                </div>
                            <div class="row">


                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea
                                            type="text"
                                            v-model="getProject.address"
                                            class="form-control"
                                            id="address"
                                            placeholder="Address..."
                                        ></textarea>
                                        <span v-if="getErrors.address !== ''" class="text-danger">{{getErrors.address}}</span>
                                    </div>
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
                project: {},
                projecttypes: ["admin", "project"],
                title_links : [
                    {router_name : 'projects.create', router_params: '', router_hover : 'Add Project', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'projects.show', router_params: this.$route.params.id, router_hover : 'Show Project', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditProject', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getProject", "getErrors", "getLocations", "getBuildersActive", "getMessage"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditProject", this.$route.params.id);
            this.$store.dispatch("fetchAllActiveLocations");
            this.$store.dispatch("fetchAllActiveBuilders");
        },
        methods: {
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.project.image_name = e.target.result;
                }
            },
            editProject() {
                let self = this;
                self.$store.dispatch("dispatchEditProject",self.getProject)
                ;
            }
        }
    };
</script>
