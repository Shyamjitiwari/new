<template>
    <div>
        <page-title v-if="hasPermission['update-attendances']"
            title="Attendances"
            :title_links='title_links'
            :reload="reload"
        >
        </page-title>
        <page-title v-else
            title="Attendances"
            :reload="reload"
        >
        </page-title>
         <div class="row" v-if="hasPermission['read-attendances']">
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                           
                        <div class="row">
                            <div class="col-2">
                                <input type="month" v-model="month">
                            </div>
                        
                            <div v-if="getAuth.id ==1 || getAuth.id ==2" class="col-2">
                                <select class="form-control" v-model="user">
                                    <option value="" disabled selected>--User--</option>
                                    <option v-for="(user,index) in getActiveUsers" :value="user.id" :key="index">{{user.name}}</option>
                                </select>
                             </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary" type="button" @click="filterUserAttendances">Filter</button> 
                                 <button class="btn btn-sm btn-danger" type="button" @click="resetFilter">Reset</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>User</th>
                                                <th v-for="(date,index) in getUserAttendances.dates" :key="index">{{date}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                              <tr class="text-center"  v-for="(user,index) in getUserAttendances.users" :key="index">
                                                <td>{{user.name}}</td>
                                                <td v-for="(attendance,index) in user.attendances" :key="index">
                                                    <span class="badge badge-danger" v-if="attendance.absent">Absent</span> 
                                                    <span class="badge badge-light" v-else>{{attendance.check_in}} <br> {{attendance.check_out ? attendance.check_out : '-'}}</span>
                                                    </td>
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
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data(){
            return {
                title_links : [
                    {router_name : 'attendances.create', router_hover : 'Mark User Attendance', type : 'icon', icon:'add', 'class' : 'text-success'},
                      {router_name : 'attendances.bulk_create', router_hover : 'Mark User Absent ', type : 'icon', icon:'add', 'class' : 'text-success'},
                ],
                month: "",
                user: "",
            }
        },
        computed : {
          ...mapGetters(['getUserAttendances', "getAuth", 'getActiveUsers','hasPermission']),

            reload(){
                //return {type : 'fetchUserAttendances', payload : {next_page: this.getProjects.current_page, search: this.search}};
            },
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchAllActiveUsers');
            this.$store.dispatch('fetchUserAttendances',{
                month: this.month,
                user: this.user
            });
        },
        methods:{
            filterUserAttendances(){
                 this.$store.dispatch('fetchUserAttendances', {
                    month : this.month,
                    user:this.user
                });
            },
            resetFilter() {
                this.month = "";
                this.user = "";
                this.filterUserAttendances();
            }
        }
    }
</script>
