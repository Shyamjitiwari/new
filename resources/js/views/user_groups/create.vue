<template>
    <div>
        <page-title
            title="Add User Group"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createUserGroup" @submit.prevent="createUserGroup(userGroup)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="userGroup.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
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
                location: {},
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "hasPermission",])
        },
        created() {
            this.userGroup = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
           
        },
        methods: {
            createUserGroup(userGroup) {
                this.$store.dispatch("dispatchCreateUserGroup",userGroup);
                
            },
            reset() {
                this.userGroup = {};
                //resetting errors adn error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
