<template>
    <div>
        <page-title
            title="Add Project Unit"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createProjectUnit" @submit.prevent="createProjectUnit(projectUnit)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input
                                            type="text"
                                            v-model="projectUnit.type"
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
                                            v-model="projectUnit.price"
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
                                            v-model="projectUnit.size"
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
                                        <select class="form-control" v-model="projectUnit.project_id">
                                            <option :selected="true" :disabled="true" value="">Select Project</option>
                                            <option v-for="project in getProjects" :value="project.id" :key="project.id">{{project.name}}</option>
                                        </select>
                                        <span v-if="getErrors.project_id !== ''" class="text-danger">{{getErrors.projet_id}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="sales_type">Sales Type</label>
                                        <input
                                            type="text"
                                            v-model="projectUnit.sales_type"
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
                                            v-model="projectUnit.bedroom"
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
                                            v-model="projectUnit.bathroom"
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
                                            v-model="projectUnit.balcony"
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
                                            v-model="projectUnit.additional_room"
                                            class="form-control"
                                            id="additional_room"
                                            placeholder="Additional Room..."
                                        />
                                        <span v-if="getErrors.additional_room !== ''" class="text-danger">{{getErrors.additional_room}}</span>
                                    </div>
                                </div>
                            </div>
                           
                            <submit-button status="Add"> </submit-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
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
                projectUnit: {},
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "hasPermission", "getProjects"])
        },
        created() {
            this.projectUnit = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchAllActiveProjects");
        },
        methods: {
            createProjectUnit(projectUnit) {
                this.$store.dispatch("dispatchCreateProjectUnit",projectUnit);
                this.reset();
            },
            reset() {
                this.projectUnit = {};
                //resetting errors adn error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
