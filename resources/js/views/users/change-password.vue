<template>
        <div>
            <page-title
                :title="'Change Password : ' + getUser.name"
            >
            </page-title>
            <div class="row">
                <div class="col">
                    <!-- Listing all users -->
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="changePassword" >
                                <div class="form-group">
                                    <label>Password</label>
                                    <input
                                        type="password"
                                        v-model="getUser.password"
                                        class="form-control"
                                        placeholder="Enter New Password"
                                    />
                                    <span
                                        v-if="getErrors.password !== ''"
                                        class="text-danger"
                                        v-text="getErrors.password"
                                    > </span>
                                </div>
                                <submit-button status="Update Password"> </submit-button>
                            </form>
                        </div>
                    </div>
                    <br />
                </div>
            </div>
        </div>
    </template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data(){
          return {
              user: {},
          }
        },
        computed: {
            ...mapGetters(["getUser", "getErrors", "getMessage"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchEditUser", this.$route.params.id);
        },
        methods:{
            changePassword() {
                this.$store.dispatch("changePassword", this.getUser);
            },
        }
    }
</script>
