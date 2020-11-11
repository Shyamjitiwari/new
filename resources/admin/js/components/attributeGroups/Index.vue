<template>
    <div>
        <group-create :attributeGroup="attributeGroup" v-if="showForm" @reset="reset"></group-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Attribute Groups
                <span @click="addAttributeGroup">
                    <add-new-button title="Add New Attribute Group" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(attributeGroup, index) in getAttributeGroups.data" :key="attributeGroup.id">
                    <td>{{index + getAttributeGroups.from}}</td>
                    <td>
                        {{attributeGroup.name}}<br>
                    </td>
                   
                   <td>{{attributeGroup.description}} </td>
                   <td>{{attributeGroup.sort}} </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(attributeGroup.id, 'attributes')"
                                type="checkbox"
                                :checked="(attributeGroup.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="attributeGroup.id"
                            />
                            <label class="custom-control-label" :for="attributeGroup.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editAttributeGroup(attributeGroup)">edit</i>
                        <i class="material-icons text-danger" @click="deleteAttributeGroup(attributeGroup)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getAttributeGroups" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import GroupCreate from './create';
    export default {
        components: { GroupCreate },
        data(){
            return {
                attributeGroup : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchAttributeGroups", {
                next_page: this.getAttributeGroups.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getAttributeGroups", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchAttributeGroups", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editAttributeGroup(attributeGroup){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.attributeGroup = attributeGroup;
            },
            addAttributeGroup(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.attributeGroup = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.attributeGroup = {};
            },
            deleteAttributeGroup(attributeGroup){
                if(confirm('Are you sure you want to delete this attributeGroup?')){
                    this.$store.dispatch('deleteAttributeGroup', attributeGroup);
                }
            }
        }
    }
</script>
