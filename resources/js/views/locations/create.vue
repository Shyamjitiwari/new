<template>
    <div>
        <page-title
            title="Add Location"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLocation" @submit.prevent="createLocation(location)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="location.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="pin_code">Pin Code</label>
                                        <input
                                            type="text"
                                            v-model="location.pincode"
                                            class="form-control"
                                            id="pin_code"
                                            placeholder="Pin Code..."
                                        />
                                        <span v-if="getErrors.pincode !== ''" class="text-danger">{{getErrors.pincode}}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Parent (optional)</label>
                                        <select class="form-control" v-model="location.parent_id">
                                            <option value="" disabled selected>--Select Parent--</option>
                                            <option v-for="(parent,index) in getParentLocations" :value="parent.id" :key="index">{{parent.name}}</option>
                                        </select>
                                        <span v-if="getErrors.parent_id !== ''" class="text-danger">{{getErrors.parent_id}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea
                                            type="text"
                                            v-model="location.address"
                                            class="form-control"
                                            id="address"
                                            placeholder="Address..."
                                        ></textarea>
                                        <span v-if="getErrors.address !== ''" class="text-danger">{{getErrors.address}}</span>
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
            ...mapGetters(["getErrors", "getMessage", "hasPermission",  "getParentLocations"])
        },
        created() {
            this.location = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
             this.$store.dispatch("fetchParentLocations");
        },
        methods: {
            createLocation(location) {
                this.$store.dispatch("dispatchCreateLocation",location);
                
            },
            reset() {
                this.location = {};
                //resetting errors adn error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
