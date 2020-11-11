<template>
    <div>
        <page-title
            title="Project"
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
                                placeholder="Project Name..."
                                id="name"
                                name="name"
                                v-model="search.name"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
                        </div>
                        <div class="input-field">
                             <select
                                class="form-control form-control-sm"
                                v-model="search.builder_id"
                                name="builder_id"
                                id="builder_id"
                            >
                                <option selected value="">Select Builder</option>
                                <option v-for="builder in getBuildersActive" :value="builder.id" :key="builder.id">{{builder.name}}</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <input
                                placeholder="City..."
                                id="city"
                                name="city"
                                v-model="search.city"
                                type="text"
                                class="form-control validate form-control-sm"
                            />
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

                <!-- Listing all projects -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark bg-danger">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th></th>
                                    <th>Completion Status</th>
                                    <th>Builder</th>
                                    <th>Location</th>
                                    <th>Possession</th>
                                    <th>Distance</th>
                                    <th>From</th>
                                    <th>Nearby Location</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(project, index) in getProjects.data" :key="project.id"
                                    :class="{'bg-warning inactive' : !project.status}"
                                >
                                    <td>{{index + getProjects.from}}</td>
                                    <td>{{project.name}}</td>
                                    <td>
                                        <span class="badge badge-primary">{{project.leadhistories_count}}</span>
                                    </td>
                                    <td>{{project.completion_status}}</td>
                                    <td>
                                        <span v-if="project.builder"> {{project.builder.name}}</span>
                                         <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="project.location"> {{project.location.name}}</span>
                                         <span v-else="">-</span>
                                    </td>
                                    <td>{{project.possession}}</td>
                                    <td>{{project.distance_in_kms}}</td>
                                    <td>{{project.from}}</td>
                                    <td>  <span v-if="project.nearby_location"> {{project.nearby_location.name}}</span>
                                         <span v-else=""> - </span>
                                    </td>
                                    <td>

                                        <div class="custom-control custom-switch" v-if="getAuth.email != project.email">
                                            <input
                                                @click="statusChange(project.id, 'projects')"
                                                type="checkbox"
                                                :checked="(project.status === 'active' ? true : false)"
                                                class="custom-control-input"
                                                :id="project.id"
                                            />
                                            <label class="custom-control-label" :for="project.id"></label>
                                        </div>
                                    </td>
                                    <td>{{project.created_at}}</td>
                                    <td>
                                        <router-link
                                            v-if="hasPermission['read-projects']"
                                            title="view"
                                            tag="a"
                                            :to="{ name: 'projects.show', params: { id: project.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-success">visibility</i>
                                        </router-link>
                                        <router-link
                                            v-if="hasPermission['update-projects']"
                                            title="Edit"
                                            tag="a"
                                            :to="{ name: 'projects.edit', params: { id: project.id }}"
                                            exact
                                        >
                                            <i class="material-icons text-warning">edit</i>
                                        </router-link>
                                        <router-link
                                            v-if="hasPermission['delete-projects']"
                                            title="Delete"
                                            tag="a"
                                            :to="{ name: 'projects.delete', params: { id: project.id }}"
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
                <pagination show=4 :data="getProjects" @updatePagination="updatePagination"> </pagination>
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
                    {router_name : 'projects.create', router_hover : 'Add Project', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                project: {},
                pagination: {},
                search : {
                    name: "",
                    builder_id: "",
                    city: "",
                    status: ""
                }
            };
        },

        computed: {
            ...mapGetters(["getProjects", "getBuildersActive", "getErrors", "getAuth", "getSearchFilter", "hasPermission"]),

            reload(){
                return {type : 'fetchProjects', payload : {next_page: this.getProjects.current_page, search: this.search}};
            },
        },

        created() {
            this.$store.state.showReloadIcon = true;
            this.$store.state.showSearchIcon = true;
            this.$store.dispatch("fetchAllActiveBuilders");
            this.$store.dispatch("fetchProjects", {
                next_page: this.getProjects.current_page,
                search: this.search
            });
        },

        methods: {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchProjects", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            withSearch(s) {
                this.search = s;
                this.$store.dispatch("fetchProjects", {
                    next_page: 1,
                    search: this.search
                });
            },
            reset() {
                this.$router.push({ path: 'projects' });
                this.search =  {
                    name: "",
                    builder_id: "",
                    city: "",
                    status: ""
                };
                this.$store.dispatch("fetchProjects", {
                    next_page: 1,
                    search: this.search
                });
            }
        }
    };
</script>
