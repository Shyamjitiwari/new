<template>
    <div>
        <page-title
            title="Mark User Attendance"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createUserAttendance" @submit.prevent="markUserAttendance(attendance)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input
                                            type="date"
                                            v-model="attendance.date"
                                            class="form-control"
                                            id="date"
                                            placeholder="Date..."
                                        />
                                        <span v-if="getErrors.date !== ''" class="text-danger">{{getErrors.date}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select v-model="attendance.type" class="form-control">
                                            <option disabled selected>Select Type</option>
                                            <option value="check_in">Check-in</option>
                                            <option value="check_out">Check-out</option>
                                            <option value="absent">Absent</option>
                                        </select>
                                        <span v-if="getErrors.type !== ''" class="text-danger">{{getErrors.type}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_name">User </label>
                                       <select v-model="attendance.user_id" class="form-control">
                                            <option disabled selected>Select User </option>
                                           <option v-for="(user,index) in getActiveUsers" :value="user.id" :key="index">{{user.name}}</option>
                                        </select>
                                        <span v-if="getErrors.user_id !== ''" class="text-danger">{{getErrors.user_id}}</span>
                                    </div>
                                </div>
                            </div>
                            <submit-button status="Add"> </submit-button>
                            <button type="button" class="btn btn-danger" v-on:click="reset()">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                attendance: {
                    'type': "",
                    'user_id': "",
                },
            };
        },
        computed: {
            ...mapGetters(["getErrors","getActiveUsers", "getMessage"])
        },
        created() {
            this.attendance = {
                'type': "",
                'user_id': "",
            };
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchAllActiveUsers');
        },
        methods: {
            markUserAttendance(attendance) {
                this.$store.dispatch("markUserAttendanceByAdmin",attendance);
              
            },
            reset() {
                this.attendance = {
                    'type': "",
                    'user_id': "",
                };
                //resetting errors and error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
