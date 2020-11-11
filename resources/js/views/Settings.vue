<template>
    <div>
        <page-title title="Settings"> </page-title>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4" v-for="setting in getSettings" :key="setting.id">
                                <span
                                    v-if="setting.field_type === 'text' ||
                                    setting.field_type === 'number' ||
                                    setting.field_type === 'date' ||
                                    setting.field_type === 'email'"
                                >
                                    <small class="help-link">{{setting.display_name}}</small>
                                    <input :type="setting.field_type" class="form-control" v-model="setting.value"
                                           @change="updateSetting(setting.id, setting.value)">
                                </span>
                                <span v-if="setting.field_type === 'textarea'">
                                    <small class="help-link">{{setting.display_name}}</small>
                                    <textarea
                                        class="form-control"
                                        v-model="setting.value"
                                        @change="updateSetting(setting.id, setting.value)"
                                    > </textarea>
                                </span>
                                <span v-if="setting.field_type === 'select'">
                                    <small class="help-link">{{setting.display_name}}</small>
                                    <select class="form-control" v-model="setting.value" @change="updateSetting(setting.id, setting.value)">
                                        <option :value="list.value" v-for="list in setting.lists" :key="list.id">{{list.value}}</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                settings: {}
            };
        },
        computed: {
            ...mapGetters(["getSettings", "getApiLoadingStatus"])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchSettings");
        },
        methods: {
            updateSetting(id, value) {
                this.$store.dispatch("updateSetting", {id:id, value: value});
            }
        }
    };
</script>
