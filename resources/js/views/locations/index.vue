<template>
    <div>
        <page-title
            title="Location"
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
                                placeholder="Location Name..."
                                id="name"
                                name="name"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                      
                        <div class="input-field">
                            <input
                                placeholder="PIN Code..."
                                id="pincode"
                                name="pincode"
                                v-model="search.pincode"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                           <div class="input-field">
                            <select
                                class="form-control form-control-sm"
                                v-model="search.parent_id"
                                name="parent_id"
                                id="parent_id"
                            >
                                <option selected value="">Select Parent Location</option>
                                <option v-for="parent in getParentLocations" :value="parent.id" :key="parent.id">{{parent.name}}</option>
                                
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

                <!-- Listing all locations -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th></th>
                                    <th>Pin Code</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(location, index) in getLocations.data" :key="location.id"
                                    :class="{'bg-warning inactive' : !location.status}"
                                >
                                    <td>{{index + getLocations.from}}</td>
                                    <td>{{location.name}}</td>
                                    <td>
                                        <span class="badge badge-primary">{{location.children_count}}</span>
                                    </td>
                                    <td>{{location.pincode}}</td>
                                    <td>{{location.address}}</td>
                                    <td>

                                        <div class="custom-control custom-switch" v-if="getAuth.email != location.email">
                                            <input
                                                @click="statusChange(location.id, 'locations')"
                                                type="checkbox"
                                                :checked="(location.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="location.id"
                                            />
                                            <label class="custom-control-label" :for="location.id"></label>
                                        </div>
                                    </td>
                                    <td>{{location.created_at}}</td>
                                    <td>
                                        <router-link
                                            v-if="hasPermission['read-locations']"
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'locations.show', params: { id: location.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                            v-if="hasPermission['update-locations']"
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'locations.edit', params: { id: location.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="hasPermission['delete-locations']"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'locations.delete', params: { id: location.id }}"
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
                <pagination show=4 :data="getLocations" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'locations.create', router_hover : 'Add Project', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                location: {},
                pagination: {},
                search : {
                    name: "",
                    pincode: "",
                    parent_id: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getLocations", "getParentLocations", "getErrors", "getAuth", "getSearchFilter", "hasPermission"]),

            reload(){
                return {type : 'fetchLocatinos', payload : {next_page: this.getLocations.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchParentLocations");
            this.$store.dispatch("fetchLocations", {
                next_page: this.getLocations.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchLocations", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchLocations", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ path: 'locations' });
                this.search =  {
                    name: "",
                    pincode: "",
                    parent_id: "",
                    status: ""
                };
                this.$store.dispatch("fetchLocations", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
