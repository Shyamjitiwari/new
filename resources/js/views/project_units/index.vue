<template>
    <div>
        <page-title
            title="Project Unit"
            :title_links='title_links'
            :reload="reload"
        >
        </page-title>
        <div class="col btn-toolbar card text-left">
            <div class=" p-1" v-if="getSearchFilter">
                <form id="search_form" @submit.prevent="withSearch(search)">
                    <div class="row">
                        <div class="input-field">
                            <input
                                placeholder="Project Unit Type..."
                                id="type"
                                name="type"
                                v-model="search.type"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                        Price Range -
                        <div class="input-field">
                            <input
                                placeholder="Strat Price..."
                                id="start_price"
                                name="start_price"
                                v-model="search.startPrice"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                        To
                        <div class="input-field">
                            <input
                                placeholder="End Price..."
                                id="end_price"
                                name="end_price"
                                v-model="search.endPrice"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                        <div class="input-field">
                            <input
                                placeholder="Size..."
                                id="size"
                                name="size"
                                v-model="search.size"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>

                        <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.location"
                                name="search_location"
                                id="search_location"
                            >
                                <option selected value="">Select Location</option>
                                <option v-for="location in getLocations" :value="location.id" :key="location.id">{{location.name}}</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.status"
                                name="status"
                                id="status"
                            >
                                <option selected value="">Select Status</option>
                                <option value='active'>Active</option>
                                <option value='inactive'>Inactive</option>
                            </select>
                        </div>

                        <div class="input-field col s12">
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
        <div class="row">
            <div class="col">

                <!-- Listing all project Units -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Possession</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Builder</th>
                                    <th>Project</th>
                                    <th>Actual Location</th>
                                    <th>Sales Type</th>
                                    <th>distance In KMs</th>
                                    <th>From</th>
                                    <th>Bedroom</th>
                                    <th>Balcony</th>
                                    <th>Bathroom</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr
                                    v-for="(projectUnit, index) in getProjectUnits.data" :key="projectUnit.id"
                                    :class="{'bg-warning inactive' : !projectUnit.status}"
                                >
                                    <td>{{index + getProjectUnits.from}}</td>
                                     <td>{{projectUnit.type}}</td>
                                     <td>{{projectUnit.project.possession}}</td>
                                     <td>{{projectUnit.size}}</td>
                                    <td>{{projectUnit.price}}</td>
                                   <td>
                                        <span v-if="projectUnit.project.projectBuilder"> {{projectUnit.project.projectBuilder.name}}</span>
                                        <span v-else>{{projectUnit.project.builder}}</span>
                                    </td>
                                    <td>{{projectUnit.project.name}}</td>
                                    <td>
                                        <span v-if="projectUnit.project.projectLocation"> {{projectUnit.project.projectLocation.name}}</span>
                                        <span v-else>{{projectUnit.project.location}} </span>
                                    </td>
                                    <td>{{projectUnit.sales_type}}</td>
                                    <td>{{projectUnit.project.distance_in_kms}}</td>
                                     <td>
                                        <span v-if="projectUnit.project.nearby_location"> {{projectUnit.project.nearby_location.name}}</span>
                                        <span v-else>-</span>
                                    </td>
                                    <td>{{projectUnit.bedroom}}</td>
                                     <td>{{projectUnit.balcony}}</td>
                                    <td>{{projectUnit.bathroom}}</td>
                                    <td>

                                        <div class="custom-control custom-switch" v-if="getAuth.email != projectUnit.email">
                                            <input
                                                @click="statusChange(projectUnit.id, 'project_units')"
                                                type="checkbox"
                                                :checked="(projectUnit.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="projectUnit.id"
                                            />
                                            <label class="custom-control-label" :for="projectUnit.id"></label>
                                        </div>
                                    </td>
                                    <td>{{projectUnit.created_at}}</td>
                                    <td>
                                        <!-- <router-link
                                            v-if="hasPermission['read-project-units']"
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'projectUnits.show', params: { id: projectUnit.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link> -->
                                        <router-link
                                            v-if="hasPermission['update-project-units']"
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'projectUnits.edit', params: { id: projectUnit.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="hasPermission['delete-project-units']"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'projectUnits.delete', params: { id: projectUnit.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-danger">delete</i>
                                        </router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
                <pagination show=4 :data="getProjectUnits" @updatePagination="updatePagination"> </pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                title_links : [
                    {router_name : 'projectUnits.create', router_hover : 'Add Project Unit', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                projectUnit: {},
                pagination: {},
                search : {
                    type: "",
                    startPrice: "",
                    endPrice: "",
                    size: "",
                    location: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getProjectUnits", "getErrors", "getAuth", "getLocations", "getSearchFilter", "hasPermission"]),

            reload(){
                return {type : 'fetchProjectUnits', payload : {next_page: this.getProjectUnits.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchAllActiveLocations");
            this.$store.dispatch("fetchProjectUnits", {
                next_page: this.getProjectUnits.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchProjectUnits", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchProjectUnits", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ path: 'projectUnits' });
                this.search =  {
                    type: "",
                    size: "",
                    startPrice: "",
                    endPrice: "",
                    location: "",
                    status: ""
                };
                this.$store.dispatch("fetchProjectUnits", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
