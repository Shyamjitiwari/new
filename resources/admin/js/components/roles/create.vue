<template>
    <div>
        <h3 v-if="!isEditable">Add Role</h3>
        <h3 v-else>Edit Role</h3>
        <form id="createUser" @submit.prevent="createRole()" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" v-model="role.name" class="form-control" placeholder="Name..."/>
                        <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-sm bg-primary m-1 text-white" v-for="permission in role.permissions">
                        {{permission.name}}
                        <span @click="removePermission(permission)" class="badge badge-dark">x</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <select @change="updatePermissions(selectPermission)" class="form-control" v-model="selectPermission">
                            <option v-for="permission in getActivePermission" :value="permission">{{permission.name}}</option>
                        </select>
                    </div>
                </div>
                <span v-if="getErrors.permissions" class="text-danger">{{getErrors.permissions[0]}}</span>
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
        props : ['role'],
        data(){
            return {
                permissions : [],
                selectPermission : {}
            }
        },
        created() {
            this.$store.dispatch('fetchActivePermissions');
        },
        computed: {
            ...mapGetters(["getErrors", 'getActivePermission', 'isEditable']),
        },
        methods : {
            isDuplicate(data, dataArray) {
                for(let i = 0; i < dataArray.length; i++){
                    if(data.name == dataArray[i].name) {
                        alert('Permission already selected');
                        return true;
                    }
                }
                return false;
            },
            updatePermissions(permission){
                if(this.role.permissions == undefined){
                    this.role.permissions = [];
                    this.role.permissions.push(permission);
                } else if (!this.isDuplicate(permission, this.role.permissions)) {
                    this.role.permissions.push(permission);
                }
                this.selectPermission = {};
            },
            removePermission(permission){
                this.role.permissions.splice(this.role.permissions.indexOf(permission), 1);
            },
            createRole() {
                let _this = this;
                _this.$store.dispatch("dispatchCreateRole", {
                    'role': _this.role,
                })

            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
