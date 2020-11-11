<template>
    <div>
        <page-title
            :title="'Edit Location: '+ getLocation.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="editProject" @submit.prevent="editLocation" enctype="multipart/form-data">
                             <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="getLocation.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="pincode">PIN Code</label>
                                        <input
                                            type="text"
                                            v-model="getLocation.pincode"
                                            class="form-control"
                                            id="pincode"
                                            placeholder="PIN Code..."
                                        />
                                        <span v-if="getErrors.pincode !== ''" class="text-danger">{{getErrors.pincode}}</span>
                                    </div>
                                </div>
                                  <div class="col-md-4 col-sm-12" v-if="getLocation.parent_id">

                                    <div class="form-group">
                                        <label>Parent Location (Optional)</label>
                                        <select class="form-control" v-model="getLocation.parent_id">
                                            <option :selected="location.parent_id = ''" :disabled="true" value="">Select Parent</option>
                                            <option v-for="parent in getParentLocations" :value="parent.id" :key="parent.id">{{parent.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea
                                            type="text"
                                            v-model="getLocation.address"
                                            class="form-control"
                                            id="address"
                                            placeholder="Address..."
                                        ></textarea>
                                        <span v-if="getErrors.address !== ''" class="text-danger">{{getErrors.address}}</span>
                                    </div>
                                </div>
                            </div>
                            <submit-button status="Update"></submit-button>
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
                savingState: false,
                location: {},
                locationtypes: ["admin", "location"],
                title_links : [
                    {router_name : 'locations.create', router_params: '', router_hover : 'Add Location', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'locations.show', router_params: this.$route.params.id, router_hover : 'Show Location', type : 'icon', icon:'visibility', 'class' : 'text-primary'},
                ],
                reload: {type : 'fetchEditLocation', payload : this.$route.params.id}
            };
        },
        computed: {
            ...mapGetters(["getLocation" ,"getParentLocations", "getErrors", "getMessage"]),
        },
        created() {
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
             this.$store.dispatch("fetchParentLocations");
            this.$store.dispatch("fetchEditLocation", this.$route.params.id);
        },
        methods: {
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.location.image_name = e.target.result;
                }
            },
            editLocation() {
                let self = this;
                self.$store.dispatch("dispatchEditLocation",self.getLocation)
                ;
            }
        }
    };
</script>
