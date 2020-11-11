<template>
    <div>
        <page-title
            title="Add Lead Status"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLeadStatus" @submit.prevent="createLeadStatus(lead_status)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="lead_status.name"
                                            class="form-control"
                                            id="name"
                                            placeholder="Name..."
                                        />
                                        <span v-if="getErrors.name !== ''" class="text-danger">{{getErrors.name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Parent Lead Status (Optional)</label>
                                        <select class="form-control" v-model="lead_status.parent_id">
                                            <option :selected="true" :disabled="true" value="">Select Lead Status</option>
                                            <option v-for="lead_status in getParentLeadStatuses" :value="lead_status.id">{{lead_status.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Background Color</label>
                                        <input
                                            type="text"
                                            v-model="lead_status.bg"
                                            class="form-control"
                                            placeholder="Background Color..."
                                            required
                                        />
                                        <span v-if="getErrors.bg !== ''" class="text-danger">{{getErrors.bg}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Text Color</label>
                                        <input
                                            type="text"
                                            v-model="lead_status.text"
                                            class="form-control"
                                            placeholder="Text Color..."
                                            required
                                        />
                                        <span v-if="getErrors.text !== ''" class="text-danger">{{getErrors.text}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <span class="label-status text-uppercase" :style="{ color: lead_status.text, background: lead_status.bg }">
                                        {{lead_status.name}}
                                    </span>
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
                lead_status: {
                    parent_id : ''
                },
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "getParentLeadStatuses"])
        },
        created() {
            this.lead_status = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchParentLeadStatuses");
        },
        methods: {
            createLeadStatus(lead_status) {
                this.$store.dispatch("dispatchCreateLeadStatus",lead_status);
                this.reset();
            },
            reset() {
                this.lead_status = {};
                //resetting errors adn error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
