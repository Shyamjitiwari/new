<template>
    <div>
        <page-title
            title="Add Lead Source"
        >
        </page-title>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-0">
                        <form id="createLeadSource" @submit.prevent="createLeadSource(lead_source)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            v-model="lead_source.name"
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
                lead_source: {},
            };
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage"])
        },
        created() {
            this.lead_source = {};
            this.$store.state.errors = {};
            this.$store.state.showSearchIcon = false;
        },
        methods: {
            createLeadSource(lead_source) {
                this.$store.dispatch("dispatchCreateLeadSource",lead_source);
                this.reset();
            },
            reset() {
                this.lead_source = {};
                //resetting errors and error messages
                this.$store.dispatch('setResetData');
            }
        }
    };
</script>
