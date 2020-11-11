<template>
    <div>
        <page-title
            :title="'Edit Project Unit: '+ getProjectUnit.type"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editProjectUnit" @submit.prevent="editProjectUnit" enctype="multipart/form-data">
                             <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.type"
                                            class="form-control"
                                            id="type"
                                            placeholder="Type..."
                                        />
                                        <span v-if="getErrors.type !== ''" class="text-danger">{{getErrors.type}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.price"
                                            class="form-control"
                                            id="price"
                                            placeholder="Price..."
                                        />
                                        <span v-if="getErrors.price !== ''" class="text-danger">{{getErrors.price}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="size">Size</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.size"
                                            class="form-control"
                                            id="size"
                                            placeholder="Size..."
                                        />
                                        <span v-if="getErrors.size !== ''" class="text-danger">{{getErrors.size}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Project</label>
                                        <select class="form-control" v-model="getProjectUnit.project_id">
                                            <option disabled selected>Select project</option>
                                            <option v-for="project in getProjects" :value="project.id" :key="project.id">{{project.name}}</option>
                                        </select>
                                          <span v-if="getErrors.project_id !== ''" class="text-danger">{{getErrors.project_id}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="sales_type">Sales Type</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.sales_type"
                                            class="form-control"
                                            id="sales_type"
                                            placeholder="Sales Type..."
                                        />
                                        <span v-if="getErrors.sales_type !== ''" class="text-danger">{{getErrors.sales_type}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="bedroom">Bedroom</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.bedroom"
                                            class="form-control"
                                            id="bedroom"
                                            placeholder="Bedroom..."
                                        />
                                        <span v-if="getErrors.bedroom !== ''" class="text-danger">{{getErrors.bedroom}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="bathroom">Bathroom</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.bathroom"
                                            class="form-control"
                                            id="bathroom"
                                            placeholder="Bathroom..."
                                        />
                                        <span v-if="getErrors.bathroom !== ''" class="text-danger">{{getErrors.bathroom}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="balcony">Balcony</label>
                                        <input
                                            type="text"
                                            v-model="getProjectUnit.balcony"
                                            class="form-control"
                                            id="balcony"
                                            placeholder="Balcony..."
                                        />
                                        <span v-if="getErrors.balcony !== ''" class="text-danger">{{getErrors.balcony}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="additional_room">Additional Room</label>
                                        <input
                                            type="number"
                                            step=".5"
                                            v-model="getProjectUnit.additional_room"
                                            class="form-control"
                                            id="additional_room"
                                            placeholder="Additional Room..."
                                        />
                                        <span v-if="getErrors.additional_room !== ''" class="text-danger">{{getErrors.additional_room}}</span>
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
                projectUnit: {},
                projectUnittypes: ["admin", "projectUnit"],
                title_links : [
                    {router_name : 'projectUnits.create', router_params: '', router_hover : 'Add Project Unit', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'projectUnits.show', router_params: this.$route.params.id, router_hover : 'Show Project Unit', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditProjectUnit', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getProjectUnit", "getErrors", "getMessage", "getLocations", "getProjects"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditProjectUnit", this.$route.params.id);
            this.$store.dispatch("fetchAllActiveProjects");
            this.$store.dispatch("fetchAllActiveLocations");
        },
        methods: {
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.projectUnit.image_name = e.target.result;
                }
            },
            editProjectUnit() {
                let self = this;
                self.$store.dispatch("dispatchEditProjectUnit",self.getProjectUnit)
                ;
            }
        }
    };
</script>
