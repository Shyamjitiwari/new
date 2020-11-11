<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-borderless">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Project</th>
                                    <th>Remarks</th>
                                    <th>Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="child in getLeadChildren">
                                    <td>{{child.name}}</td>
                                    <td>{{child.email}}</td>
                                    <td>{{child.lead_source.name}}</td>
                                    <td>{{child.lead_status.name}}</td>
                                    <td>{{child.project}}</td>
                                    <td>{{child.remarks}}</td>
                                    <td>{{child.created_at}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        props : ['lead'],
        data(){
            return {
            }
        },
        computed:{
            ...mapGetters(["getErrors", "getMessage", "getLeadChildren"]),
        },
        created(){
            this.getChildren();
        },
        methods:{
            getChildren(){
                this.$store.dispatch('fetchLeadChildren', {'id' : this.lead.id})
            },
            reset(){
            }
        }

    }
</script>
