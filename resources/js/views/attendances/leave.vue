<template>
    <div>
        <page-title
            title="Mark User Absent"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createUserAttendance" @submit.prevent="markUserAbsent(leave)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="date">From</label>
                                        <input
                                            type="date"
                                            v-model="leave.start_date"
                                            class="form-control"
                                            id="date"
                                            placeholder="Date..."
                                        />
                                        <span v-if="getErrors.start_date !== ''" class="text-danger">{{getErrors.date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="date">To</label>
                                        <input
                                            type="date"
                                            v-model="leave.end_date"
                                            class="form-control"
                                            id="date"
                                            placeholder="Date..."
                                        />
                                        <span v-if="getErrors.end_date !== ''" class="text-danger">{{getErrors.date}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_name">User </label>
                                       <select v-model="leave.user_id" class="form-control">
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
                leave: {},
            };
        },
        computed: {
            ...mapGetters(["getErrors","getActiveUsers", "getMessage"])
        },
        created() {
            this.leave = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchAllActiveUsers');
        },
        methods: {
            markUserAbsent(leave) {
                this.$store.dispatch("markUserAbsentByAdmin",leave);
              
            },
            reset() {
                this.leave = {};
                //resetting errors and error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
