<template>
    <div>
        <h3 v-if="!isEditable">Add User</h3>
        <h3 v-else>Edit User</h3>
        <form id="createUser" @submit.prevent="createUser()" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" v-model="user.name" class="form-control" placeholder="Name..."/>
                        <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" v-model="user.email" class="form-control" placeholder="Email..."/>
                        <span v-if="getErrors.email" class="text-danger">{{getErrors.email[0]}}</span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="number" v-model="user.mobile" class="form-control" placeholder="Mobile..."/>
                        <span v-if="getErrors.mobile" class="text-danger">{{getErrors.mobile[0]}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-control" v-model="user.role_id">
                            <option selected disabled>Select Role</option>
                            <option v-for="role in getActiveRoles" :value="role.id">{{role.name}}</option>
                        </select>
                    <span v-if="getErrors.role_id" class="text-danger">{{getErrors.role_id[0]}}</span>
                    </div>
                </div>
                <div class="col" v-if="!isEditable">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" v-model="user.password" class="form-control" placeholder="Password..."/>
                        <span v-if="getErrors.password" class="text-danger">{{getErrors.password[0]}}</span>
                    </div>
                </div>
            </div>
            <submit-button v-if="!isEditable" label="Add"> </submit-button>
            <update-button v-else label="Update"> </update-button>
            <span v-on:click="reset()">
                <reset-button label="Close"></reset-button>
            </span>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        props : ['user', 'isEditable'],
        data(){
            return {}
        },
        created() {
            this.$store.dispatch('fetchActiveRoles');
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveRoles']),
        },
        methods : {
            createUser() {
                let _this = this;
                _this.$store.dispatch("dispatchCreateUser", {
                    'user': _this.user,
                })

            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
