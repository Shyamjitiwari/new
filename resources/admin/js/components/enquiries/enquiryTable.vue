<template>
    <div>
        <!-- v-if="hasPermission['admin-reports']" -->
        <enquiry-reply :enquiry="enquiry" v-if="showForm" @reset="reset"></enquiry-reply>
        <div class="row" >
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#multiCollapseExample">
                            
                            <h5 class="cursor-pointer">Enquiries</h5>
                        </span>
                        <div class="row">
                            <!-- <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="start_date" >
                            </div>
                            TO
                            <div class="col-2">
                                <input class="form-control form-control-sm" type="date" v-model="end_date" >
                            </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterEnquiry">Filter</button>
                                <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Number</th>
                                                <th>Subject</th>
                                                <th>Description</th>
                                                <th>Read At</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(enquiry,index) in getEnquiries.data" :key="index" >
                                                    
                                                    <td>{{index + getEnquiries.from}}</td>
                                                    <td>{{enquiry.name}}</td>
                                                    <td>{{enquiry.email}}</td>
                                                    <td>{{enquiry.mobile}}</td>
                                                    <td>{{enquiry.subject}}</td>
                                                    <td>{{enquiry.description}}</td>
                                                    <td>{{enquiry.read_at}}</td>
                                                    <td> <i class="material-icons text-warning" @click="showEnquiry(enquiry)" data-toggle="modal" data-target="#exampleModalCenter">visibility</i>
                                                        <i class="material-icons text-warning" @click="reply(enquiry)" >reply</i>
                                                        <i class="material-icons text-danger" @click="deleteEnquiry(enquiry)">delete</i>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <pagination show=4 :data="getEnquiries" @updatePagination="updatePagination"></pagination>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Enquiry Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <enquiry-show :enquiry="enquiry" v-if="showEnquiryFrom" @reset="reset"></enquiry-show>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- Modal Ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import EnquiryReply from './reply';
    import EnquiryShow from './show';
    export default {
        components: { 
            EnquiryReply,
            EnquiryShow
        },
        data(){
            return {
                enquiry : {},
                pagination: {},
                showEnquiryFrom: false,
                // start_date : '',
                // end_date : '',
                
                search : {
                    name: "",
                }
            }
        },
        computed : {
          ...mapGetters(["getErrors", "getEnquiries", "showForm"])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEnquiries", {
                next_page: this.getEnquiries.current_page,
                search: this.search
            });
        },
        methods:{
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchEnquiries", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editEnquiry(enquiry){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.enquiry = enquiry;
            },
            reply(enquiry){
                this.$store.commit('showForm', true);
                this.enquiry = enquiry;
                if(!enquiry.read_at)
                this.$store.dispatch('mark_read_at',{
                    'enquiry_id': enquiry.id,
                });

            },
            showEnquiry(enquiry){

                this.showEnquiryFrom = true;
                this.enquiry = enquiry;
                if(!enquiry.read_at)
                this.$store.dispatch('mark_read_at',{
                    'enquiry_id': enquiry.id,
                });
            },
            reset(){
                this.$store.commit('showForm', false);
                this.showEnquiryFrom = false;
                this.enquiry = {};
            },
            deleteEnquiry(enquiry){
                if(confirm('Are you sure you want to delete this enquiry?')){
                    this.$store.dispatch('deleteEnquiry', enquiry);
                }
            },

            // filterEnquiry(){
            //     this.$store.dispatch('fetchEnquiries', {
            //         start_date : this.start_date,
            //         end_date:this.end_date,
            //         });
            // },
            // resetFilter() {
            //     this.start_date = {};
            //     this.end_date = {};
            //     this.filterEnquiry();
            // }
        }
    }
</script>
