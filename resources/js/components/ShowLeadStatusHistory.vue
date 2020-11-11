<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-panel p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-borderless">
                                    <thead>
                                    <tr>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Follow Up</th>
                                        <th>Remarks</th>
                                        <th>By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for='history in lead.lead_history' :key='history.id'>
                                        <td>{{history.created_at}}</td>
                                        <td>
                                            <div v-if="history.historical_type == 'App\\LeadStatus'">
                                                <span
                                                    class="label-status text-uppercase"
                                                    :style="{'background' : history.historical.bg, 'color' : history.historical.text}"
                                                >{{history.historical.name}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div v-if="history.follow_up_at">Follow up:
                                                <span>{{history.follow_up_at}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col">Remarks: {{history.remarks}}</div>
                                            <div v-if="history.projects" class="col">
                                                <span v-for="p in history.projects" class="badge badge-success">
                                                    {{p.name}}
                                                </span>
                                            </div>
                                        </td>
                                        <td><div class="col">{{history.created_by.name}}</div></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['lead']
    }
</script>
