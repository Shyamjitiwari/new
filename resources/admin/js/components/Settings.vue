<template>
    <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5" v-for="groups in getSettings">
                            <h3 class="text-capitalize">
                                {{groups[0].group}}
                            </h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-3" v-for="setting in groups" :key="setting.id">
                                    <span
                                        v-if="setting.field_type === 'text' ||
                                        setting.field_type === 'number' ||
                                        setting.field_type === 'date' ||
                                        setting.field_type === 'password' ||
                                        setting.field_type === 'url' ||
                                        setting.field_type === 'email'"
                                    >
                                        <small class="help-link">{{setting.display_name}}</small>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i :class="setting.icon"></i></div>
                                            </div>
                                        <input :type="setting.field_type" class="form-control form-control-sm" v-model="setting.value"
                                               @change="updateSetting(setting.id, setting.value)">
                                        </div>
                                    </span>
                            <span v-if="setting.field_type === 'textarea'">
                                <small class="help-link">{{setting.display_name}}</small>
                                <textarea
                                    class="form-control form-control-sm"
                                    v-model="setting.value"
                                    @change="updateSetting(setting.id, setting.value)"
                                > </textarea>
                            </span>
                                    <span v-if="setting.field_type === 'select'">
                                    <small class="help-link">{{setting.display_name}}</small>
                                    <select class="form-control form-control-sm" v-model="setting.value" @change="updateSetting(setting.id, setting.value)">
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
            ...mapGetters(["getSettings"])
        },
        created() {
            this.$store.dispatch("fetchSettings");
        },
        methods: {
            updateSetting(id, value) {
                this.$store.dispatch("updateSetting", {id:id, value: value});
            }
        }
    };
</script>
