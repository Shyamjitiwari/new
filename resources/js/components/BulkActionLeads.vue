<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#assignmentModal">Assign</button>
                <button v-if="hasPermission['update-transfer-owner-leads']" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#transferModal">Transfer Ownership</button>
                <button @click="reset()" class="btn btn-sm btn-outline-danger">Reset</button>
            </div>
        </div>

        <!-- Assignment Modal -->
        <div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="assignmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignmentModalLabel">Assign Users</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="assignLeads()">
                            <div class="row">
                                <div class="col-md col-sm-12">
                                    <div class="form-group">
                                        <label >Users</label>
                                        <select class="form-control" v-model="user" required >
                                            <option v-for="user in getActiveUsers" :key="user.id" :value="user.id">{{user.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <submit-button status="Assign Users"> </submit-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Modal -->
        <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferModalLabel">Transfer Ownership</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createLead" @submit.prevent="transferLeads()">
                            <div class="row">
                                <div class="col-md col-sm-12">
                                    <div class="form-group">
                                        <label >Users</label>
                                        <select class="form-control" v-model="user" required>
                                            <option v-for="user in getActiveUsers" :key="user.id" :value="user.id">{{user.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <submit-button status="Transfer"> </submit-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        props: ['leads'],
        data(){
            return {
                user : {},
                
            }
        },
        computed:{
            ...mapGetters(["getErrors", "getMessage", "getLead", "getActiveUsers", "hasPermission"]),
        },
        created(){
            this.$store.dispatch('fetchAllActiveUsers');
        },
        methods:{
            transferLeads(){
                this.$store.dispatch('changeLeadOwnerBulk', {
                    leads : this.leads,
                    user : this.user
                });
                $('#transferModal').modal('hide');
                this.reset();
            },
            assignLeads(){
                this.$store.dispatch('assignLeadsBulk', {
                    leads : this.leads,
                    user : this.user
                });
                $('#assignmentModal').modal('hide');
                this.reset();
            },
            reset(){
                this.$emit('unSelectLeads');
            }
        }

    }
</script>
