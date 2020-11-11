<template>
    <div>
        <!-- v-if="hasPermission['admin-reports']" -->
        <!-- <enquiry-reply :enquiry="enquiry" v-if="showForm" @reset="reset"></enquiry-reply> -->
        <div class="row" >
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#multiCollapseComment">
                            
                            <h5 class="cursor-pointer">Comments</h5>
                        </span>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseComment">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Commentable-type</th>
                                                <th>Commentable-id</th>
                                                <th>Parent-id</th>
                                                <th>User Name</th>
                                                <th>Comment Desc</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center" v-for="(comment,index) in getComments.data" :key="index" >
                                                    
                                                    <td>{{index + getComments.from}}</td>
                                                    <td>{{comment.commentable_type}}</td>
                                                    <td>{{comment.commentable_id}}</td>
                                                    <td>{{comment.parent_id}}</td>
                                                    <td>{{comment.name}}</td>
                                                    <td>{{comment.description}}</td>
                                                    <td>
                                                        <div class="custom-control custom-switch">
                                                            <input
                                                            @click="statusChange(comment.id, 'comments')"
                                                            type="checkbox"
                                                            :checked="(comment.status === 'active' ? true : false)"
                                                            class="custom-control-input "
                                                            :id="comment.id"
                                                            />
                                                            <label class="custom-control-label" :for="comment.id"></label>
                                                        </div>
                                                    </td>
                                                    <td> 
                                                        <!-- <i class="material-icons text-warning" @click="reply(enquiry)" >reply</i> -->
                                                        <i class="material-icons text-danger" @click="deleteComment(comment)">delete</i>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <pagination show=4 :data="getComments" @updatePagination="updatePagination"></pagination>
                                    </div>
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

    import { ToggleButton } from 'vue-js-toggle-button'
    Vue.component('ToggleButton', ToggleButton)

    export default {
        data(){
            return {
                comment : {},
                pagination: {},

                // start_date : '',
                // end_date : '',
                
                search : {
                    name: "",
                }
            }
        },
        computed : {
          ...mapGetters(["getErrors", "getComments", "showForm"])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchComments", {
                next_page: this.getComments.current_page,
                search: this.search
            });
        },
        methods:{
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchComments", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            deleteComment(comment){
                if(confirm('Are you sure you want to delete this Comment?')){
                    this.$store.dispatch('deleteComment', comment);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
