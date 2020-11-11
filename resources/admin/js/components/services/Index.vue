<template>
    <div>
        <service-create :service="service" v-if="showForm" @reset="reset"></service-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Services
                <span @click="addService">
                    <add-new-button title="Add New Service" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(service, index) in getServices.data" :key="index">
                    <td>{{index + getServices.from}}</td>
                    <td>
                        {{service.name}}<br>
                        <small>{{service.slug}}</small>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(service.id, 'services')"
                                type="checkbox"
                                :checked="(service.status === 'active' ? true : false)"
                                class="custom-control-input "
                                :id="service.id"
                            />
                            <label class="custom-control-label" :for="service.id"></label>
                        </div>
                                                   
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editService(service)">edit</i>
                        <i class="material-icons text-danger" @click="deleteService(service)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getServices" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    

    import { mapGetters } from "vuex";
    import ServiceCreate from './create';
    export default {
        components: { ServiceCreate },
        data(){
            return {
                service : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchServices", {
                next_page: this.getServices.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getServices", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchServices", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editService(service){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.service = service;
            },
            addService(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.service = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.service = {};
            },
            deleteService(service){
                if(confirm('Are you sure you want to remove this service?')){
                    this.$store.dispatch('deleteService', service);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
